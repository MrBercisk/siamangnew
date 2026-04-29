<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Home::index');

$routes->get('/', 'AuthController::index');
$routes->get('v_login/forgot_password', 'AuthController::forgotPassword');
$routes->post('v_login/forgot_password', 'AuthController::forgotPassword');
$routes->get('v_login/reset_password/(:any)', 'AuthController::resetPassword/$1');
$routes->post('v_login/reset_password/(:any)', 'AuthController::resetPassword/$1');

$routes->get('/downloadFormNilai/(:num)', 'DataLaporan::downloadFormNilai/$1');

$routes->get('login', 'Login::index');
$routes->post('login/cekUser', 'Login::cekUser');
// buat reset semua pass soalnya key nya di generate ulang
$routes->get('resetpass', 'ResetPass::index');


$routes->get('dashboard', 'Dashboard::index');
$routes->get('databidang', 'DataBidang::index');
$routes->get('datapendaftaran', 'Datapendaftaran::index');
$routes->get('dashboard/logout', 'Dashboard::logout');


$routes->post('datapendaftaran/ajaxDataPendaftaran', 'Datapendaftaran::ajaxDataPendaftaran');
$routes->post('databidang/ajaxDataBidang', 'DataBidang::ajaxDataBidang');
$routes->post('informasi/ajaxInformasi', 'Informasi::ajaxInformasi');

$routes->get('informasi', 'Informasi::index');


$routes->get('datanilai', 'Datanilai::index');
$routes->post('dataNilai/ajaxDataNilai', 'Datanilai::ajaxDataNilai');




