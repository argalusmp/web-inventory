<?php

namespace Config;

use App\Controllers\User;
use PHPUnit\TextUI\XmlConfiguration\Group;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index', ['filter' => 'authfilter']);



//Route User
$routes->group('user', ['filter' => 'authfilter'], function ($routes) {
    $routes->get('user', 'User::index');
    $routes->post('tambah', 'User::tambahUser');
    $routes->post('edit', 'User::editUser');
    $routes->post('delete', 'User::deleteUser');
});


//Route Login
$routes->get('/login', 'Auth::index');
$routes->post('/login/ceklogin', 'Auth::cekLogin');

//Route Logout
$routes->get('/logout', 'Auth::logout');

//Route Register
$routes->get('/register', 'Auth::registerPage');
$routes->post('/register/akun', 'Auth::register');

//Route  Supplier
$routes->group('supplier', ['filter' => 'authfilter'], function ($routes) {
    $routes->get('supplier', 'Supplier::index');
    $routes->post('tambah', 'Supplier::tambahSupplier');
    $routes->post('edit', 'Supplier::editSupplier');
    $routes->post('delete', 'Supplier::deleteSupplier');
});


//Route Barang
$routes->group('barang', ['filter' => 'authfilter'], function ($routes) {
    $routes->get('barang', 'Barang::listBarang');
    $routes->get('stock', 'Barang::listStock');
    $routes->get('masuk', 'Transaksi::listMasuk');
    $routes->get('keluar', 'Transaksi::listKeluar');
    $routes->post('tambah', 'Barang::tambahBarang');
    $routes->post('edit', 'Barang::editBarang');
    $routes->post('delete', 'Barang::deleteBarang');
    $routes->post('masuk/tambah', 'Transaksi::tambahMasuk');
    $routes->post('masuk/edit', 'Transaksi::editMasuk');
    $routes->post('masuk/delete', 'Transaksi::deleteMasuk');
    $routes->post('keluar/tambah', 'Transaksi::tambahKeluar');
    $routes->post('keluar/edit/(:segment)/(:segment)', 'Transaksi::editKeluar/$1/$2');
    $routes->post('keluar/delete/(:segment)/(:segment)', 'Transaksi::deleteKeluar/$1/$2');
});




//Route Laporan
$routes->get('/laporan', 'Laporan::index');
$routes->post('/laporan/export', 'Laporan::export');
$routes->post('/laporan/filter', 'Laporan::filterData');





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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
