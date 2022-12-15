<?php

namespace Config;

use App\Libraries\RbacRoute;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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

$routes->cli('file/process', 'FileController::file_process');
$routes->cli('send/document', 'FileSendToPeruriController::send_document');
$routes->cli('check/document', 'FileSendToPeruriController::chackby_orderid');
$routes->cli('download/document', 'FileSendToPeruriController::download_document');
$routes->cli('send/file', 'FileSendToPeruriController::send_back_file');

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

$routes = new RbacRoute($routes);

$routes->addRedirect('/', 'admin/v2/dashboard');


$routes->group('admin', ['as' => 'admin.'], static function ($routes) {
    /**
     * AUTH AND RBAC
     */
    $routes->group('auth', ['as' => 'auth.'], static function ($routes) {
        $routes->get('login', 'Admin\Auth::login', ['as' => 'login']);
        $routes->post('login', 'Admin\Auth::login', ['as' => 'post-login']);
        $routes->post('logout', 'Admin\Auth::logout', ['as' => 'logout', 'filter' => 'authFilter']);
    });

    $routes->get('/v2/history/status', '\App\Controllers\Admin\V2\History::status', ['as' => 'v2.history.status']);

    $routes->group('/', ['filter' => 'rbacFilter',], static function ($routes) {
        $routes->addRedirect('', 'admin/v2/dashboard');

        /**
         * * V2
         */
        $routes->group('v2', ['as' => 'v2.', 'namespace' => '\App\Controllers\Admin\V2'], static function ($routes) {
            // * Dashboard
            $routes->get('/dashboard', 'Dashboard::index', ['as' => 'dashboard.index']);
            $routes->get('/dashboard/datatable', 'Dashboard::datatable', ['as' => 'dashboard.datatable']);

            // * History
            $routes->get('history', 'History::index', ['as' => 'history.index']);
            $routes->get('history/export', 'History::export', ['as' => 'history.export']);
            $routes->get('history/datatable', 'History::datatable', ['as' => 'history.datatable']);
            $routes->get('history/(:num)', 'History::show/$1', ['as' => 'history.show']);
            $routes->put('history/edit-data', 'History::editData/$1', ['as' => 'history.editdata']);

            // * Document Process
            $routes->get('file-content/(:num)', 'FileContent::datatable/$1', ['as' => 'file-content.datatable']);
            $routes->get('file-content/show/(:num)', 'FileContent::show/$1', ['as' => 'file-content.show']);
            $routes->get('file-content/showedit/(:num)', 'FileContent::showedit/$1', ['as' => 'file-content.showedit']);
            $routes->post('file-content/process/(:num)', 'FileContent::process/$1', ['as' => 'file-content.process']);
            
        });


        $routes->get('dashboard', 'Admin\Dashboard::index', ['as' => 'dashboard.index']);
        $routes->get('dashboard/datatable', 'Admin\Dashboard::datatable', ['as' => 'dashboard.datatable']);



        $routes->resource('user', "Admin\User");
        $routes->group('user', static function ($routes) {
            $routes->get('profile', 'Admin\User::profile', ['as' => 'user.profile']);
            $routes->post('profile', 'Admin\User::storeProfile', ['as' => 'user.store-profile']);
            $routes->get('select2', 'Admin\User::select2', ['as' => 'user.select2']);
        });

        // RBAC
        $routes->group('rbac', [
            'namespace' => '\App\Controllers\Rbac',
            'as' => 'rbac.',
        ], static function ($routes) {

            $routes->resource('/role', "Role");
            $routes->group('role', [
                'as' => 'role.',
            ], static function ($routes) {
                $routes->get('menu/(:num)', "Role::menu/$1", ['as' => 'menu']);
                $routes->post('save-menu/(:num)', "Role::saveMenu/$1", ['as' => 'save-menu']);
                $routes->get('action/(:num)', "Role::action/$1", ['as' => 'action']);
                $routes->post('update-action/(:num)', "Role::updateAction/$1", ['as' => 'update-action']);
            });

            $routes->resource('/menu', "Menu");
            $routes->group('menu', [
                'as' => 'menu.',
            ], static function ($routes) {
                $routes->post('update-order', "Menu::updateOrder", ['as' => 'update-order']);
                $routes->get('orderable', "Menu::orderable", ['as' => 'orderable']);
            });
        });


        /**
         * ---------------------------
         * * PROJECT ROUTES START HERE
         * ---------------------------
         */

        // * TOKEN ROUTES
        $routes->get('token-peruri/get', 'Admin\TokenPeruri::get', ['as' => 'token-peruri.get']);
        $routes->post('token-peruri/refresh', 'Admin\TokenPeruri::refresh', ['as' => 'token-peruri.refresh']);
        $routes->get('token-peruri', 'Admin\TokenPeruri::index', ['as' => 'token-peruri.index']);

        // * Unggah Dokumen
        $routes->get('unggah-dokumen', 'Admin\UnggahDokumen::index', ['as' => 'unggah-dokumen.index']);
        $routes->post('unggah-dokumen', 'Admin\UnggahDokumen::store', ['as' => 'unggah-dokumen.store']);

        // * History
        $routes->get('history', 'Admin\History::index', ['as' => 'history.index']);
        $routes->get('history/datatable', 'Admin\History::datatable', ['as' => 'history.datatable']);
        $routes->get('history/(:num)', 'Admin\History::show/$1', ['as' => 'history.show']);

        // * Document Process
        $routes->get('document-process/(:num)', 'Admin\DocumentProcess::datatable/$1', ['as' => 'document-process.datatable']);
        $routes->get('document-process/show/(:num)', 'Admin\DocumentProcess::show/$1', ['as' => 'document-process.show']);
        $routes->get('document-process/detail/(:num)', 'Admin\DocumentProcess::detail/$1', ['as' => 'document-process.detail']);
    });
});

$routes = $routes->getRoutesPriv();


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
