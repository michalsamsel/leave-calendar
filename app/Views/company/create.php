<?= \Config\Services::validation()->listErrors(); ?>

<form action="/company/create" method="post">
    <?= csrf_field() ?>
    <label for="name">Nazwa firmy:</label>
    <input type="text" name="name" /> <br /><br />
    <label for="nip">NIP:</label>
    <input type="text" name="nip" /> <br /><br />
    <label for="city">Lokalizacja firmy (miasto):</label>
    <input type="text" name="city" /> <br /><br />
    
    <input type="submit" name="submit" value="Dodaj firmę" />

</form>