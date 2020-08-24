<?php

$session = session();
$accountTypeId = $session->get('account_type_id');

//In this range of years, and if someone gives wrong number of months, get default values of time
if (esc($month) <= 0 || esc($month) >= 13 || esc($year) <= 1899 || esc($year) >= 2100) {
    $month = date('n');
    $year = date('Y');
}

$dayNames = [
    0 => 'nd.',
    1 => 'pn.',
    2 => 'wt.',
    3 => 'śr.',
    4 => 'cz.',
    5 => 'pt.',
    6 => 'so.',
];

$monthNames = [
    1 => 'Styczeń',
    2 => 'Luty',
    3 => 'Marzec',
    4 => 'Kwiecień',
    5 => 'Maj',
    6 => 'Czerwiec',
    7 => 'Lipiec',
    8 => 'Sierpień',
    9 => 'Wrzesień',
    10 => 'Październik',
    11 => 'Listopad',
    12 => 'Grudzień',
];
?>

<?= \Config\Services::validation()->listErrors(); ?>
<?php if ($accountTypeId == 1) : ?>
    <form action="<?= route_to('App\Controllers\CalendarController::index ', $invite_code, $month, $year) ?>" method="post">
    <?php elseif ($accountTypeId == 2) : ?>
        <form action="<?= route_to('App\Controllers\DaysOfLeaveController::update', $invite_code) ?>" method="post">
        <?php endif ?>
        <?php if (esc($month) > 1) : ?>
            <!--Check if buttons should jump to previous/next month or year-->
            <div class="row justify-content-center">
                <a class="btn btn-secondary" href="<?= route_to('App\Controllers\CalendarController::index', esc($invite_code), esc($month) - 1, esc($year)) ?>" role="button">Poprzedni miesiąc</a>
            <?php else : ?>
                <div class="row justify-content-center">
                    <a class="btn btn-secondary" href="<?= route_to('App\Controllers\CalendarController::index', esc($invite_code), 12, esc($year) - 1) ?>" role="button">Poprzedni miesiąc</a>
                <?php endif ?>

                <h2 class="mx-5"><?= $monthNames[esc($month)] . ' ' . esc($year) ?> </h6>

                    <?php if (esc($month) < 12) : ?>
                        <a class="btn btn-secondary" href="<?= route_to('App\Controllers\CalendarController::index', esc($invite_code), esc($month) + 1, esc($year)) ?>" role="button">Następny miesiąc</a>
                    <?php else : ?>
                        <a class="btn btn-secondary" href="<?= route_to('App\Controllers\CalendarController::index', esc($invite_code), 1, esc($year) + 1) ?>" role="button">Następny miesiąc</a>
                    <?php endif ?>
                </div>

                <div class="row justify-content-center mt-5">
                    <table>
                        <tr>
                            <th colspan=4 class="text-center">Dni wolne</th>
                            <?php
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                                <td>
                                    <!-- Show number of days in calendar -->
                                    <?= $i ?>
                                </td>
                            <?php endfor ?>
                            <?php if ($accountTypeId == 1) : ?>
                                <td rowspan=2>Urlop od:</td>
                                <td rowspan=2>Urlop do:</td>
                            <?php endif ?>
                        </tr>
                        <tr>
                            <th>Imię i nazwisko</th>
                            <th>Pula</th>
                            <th>Wykorzystane</th>
                            <th>Pozostałe</th>

                            <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                                <?php $dayOfWeek = date('w', mktime(0, 0, 0, $month, $i, $year)) ?>
                                <td>
                                    <!-- Show shorcut of day name -->
                                    <?= $dayNames[$dayOfWeek] ?>
                                </td>
                            <?php endfor ?>
                        </tr>
                        <?php foreach (esc($userList) as $user) : ?>
                            <?php $workingAndUsedDays = 0 ?>
                            <tr>
                                <td>
                                    <?= $user['first_name'] . ' ' . $user['last_name'] ?>
                                </td>
                                <td class="text-center">
                                    <!--Show number of days user can use in this year-->
                                    <?php
                                    for ($i = 0; $i < count($numberOfDaysToLeave); $i++) {
                                        if (esc($numberOfDaysToLeave[$i]['user_id']) == $user['id']) {
                                            echo esc($numberOfDaysToLeave[$i]['number_of_days']);
                                            $workingAndUsedDays = esc($numberOfDaysToLeave[$i]['number_of_days']);
                                        }
                                    }
                                    ?>
                                </td>

                                <td class="text-center">
                                    <!--Show number of days user already used in this year-->
                                    <?php
                                    for ($i = 0; $i < count($workingDaysUsed); $i++) {
                                        if (esc($workingDaysUsed[$i]['user_id']) == $user['id']) {
                                            echo esc($workingDaysUsed[$i]['working_days_used']);
                                            $workingAndUsedDays -= esc($workingDaysUsed[$i]['working_days_used']);
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <!--Show number of days which left to use for user-->
                                    <?= $workingAndUsedDays ?>
                                </td>

                                <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                                    <td <?php
                                        $currentDay = (date(mktime(0, 0, 0, $month, $i, $year)));
                                        $dayOfWeek = date('w', mktime(0, 0, 0, $month, $i, $year));
                                        ?> <?php if ($dayOfWeek == 6 || $dayOfWeek == 0 || in_array($currentDay, esc($publicHolidays))) : ?> class="bg-danger">
                                    <?php else : ?>
                                        <?php foreach (esc($leaveDates) as $leave) {
                                                    if ($leave['user_id'] != $user['id']) {
                                                        continue;
                                                    } else {
                                                        if (strtotime($leave['from']) <= $currentDay && strtotime($leave['to']) >= $currentDay) {
                                                            echo 'class="bg-warning">';
                                                            break;
                                                        }
                                                    }
                                                }
                                        ?>
                                    <?php endif ?>
                                    </td>
                                <?php endfor ?>
                                <?php if ($accountTypeId == 1) : ?>
                                    <input type="hidden" name="leaveList[<?= $user['id'] ?>][user_id]" value="<?= $user['id'] ?>">';
                                    <td>
                                        <input type="date" name="leaveList[<?= $user['id'] ?>][from]" min="<?= esc($year) ?>-01-01" max="<?= esc($year) ?>-12-31">
                                    </td>
                                    <td>
                                        <input type="date" name="leaveList[<?= $user['id'] ?>][to]" min="<?= esc($year) ?>-01-01" max="<?= esc($year) ?>-12-31">
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>

                    </table>
                </div>

                <?php if ($accountTypeId == 1) : ?>
                    <input type="submit" class="btn btn-primary" value="Zapisz urlopy" />
                <?php elseif ($accountTypeId == 2) : ?>
                    <div class="mt-5">
                        <label for="number_of_days">Wpisz liczbe dni urlopu na rok <?= $year ?>:</label>
                        <input type="text" name="number_of_days" /> <br /><br />
                        <input type="hidden" name="year" value="<?= $year ?>">
                        <input type="submit" class="btn btn-primary" value="Zapisz dni" />
                    </div>
                <?php endif ?>
        </form>