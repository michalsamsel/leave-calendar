    <div class="container">
        <div class="row justify-content-center border border-danger">
            <?= \Config\Services::validation()->listErrors(); ?>
        </div>
        <form action="<?= route_to('App\Controllers\UserController::register')?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col text-right">
                    <label for="first_name">Imie:</label> <br />
                    <label for="last_name">Nazwisko:</label> <br />
                    <label for="email">Adres Email:</label> <br />
                    <label for="password">Hasło:</label> <br />
                    <label for="password_validate">Powtórz hasło:</label> <br />
                    <label for="account_type_id">Typ konta:</label> <br />
                </div>
                <div class="col justify-content-start">
                    <input type="text" name="first_name" /> <br />
                    <input type="text" name="last_name" /> <br />
                    <input type="text" name="email" /> <br />
                    <input type="password" name="password" /> <br />
                    <input type="password" name="password_validate" /> <br />
                    <?php foreach (esc($accountTypes) as $accountType) : ?>
                        <label for="<?= esc($accountType['id']) ?>"> <?= esc($accountType['name']) ?> </label>
                        <input type="radio" value="<?= esc($accountType['id']) ?>" name="account_type_id" /> <br />
                    <?php endforeach ?>
                </div>
            </div>
            <div class="row justify-content-center">
                <input class="btn btn-primary" type="submit" name="submit" value="Zarejestruj się" />
            </div>
        </form>
    </div>