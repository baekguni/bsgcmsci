<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/* 아래는 튜토리얼용 라우팅 */ 
/*
$routes->get('/', 'pages::index');
$routes->match(['get','post'],'news/create','News::create');
$routes->get('news/(:segment)', 'News::view/$1');
$routes->get('news', 'News::index');
$routes->get('pages', 'pages::index');
$routes->get('(:segment)', 'pages::view/$1');
*/
/*
spectra home routing
*/
$routes->get('/', 'Home::index');
$routes->get('generic', 'Home::generic');
$routes->get('elements', 'Home::elements');
$routes->get('signup', 'Home::signup');
$routes->post('signup','Home::signup');
$routes->get('login', 'Home::login');
$routes->match(['get','post'],'signupchk','Home::signupchk');
$routes->match(['get','post'],'signup_aj','Home::signup_ajax');

