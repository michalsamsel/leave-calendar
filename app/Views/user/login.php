<?= \Config\Services::validation()->listErrors(); ?>

<form action="/user/login" method="get">
    <?= csrf_field() ?>
    <label for="email">Adres Email:</label>
    <input type="text" name="email" /> <br /><br />

    <label for="password">Hasło:</label>
    <input type="password" name="password" /> <br /><br />

    <input type="submit" name="submit" value="Zaloguj się" />

</form>