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
$days = [
    0 => 'pn.',
    1 => 'wt.',
    2 => 'śr.',
    3 => 'cz.',
    4 => 'pt.',
    5 => 'so.',
    6 => 'nd.',
];

echo '<table id="calendar">';
echo '<tr>';
echo '<th colspan=4>Dni wolne</th>';

if (esc($month) <= 0 || esc($month) >= 13 || esc($year) <= 1899 || esc($year) >= 2100) {
    //If user didnt pass any values of month/year display current value
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
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
        $dayOfWeek = date('w', mktime(0, 0, 0, date('m'), $i, date('Y')));
        echo '<td>';
        echo  $days[$dayOfWeek];
        echo '</td>';
    }
    echo '</tr>';
    echo '<tr>';
    echo '<td></td>';
    echo '</tr>';
} else {
    //If user passes values display them
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
    echo '<td>'. $session->get('first_name') . ' ' . $session->get('last_name').'</td>';
    echo '<td>1</td>';
    echo '<td>1</td>';
    echo '<td>1</td>';
    for ($i = 0; $i < $daysInMonth; $i++) {        
        $dayOfWeek = date('w', mktime(0, 0, 0, date('m'), $i, date('Y')));
        echo '<td>';
        if($dayOfWeek >= 5) {
            echo 'X';
        }
        echo '</td>';
    }
    echo '</tr>';
}
?>
</table>