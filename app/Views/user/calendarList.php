<div class="list-group">
    <p class="list-group-item list-group-item-action active">
        Twoje kalendarze:
    </p>
    <?php foreach (esc($calendarList) as $calendar) : ?>
        <a href="<?= route_to('App\Controllers\CalendarController::index', $calendar['invite_code']) ?>" class="list-group-item list-group-item-action">
            <?= $calendar['name'] ?> (<?= $calendar['invite_code'] ?>)
        </a>
    <?php endforeach ?>
</div>