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

<?php
$session = session();

if (esc($month) <= 0 || esc($month) >= 13 || esc($year) <= 1899 || esc($year) >= 2100) {
    $month = date('m');
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

if($month > 1){
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, $month-1, $year).'">Poprzedni miesiąc</a>';
}
else
{
    echo '<a href="'. route_to('App\Controllers\Calendar::index', $invite_code, 12, $year-1).'">Poprzedni miesiąc</a>';
}
echo ' '. $month . '-' . $year . ' ';
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
echo '<tr>';
echo '<td>' . $session->get('first_name') . ' ' . $session->get('last_name') . '</td>';
echo '<td>Pula</td>';
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
echo '</tr>';
echo '</table>';

?>




<?php
/*<?= \Config\Services::validation()->listErrors(); ?>
<form action="/calendar/<?=$invite_code?>/month/<?=$month?>/year/<?=$year?>" method="post">
    <?= csrf_field() ?>
    <label for ="number_of_days">Podaj liczbę dni urlopowych w roku <?= $year ?></label>
    <input type="text" name="number_of_days"> <br />
    <input type="hidden" name="year" value=<?=$year?>>

    <input type="submit" name="submit" value="Zaktualizuj pule dni"/>

</form>*/
?>