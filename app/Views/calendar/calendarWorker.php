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
    $month = date('n');
    $year = date('Y');
}

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
echo '<td>'.esc($numberOfDays).'</td>';
echo '<td>0</td>';
echo '<td>'.esc($numberOfDays).'-0</td>';  

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

<br />
<?= \Config\Services::validation()->listErrors(); ?>
<form action="<?=route_to('App\Controllers\Calendar::index', $invite_code, $month, $year)?>" method="post">
    <?= csrf_field() ?>
    <label for="number_of_days">Wpisz liczbe dni urlopu na rok <?= $year ?>:</label>
    <input type="text" name="number_of_days" /> <br /><br />
    <input type="hidden" name="year" value="<?=$year?>">
    <input type="submit" name="submit" value="Zapisz dni" />
</form>