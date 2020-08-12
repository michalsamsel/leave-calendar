<?= \Config\Services::validation()->listErrors(); ?>

<form action="/user/register" method="post">
    <?= csrf_field() ?>
    <label for="first_name">Imie:</label>
    <input type="text" name="first_name" /> <br /><br />

    <label for="last_name">Nazwisko:</label>
    <input type="text" name="last_name" /> <br /><br />

    <label for="email">Adres Email:</label>
    <input type="text" name="email" /> <br /><br />

    <label for="password">Hasło:</label>
    <input type="password" name="password" /> <br /><br />

    <label for="account_type_id">Typ konta:</label> <br />

    <?php foreach (esc($accounts) as $account) : ?>
    <label for="<?= esc($account['id'])?>"> <?= esc($account['name']) ?> </label>
    <input type="radio" id="<?= esc($account['id'])?>" name="account_type_id"/> <br />
    <?php endforeach ?>

    <input type="submit" name="submit" value="Zarejestruj się" />

</form>