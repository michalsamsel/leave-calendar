<!DOCTYPE html>
<html>

<head>
    <title>Kalendarz Urlopów</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?= route_to('App\Controllers\Home::index') ?>">Planer urlopów</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= route_to('App\Controllers\User::index') ?>">Strona główna<span class="sr-only">(current)</span></a>
                </li>
                <?php
                $session = session();
                if($session->get('account_type_id') == 1)
                {
                    //Supervisor functions
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\Company::create') . '">Dodaj firmę</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\Calendar::create') . '">Stwórz kalendarz</a>';
                    echo '</li>';
                }
                else if($session->get('account_type_id') == 2)
                {
                    //Worker functions
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\Calendar::join') . '">Dołącz do kalendarza</a>';
                    echo '</li>';
                }

                if ($session->get('id') == null) {
                    //If someone is not logged in
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\User::login') . '">Zaloguj się</a>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\User::register') . '">Zarejestruj się</a>';
                    echo '</li>';
                } else {
                    //Logged user navbar.
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="' . route_to('App\Controllers\User::logout') . '">Wyloguj się</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>