<a href="/company/create">Dodaj firmę</a> <br />
<a href="/calendar/create">Dodaj kalendarz</a> <br />
<br />
<h3> Twoje kalendarze: </h3>
<?php foreach(esc($calendarList) as $calendar) : ?>
    <a href="calendar/<?= $calendar['invite_code'] ?>"><?= $calendar['name']?> (<?=$calendar['invite_code']?>)</a> <br />
<?php endforeach ?>