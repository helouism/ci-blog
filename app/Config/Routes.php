<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ["as" => "landing_page"]);
$routes->get('about', 'Home::about', ["as" => "about_page"]);
$routes->get('tag/(:segment)', 'Blog::tag/$1', ["as" => "blog_tag"]);
$routes->get('blog/(:segment)', 'Blog::view/$1', ["as" => "blog_view"]);
$routes->get('page/(:segment)', 'Blog::page/$1', ['as' => 'page_view']);
$routes->get('change-password', 'PasswordReset::index');
$routes->post('change-password', 'PasswordReset::index');

service('auth')->routes($routes);

$routes->group("admin", ["filter" => "group:admin"], static function ($routes) {
    $routes->get('', 'Admin\Dashboard::index', ["as" => "admin_dashboard"]);
    $routes->get("posts", "Admin\PostController::index", ["as" => "admin_posts_index"]);
    $routes->get("posts/create", "Admin\PostController::create", ["as" => "admin_posts_create"]);
    $routes->post("posts/store", "Admin\PostController::store", ["as" => "admin_posts_store"]);
    $routes->get("posts/edit/(:num)", "Admin\PostController::edit/$1", ["as" => "admin_post_edit"]);
    $routes->post("posts/update/(:num)", "Admin\PostController::update/$1", ["as" => "admin_post_update"]);
    $routes->get("posts/delete/(:num)", "Admin\PostController::delete/$1", ["as" => "admin_post_delete"]);
    $routes->post('posts/image/process', 'Admin\PostController::processImage', ['as' => 'admin_posts_image_process']);
    $routes->post('posts/image/revert', 'Admin\PostController::revertImage', ['as' => 'admin_posts_image_revert']);

    $routes->get('pages', 'Admin\PageController::index', ['as' => 'admin_pages_index']);
    $routes->get('pages/create', 'Admin\PageController::create', ['as' => 'admin_pages_create']);
    $routes->post('pages/store', 'Admin\PageController::store', ['as' => 'admin_pages_store']);
    $routes->get('pages/edit/(:num)', 'Admin\PageController::edit/$1', ['as' => 'admin_pages_edit']);
    $routes->post('pages/update/(:num)', 'Admin\PageController::update/$1', ['as' => 'admin_pages_update']);
    $routes->post('pages/delete/(:num)', 'Admin\PageController::delete/$1', ['as' => 'admin_pages_delete']);

    // Profile Management Routes
    $routes->get("profile", "Admin\Profile::index", ["as" => "admin_profile"]);
    $routes->post('profile/bio', 'Admin\Profile::updateBio', ['as' => 'admin_profile_update_bio']);

    $routes->get("profile/change-email", "Admin\Profile::changeEmail", ["as" => "admin_profile_change_email"]);
    $routes->post("profile/update-email", "Admin\Profile::updateEmail", ["as" => "admin_profile_update_email"]);
    $routes->get('profile/email/verify', 'Admin\Profile::verifyEmailChange', ['as' => 'admin_profile_verify_email_change']);
    $routes->get("profile/change-username", "Admin\Profile::changeUsername", ["as" => "admin_profile_change_username"]);
    $routes->post("profile/update-username", "Admin\Profile::updateUsername", ["as" => "admin_profile_update_username"]);
    $routes->get("profile/change-password", "Admin\Profile::changePassword", ["as" => "admin_profile_change_password"]);
    $routes->post("profile/update-password", "Admin\Profile::updatePassword", ["as" => "admin_profile_update_password"]);
});
