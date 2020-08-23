<?php

$session = session();

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

if (esc($month) > 1) : ?>
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
                            <?= $i ?>
                        </td>
                    <?php endfor ?>
                </tr>
                <tr>
                    <th>Imię i nazwisko</th>
                    <th>Pula</th>
                    <th>Wykorzystane</th>
                    <th>Pozostałe</th>

                    <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                        <?php $dayOfWeek = date('w', mktime(0, 0, 0, $month, $i, $year)) ?>
                        <td>
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
                            <?php
                            for ($i = 0; $i < count($workingDaysUsed); $i++) {
                                if (esc($workingDaysUsed[$i]['user_id']) == $user['id']) {
                                    echo esc($workingDaysUsed[$i]['working_days_used']);
                                    $workingAndUsedDays -= esc($workingDaysUsed[$i]['working_days_used']);
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <?= $workingAndUsedDays ?>
                        </td>
                    </tr>
                <?php endforeach ?>

            </table>
        </div>