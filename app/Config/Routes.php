<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('/chart-transaksi', 'Home::showChartTransaksi', ['filter' => 'role:Owner']);
$routes->post('/chart-pengembalian', 'Home::showChartPengembalian', ['filter' => 'role:Owner']);
$routes->post('/chart-pelanggan', 'Home::showChartPelanggan', ['filter' => 'role:Owner']);
$routes->post('/chart-jumlah', 'Home::showChartJumlah', ['filter' => 'role:Owner']);

$routes->group('motor', function ($r) {
    $r->get('/', 'Motor::index');
    $r->get('create', 'Motor::create', ['filter' => 'role:Owner']);
    $r->post('create', 'Motor::save', ['filter' => 'role:Owner']);
    $r->get('edit/(:any)', 'Motor::edit/$1', ['filter' => 'role:Owner']);
    $r->post('edit/(:any)', 'Motor::update/$1', ['filter' => 'role:Owner']);
    $r->get('(:any)', 'Motor::detail/$1');
    $r->delete('(:any)', 'Motor::delete/$1', ['filter' => 'role:Owner']);
    $r->post('import', 'Motor::importData', ['filter' => 'role:Owner']);
});

$routes->group('transaksi', function ($r) {
    $r->get('/', 'Transaksi::index');
    $r->get('exportpdf/(:any)', 'Transaksi::exportPDF/$1');
    $r->get('create', 'Transaksi::create');
    $r->post('create', 'Transaksi::save');
    $r->get('edit/(:any)', 'Transaksi::edit/$1');
    $r->post('edit/(:any)', 'Transaksi::update/$1');
    $r->get('(:any)', 'Transaksi::detail/$1');
    $r->delete('(:any)', 'Transaksi::delete/$1', ['filter' => 'role:Owner']);
    $r->post('import', 'Transaksi::importData');
});

$routes->group('laporan', function ($r) {
    $r->get('/', 'Laporan::index', ['filter' => 'role:Owner']);
    $r->get('exportpdf', 'Laporan::exportPDF', ['filter' => 'role:Owner']);
    $r->get('exporttransaksi/(:any)/(:any)', 'Laporan::exporttransaksi/$1/$2', ['filter' => 'role:Owner']);
    $r->get('search', 'Laporan::search', ['filter' => 'role:Owner']);
    $r->post('search', 'Laporan::save', ['filter' => 'role:Owner']);
    $r->get('result/(:any)/(:any)', 'Laporan::indexspesifik/$1/$2', ['filter' => 'role:Owner']);
    $r->get('(:any)', 'Laporan::detail/$1', ['filter' => 'role:Owner']);
});

$routes->group('pengembalian', function ($r) {
    $r->get('/', 'Pengembalian::index');
    $r->get('exportpdf/(:any)', 'Pengembalian::exportPDF/$1');
    $r->get('create', 'Pengembalian::create');
    $r->post('create', 'Pengembalian::save');
    $r->get('edit/(:any)', 'Pengembalian::edit/$1');
    $r->post('edit/(:any)', 'Pengembalian::update/$1');
    $r->get('(:any)', 'Pengembalian::detail/$1');
    $r->delete('(:any)', 'Pengembalian::delete/$1', ['filter' => 'role:Owner']);
    $r->post('import', 'Pengembalian::importData');
});

$routes->group('lap', function ($r) {
    $r->get('/', 'Laporan::index2', ['filter' => 'role:Owner']);
    $r->get('exportpdf', 'Laporan::exportPDF2', ['filter' => 'role:Owner']);
    $r->get('exportpengembalian/(:any)/(:any)', 'Laporan::exportpengembalian/$1/$2', ['filter' => 'role:Owner']);
    $r->get('search', 'Laporan::search2', ['filter' => 'role:Owner']);
    $r->post('search', 'Laporan::save2', ['filter' => 'role:Owner']);
    $r->get('result/(:any)/(:any)', 'Laporan::indexspesifik2/$1/$2', ['filter' => 'role:Owner']);
    $r->get('(:any)', 'Laporan::detail2/$1', ['filter' => 'role:Owner']);
});

$routes->group('', ['namespace' => 'Myth\Auth\Controllers'], function ($routes) {
    // Login/out
    $routes->get('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');

    // Registration
    $routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');

    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/resets
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');
});

$routes->group('users', function ($r) {
    $r->get('/', 'Users::index', ['filter' => 'role:Owner']);
    $r->get('create', 'Users::create', ['filter' => 'role:Owner']);
    $r->delete('(:num)', 'Users::delete/$1', ['filter' => 'role:Owner']);
});

/*
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
