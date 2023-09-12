<?php

namespace Config;

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

// API ROUTES

$routes->group('api/v1', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->group('view', function($routes) {
        $routes->get('overview', 'ApiController::get_overview');
        $routes->get('visitors', 'ApiController::get_visitors');
        $routes->get('referrers', 'ApiController::get_referrers');   
    });
    $routes->group('insert', function($routes) {
        $routes->post('newsletter', 'ApiController::newsletter');
    });
});


// HOME ROUTES

$routes->group('', ['namespace' => 'App\Controllers\Home'], function($routes) {
    $routes->get('/', 'ViewsController::index');
    $routes->get('home', 'ViewsController::home');
    $routes->get('about', 'ViewsController::about');
    $routes->get('sites-privacy-notice', 'ViewsController::privacy');

    $routes->group('form', function($routes) {
        $routes->get('enroll', 'ViewsController::form_enroll');
    });

    $routes->group('/', function($routes) {
        $routes->get('admission', 'ViewsController::admission');   
    });

    $routes->group('/', function($routes) {
        $routes->get('bulletin', 'ViewsController::bulletin'); 
        $routes->get('bulletin/announcement', 'ViewsController::bulletin_announcement');
        $routes->get('bulletin/announcement/page/(:num)', 'ViewsController::bulletin_announcement/$1');

        
        $routes->get('bulletin/news', 'ViewsController::bulletin_news');
        $routes->get('bulletin/news/page/(:num)', 'ViewsController::bulletin_news/$1');
        $routes->get('bulletin/(:any)/(:num)/(:any)', 'ViewsController::bulletin_view/$1/$2/$3');
    });

    $routes->group('/', function($routes) {
        $routes->get('faculty', 'ViewsController::faculty');
    });

    $routes->group('/', function($routes) {
        $routes->get('officers', 'ViewsController::officers'); 
    });
    
    $routes->group('/', function($routes) {
        $routes->get('research', 'ViewsController::research');
        $routes->get('research/page/(:num)', 'ViewsController::research_page/$1');
        $routes->get('research/view/(:num)/(:any)', 'ViewsController::research_view/$1/$2');
    });

    $routes->group('/', function($routes) {
        $routes->get('testimonial', 'ViewsController::testimonial');
        $routes->get('testimonial/view/(:num)/(:any)', 'ViewsController::testimonial_view/$1/$2');
    });
});

// ADMIN ROUTES

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'ViewsController::index');
    $routes->get('signout', 'ViewsController::signout');

    $routes->group('login', function($routes) {
        $routes->get('/', 'ViewsController::login');
        $routes->post('/', 'Process\LoginAuthController::login');
    });

    $routes->group('widgets', function($routes) {
        $routes->get('/', 'ViewsController::widgets'); 
        $routes->post('toggle', 'Process\WidgetController::index'); 
    });

    $routes->get('dashboard', 'ViewsController::dashboard');
    $routes->get('notify', 'ViewsController::notify');

    // MANAGE USERS

    $routes->group('manage', function($routes) {
        $routes->get('users', 'ViewsController::manage_users');
        $routes->get('users/add', 'ViewsController::add_users');
        
        $routes->get('users/update/(:num)', 'ViewsController::update_users/$1');
        $routes->get('users/delete/(:num)', 'ViewsController::delete_users/$1');

        $routes->post('users/add', 'Process\UserController::add');
        $routes->post('users/update/profile/image', 'Process\UserController::update_profile_image');
        $routes->post('users/update/profile', 'Process\UserController::update_profile');
        $routes->post('users/delete', 'Process\UserController::delete_data');
    });

    // MANAGE PAGE CONTENT

    $routes->group('manage', function($routes) {
        $routes->group('page/home', function($routes) {
            $routes->get('/', 'ViewsController::manage_home');
            $routes->get('logo/update/(:num)', 'ViewsController::update_logo/$1');
            $routes->get('carousel', 'ViewsController::update_carousel');

            $routes->post('logo/update', 'Process\HomeController::update_logo');
        });

        $routes->group('page/bulletin', function($routes) {
            $routes->get('/', 'ViewsController::manage_bulletin');
            $routes->get('view', 'ViewsController::view_bulletin');
            $routes->get('add', 'ViewsController::add_bulletin');
            $routes->get('update/(:num)', 'ViewsController::update_bulletin/$1');
            $routes->get('delete/(:num)', 'ViewsController::delete_bulletin/$1');

            $routes->post('add', 'Process\BulletinController::add');
            $routes->post('update/(:num)', 'Process\BulletinController::update/$1');
            $routes->post('update/banner/(:num)', 'Process\BulletinController::update_banner/$1');
            $routes->post('image/add', 'Process\BulletinController::add_image');
            $routes->post('image/delete', 'Process\BulletinController::delete_image');
            $routes->post('delete', 'Process\BulletinController::delete_data'); 

        });

        $routes->group('page/faculty', function($routes) {
            $routes->get('/', 'ViewsController::manage_faculty');
            $routes->get('add', 'ViewsController::add_faculty');
            $routes->get('update/(:num)', 'ViewsController::update_faculty/$1');
            $routes->get('delete/(:num)', 'ViewsController::delete_faculty/$1');

            $routes->post('add', 'Process\FacultyController::add');
            $routes->post('update/image', 'Process\FacultyController::update_image');
            $routes->post('update/data', 'Process\FacultyController::update_data');
            $routes->post('delete', 'Process\FacultyController::delete_data');
        });

        $routes->group('page/officers', function($routes) {
            $routes->get('/', 'ViewsController::manage_officers');
            $routes->get('add', 'ViewsController::add_officers');
            $routes->get('update/(:num)', 'ViewsController::update_officers/$1');
            $routes->get('delete/(:num)', 'ViewsController::delete_officers/$1');

            $routes->post('add', 'Process\OfficersController::add_data');
            $routes->post('update/image', 'Process\OfficersController::update_image');
            $routes->post('update/data', 'Process\OfficersController::update_data');
            $routes->post('delete', 'Process\OfficersController::delete_data');

        });

        $routes->group('page/research', function($routes) {
            $routes->get('/', 'ViewsController::manage_research');
            $routes->get('add', 'ViewsController::add_research');
            $routes->get('update/(:num)', 'ViewsController::update_research/$1');
            $routes->get('delete/(:num)', 'ViewsController::delete_research/$1');


            $routes->post('add', 'Process\ResearchController::add_data');

            $routes->post('update/data', 'Process\ResearchController::update_data');
            $routes->post('update/banner', 'Process\ResearchController::update_banner');
            $routes->post('add/images', 'Process\ResearchController::add_image');
            $routes->post('add/author', 'Process\ResearchController::add_author');
            $routes->post('delete/author', 'Process\ResearchController::delete_author');
            $routes->post('delete', 'Process\ResearchController::delete_data');
            $routes->post('delete/image', 'Process\ResearchController::delete_image');

        });

        $routes->group('page/testimonials', function($routes) {
            $routes->get('/', 'ViewsController::manage_testimonials');
            $routes->get('add', 'ViewsController::add_testimonials');
            $routes->get('update/(:num)', 'ViewsController::update_testimonials/$1');
            $routes->get('delete/(:num)', 'ViewsController::delete_testimonials/$1');

            $routes->post('add', 'Process\TestimonialsController::add_data');
            $routes->post('update/image', 'Process\TestimonialsController::update_image');
            $routes->post('update/data', 'Process\TestimonialsController::update_data');
            $routes->post('delete', 'Process\TestimonialsController::delete_data');

        });

        $routes->group('page/contacts', function($routes) {
            $routes->get('/', 'ViewsController::manage_contact');
            $routes->post('/', 'Process\ContactController::update');
        });

        $routes->group('reports', function($routes) {
            $routes->get('/', 'ViewsController::manage_reports');

            $routes->post('update/image', 'Process\MeController::update_image');
            $routes->post('update/data', 'Process\MeController::update_data');
            $routes->post('update/password', 'Process\MeController::update_password');
        });

        $routes->group('logs', function($routes) {
            $routes->get('/', 'ViewsController::manage_logs');

            $routes->post('update/image', 'Process\MeController::update_image');
            $routes->post('update/data', 'Process\MeController::update_data');
            $routes->post('update/password', 'Process\MeController::update_password');
        });

        $routes->group('me', function($routes) {
            $routes->get('/', 'ViewsController::manage_me');
            $routes->get('passwords', 'ViewsController::manage_passwords');

            $routes->post('update/image', 'Process\MeController::update_image');
            $routes->post('update/data', 'Process\MeController::update_data');
            $routes->post('update/password', 'Process\MeController::update_password');
        });

    });

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
