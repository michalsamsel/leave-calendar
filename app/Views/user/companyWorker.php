<a href="/calendar/join">Dołącz do kalendarza</a> <br />

<h3> Twoje kalendarze: </h3>
<?php foreach($calendars as $calendar) : ?>
    <a href="calendar/<?= esc($calendar['invite_code']) ?>"><?= esc($calendar['name']) ?></a> <br />
<?php endforeach ?>