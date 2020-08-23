<div class="container">
    <div class="row justify-content-center ">
    </div>
    <div class="row justify-content-center border border-danger">
        <?= \Config\Services::validation()->listErrors(); ?>
    </div>
    <form action="<?= route_to('App\Controllers\Company::create') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col text-right">
                <label for="name">Nazwa firmy:</label> <br />
                <label for="nip">NIP:</label> <br />
                <label for="city">Lokalizacja firmy (miasto):</label> <br />
            </div>
            <div class="col justify-content-start">
                <input type="text" name="name" /> <br />
                <input type="text" name="nip" /> <br />
                <input type="text" name="city" /> <br />
            </div>
        </div>
        <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" name="submit" value="Dodaj firmę" />
        </div>
    </form>
</div>