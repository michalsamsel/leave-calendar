<div class="container">
    <div class="row justify-content-center ">
        <h3><?= esc($errorMessage) ?></h3>
    </div>
    <div class="row justify-content-center border border-danger">
        <?= \Config\Services::validation()->listErrors(); ?>
    </div>
    <form action="<?= route_to('App\Controllers\User::login')?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col text-right">
                <label for="email">Adres Email:</label><br />
                <label for="password">Hasło:</label><br />
            </div>
            <div class="col justify-content-start">
                <input type="text" name="email" /> <br />
                <input type="password" name="password" /> <br />
            </div>
        </div>
        <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" name="submit" value="Zaloguj się" />
        </div>
    </form>
</div>