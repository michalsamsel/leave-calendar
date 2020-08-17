<?= \Config\Services::validation()->listErrors(); ?>

<form action="/calendar/join" method="post">
    <?= csrf_field() ?>
    <label for="invite_code">Wpisz kod kalendarza otrzymany od pracodawcy:</label>
    <input type="text" name="invite_code" /> <br /><br />
    <input type="submit" name="submit" value="Dołącz do kalendarza" />
</form>