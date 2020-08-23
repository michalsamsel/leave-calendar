<div class="container">
    <div class="row justify-content-center ">
    </div>
    <div class="row justify-content-center border border-danger">
        <?= \Config\Services::validation()->listErrors(); ?>
    </div>
    <form action="<?= route_to('App\Controllers\Calendar::create') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col text-right">
                <label for="name">Nazwa kalendarza:</label> <br /> 
                <label for="company_id">Wybierz dla jakiej firmy tworzysz kalendarz:</label> <br /> 
            </div>
            <div class="col justify-content-start">
                <input type="text" name="name" /> <br />
                <select name="company_id">
                    <option value="0">Wybierz firme</option>
                    <?php foreach (esc($companyList) as $company) : ?>
                        <option value="<?= $company['id'] ?>"><?= $company['name'] ?>
                        <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row justify-content-center">
            <input class="btn btn-primary" type="submit" name="submit" value="Stwórz kalendarz" />
        </div>
    </form>
</div>