<!DOCTYPE html>
<html>

<head>
    <title>Kalendarz Urlopów</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="\style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?= route_to('App\Controllers\HomeController::index') ?>">Planer urlopów</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= route_to('App\Controllers\UserController::index') ?>">Strona główna<span class="sr-only">(current)</span></a>
                </li>

                <?php
                $session = session();
                $userId = $session->get('id');
                $accountTypeId = $session->get('account_type_id');
                if ($accountTypeId == 1) :
                ?>
                    <!--Supervisor functions-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\CompanyController::create') ?>">Dodaj firmę</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\CalendarController::create') ?>">Stwórz kalendarz</a>
                    </li>
                <?php elseif ($accountTypeId == 2) : ?>
                    <!--Worker functions-->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\CalendarController::join') ?>">Dołącz do kalendarza</a>
                    </li>
                <?php endif ?>

                <?php if ($userId == null) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\UserController::login') ?>">Zaloguj się</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\UserController::register') ?>">Zarejestruj się</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('App\Controllers\UserController::logout') ?>">Wyloguj się</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>