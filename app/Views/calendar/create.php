<?= \Config\Services::validation()->listErrors(); ?>

<form action="/calendar/create" method="post">
    <?= csrf_field() ?>
    <label for="name">Nazwa kalendarza:</label>
    <input type="text" name="name" /> <br /><br />
    <label for="company_id">Wybierz dla jakiej firmy tworzysz kalendarz:</label>
    <select name="company_id">
        <option value="0">Wybierz firme</option>
        <?php foreach ($companies as $company) : ?>
            <option value="<?=esc($company['id'])?>"><?= esc($company['name']) ?>
        <?php endforeach ?>
    </select>
    <input type="submit" name="submit" value="Stwórz kalendarz" />

</form>