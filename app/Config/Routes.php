<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');

$routes->get('user', 'UserController::index');
$routes->match(['get', 'post'], 'user/register', 'UserController::register');
$routes->match(['get', 'post'], 'user/login', 'UserController::login');
$routes->get('user/logout', 'UserController::logout');

$routes->match(['get', 'post'], 'company/create', 'CompanyController::create');

$routes->match(['get', 'post'], 'calendar/create', 'CalendarController::create');
$routes->match(['get', 'post'], 'calendar/join', 'CalendarController::join');
$routes->get('calendar/(:alphanum)', 'CalendarController::index/$1');
$routes->match(['get','post'],'calendar/(:alphanum)/month/(:num)/year/(:num)', 'CalendarController::index/$1/$2/$3');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
