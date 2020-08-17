<a href="/company/create">Dodaj firmę</a> <br />
<a href="/calendar/create">Dodaj kalendarz</a> <br />
<br />
<h3> Twoje kalendarze: </h3>
<?php foreach($calendars as $calendar) : ?>
    <a href="calendar/<?= esc($calendar['invite_code']) ?>"><?= esc($calendar['name'])?> (<?=esc($calendar['invite_code'])?>)</a> <br />
<?php endforeach ?>