<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<?= \Config\Services::validation()->listErrors(); ?>
<form action="<?=route_to('App\Controllers\Calendar::index', $invite_code, $month, $year)?>" method="post">
    <?= csrf_field() ?>

<?php
$session = session();

if (esc($month) <= 0 || esc($month) >= 13 || esc($year) <= 1899 || esc($year) >= 2100) {
    $month = date('n');
    $year = date('Y');
}

$nationalDays = [
    0 => date(mktime(0, 0, 0, 1, 1, $year)),
    1 => date(mktime(0, 0, 0, 1, 6, $year)),
    2 => date(mktime(0, 0, 0, 5, 1, $year)),
    3 => date(mktime(0, 0, 0, 5, 3, $year)),
    4 => date(mktime(0, 0, 0, 8, 15, $year)),
    5 => date(mktime(0, 0, 0, 11, 1, $year)),
    6 => date(mktime(0, 0, 0, 11, 11, $year)),
    7 => date(mktime(0, 0, 0, 12, 25, $year)),
    8 => date(mktime(0, 0, 0, 12, 26, $year)),
];

$yearMod19 = $year % 19;
$yearMod4 = $year % 4;
$yearMod7 = $year % 7;
$easterHelpA = (19 * $yearMod19 + 24) % 30;
$easterHelpB = ((2 * $yearMod4) + (4 * $yearMod7) + (6 * $easterHelpA) + 5) % 7;
$easterDay = 22 + $easterHelpA + $easterHelpB;

if ($easterDay <= 31) {
    $nationalDays[9] = date(mktime(0, 0, 0, 3, $easterDay, $year));
} else {
    $easterDay = $easterHelpA + $easterHelpB - 9;
    $nationalDays[9] = date(mktime(0, 0, 0, 4, $easterDay, $year));
}

$nationalDays[10] = strtotime("1 day", $nationalDays[9]);
$nationalDays[11] = strtotime("60 days", $nationalDays[9]);

$days = [
    0 => 'pn.',
    1 => 'wt.',
    2 => 'śr.',
    3 => 'cz.',
    4 => 'pt.',
    5 => 'so.',
    6 => 'nd.',
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

if($month > 1){
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, $month-1, $year).'">Poprzedni miesiąc</a>';
}
else
{
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, 12, $year-1).'">Poprzedni miesiąc</a>';
}
echo ' '. $monthNames[$month] . ' ' . $year . ' ';
if($month < 12){
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, $month+1, $year).'">Poprzedni miesiąc</a>';
}
else
{
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, 1, $year+1).'">Poprzedni miesiąc</a>';
}

echo '<table id="calendar">';
echo '<tr>';
echo '<th colspan=4>Dni wolne</th>';

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$date = new DateTime();
for ($i = 0; $i < $daysInMonth; $i++) {
    echo '<td>';
    echo $i + 1;
    echo '</td>';
}
echo '<td rowspan=2>Urlop od:</td>';
echo '<td rowspan=2>Urlop do:</td>';
echo '</tr>';
echo '<tr>';
echo '<th>Imię i nazwisko</th>';
echo '<th>Pula</th>';
echo '<th>Wykorzystane</th>';
echo '<th>Pozostałe</th>';

for ($i = 0; $i < $daysInMonth; $i++) {
    $dayOfWeek = date('w', mktime(0, 0, 0, $month, $i, $year));
    echo '<td>';
    echo  $days[$dayOfWeek];
    echo '</td>';
}
echo '</tr>';

foreach($users as $user)
{
    echo '<tr>';
    echo '<td>' . $user['first_name'] . ' ' . $user['last_name'] . '</td>';
    echo '<td>';
    $days = 0;
    for($i=0; $i<count($daysOfLeave); $i++){
        if($daysOfLeave[$i]['user_id'] == $user['id'])
        {
            $days = $daysOfLeave[$i]['number_of_days'];
        }
    }
    echo $days;
    echo '</td>';
    echo '<td>Wykorzystane</td>';
    echo '<td>Pula-Wykorzystane</td>';
    
    for ($i = 0; $i < $daysInMonth; $i++) {
        $day = (date(mktime(0, 0, 0, $month, $i + 1, $year)));
        $dayOfWeek = date('w', mktime(0, 0, 0, $month, $i, $year));
    
        echo '<td>';
        if ($dayOfWeek >= 5 || in_array($day, $nationalDays)) {
            echo 'X';
        }
        echo '</td>';
    }
    echo '<td>';
    echo '<input type="hidden" name="user_id[]" value="'.$user['id'].'">';
    echo '<input type="date" name="from[]">';
    echo '</td>';
    echo '<td>';
    echo '<input type="date" name="to[]">';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';
?>
<input type="submit" name="submit" value="Zapisz urlopy" />
</form>