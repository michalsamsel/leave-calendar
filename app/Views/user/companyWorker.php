<a href="/calendar/join">Dołącz do kalendarza</a> <br />

<h3> Twoje kalendarze: </h3>
<?php foreach(esc($calendarList) as $calendar) : ?>
    <a href="calendar/<?= $calendar['invite_code'] ?>"><?= $calendar['name'] ?></a> <br />
<?php endforeach ?>