<div class="container">
    <div class="row justify-content-center ">
        <h3><?= esc($errorMessage) ?></h3>
    </div>
    <div class="row justify-content-center border border-danger">
        <?= \Config\Services::validation()->listErrors(); ?>
    </div>
    <form action="<?= route_to('App\Controllers\User::join') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col text-right">
                <label for="invite_code">Wpisz kod kalendarza otrzymany od pracodawcy:</label>
            </div>
            <div class="col justify-content-start">
                <input type="text" name="invite_code" />
            </div>
        </div>
        <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" name="submit" value="Dołącz do kalendarza" />
        </div>
    </form>
</div>