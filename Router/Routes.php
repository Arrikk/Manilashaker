<?php

// $router = new Core\Router;
/**
 * Admin routes
 */

$router->add('master', ['namespace' => 'Admin', 'controller' => 'auth', 'action' => 'login']);
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:[\d]+}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{action}/{token:[\da-f]+}', ['namespace' => 'Admin']);

// Home Page
$router->add('old', ['controller' => 'blog', 'action' => 'blog']);
$router->add('', ['controller' => 'post', 'action' => 'index', 'namespace' => 'Post']);

$router->add('import/{action}', ['controller' => 'import']);

// Auth Routes
$router->add('account', ['controller' => 'account', 'action' => 'home']);
$router->add('register', ['controller' => 'auth', 'action' => 'register']);
$router->add('login', ['controller' => 'auth', 'action' => 'login']);


// Author Post Route
$router->add('author/post/{author:[\d\w_-]+}', ['controller' => 'post', 'action' => 'author-post', 'namespace' => 'Post']);
$router->add('author/post/{author:[\d\w_-]+}/{page:[\d]+}', ['controller' => 'post', 'action' => 'author-post', 'namespace' => 'Post']);


$router->add('mobile-phones/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'phones']);
$router->add('laptops/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'laptops']);
$router->add('television/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'television']);
$router->add('tablet/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'tablet']);
$router->add('cameras/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'cameras']);
$router->add('smartwatch/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'smartwatch']);
$router->add('fitnessband/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'fitnessband']);
$router->add('airconditioner/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'airconditioner']);
$router->add('powerbank/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'powerbank']);
$router->add('washing-machine/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'washing-machine']);
$router->add('refrigerator/', ['controller' => 'gadgets', 'action' => 'product', 'parent' => 'refrigerator']);
$router->add('compare/', ['controller' => 'compare', 'action' => 'gadget', 'parent' => 'phones']);

// Blog routes
$router->add('/old/{payload:[+()\w\d\_-]+}', ['controller' => 'blog', 'action' => 'post']);
$router->add('/old/{payload:[+()\w\d\_-]+}/', ['controller' => 'blog', 'action' => 'post']);
$router->add('{payload:[+()\w\d\_-]+}', ['controller' => 'post', 'action' => 'single', 'namespace' => 'Post']);
$router->add('{payload:[+()\w\d\_-]+}/', ['controller' => 'post', 'action' => 'single', 'namespace' => 'Post']);

$router->add('old/page/{page:[\d]+}', ['controller' => 'blog', 'action' => 'blog']);
$router->add('old/page/{page:[\d]+}/', ['controller' => 'blog', 'action' => 'blog']);
$router->add('page/{page:[\d]+}', ['controller' => 'post', 'action' => 'index', 'namespace' => 'Post']);
$router->add('page/{page:[\d]+}/', ['controller' => 'post', 'action' => 'index', 'namespace' => 'Post']);

$router->add('news/tag/{ref:[\d\w_-]+}', ['controller' => 'blog', 'action' => 'tag']);
$router->add('news/tag/{ref:[\d\w_-]+}/', ['controller' => 'blog', 'action' => 'tag']);
$router->add('news/{category}/{ref:[\d\w]+}', ['controller' => 'blog', 'action' => 'category']);
$router->add('news/{category}/{ref:[\d\w]+}/{page:[\d]+}', ['controller' => 'blog', 'action' => 'category']);

$router->add('category/{category:[\d\w-]+}', ['controller' => 'post', 'action' => 'category', 'namespace' => 'Post']);
$router->add('category/{category}/{page:[\d]+}', ['controller' => 'post', 'action' => 'category', 'namespace' => 'Post']);

$router->add('news/{category}/{ref:[\d\w]+}/', ['controller' => 'blog', 'action' => 'category']);


// Compare Routes
$router->add('compare/compared/', ['controller' => 'compare', 'action' => 'compared']);
$router->add('compare/save-comparison/', ['controller' => 'compare', 'action' => 'saveComparison']);
$router->add('compare/compare/{payload:[\d\w_-]+}', ['controller' => 'compare', 'action' => 'compare']);
$router->add('compare/{payload:[\d\w_-]+}/', ['controller' => 'compare', 'action' => 'gadget']);
$router->add('compare/{payload:[\d\w_-]+}/{versus:[\d\w_-]+}', ['controller' => 'compare', 'action' => 'gadget']);

// Gadgets Routes
$router->add('fetch/{payload:[\d\w_-]+}/', ['controller' => 'gadgets', 'action' => 'gadgets']);
$router->add('{parent:[\d\w_-]+}/{payload:[\d\w_-]+}/', ['controller' => 'gadgets', 'action' => 'product']);
$router->add('{category:[\w-]+}/{payload:[+()\w\d\_-]+}', ['controller' => 'gadgets', 'action' => 'singleProduct']);

//  General Routes
$router->add('{controller}/{action}');
$router->add('site/{controller}/{action}');
$router->add('{controller}/{id:[\d]+}/{action}');
$router->add('{controller}/{action}/{payload:[\d\w_-]+}');


// $router::post('/rer');

        // $router->add('{payload:[\w_-]+}', ['controller' => 'gallery', 'action' => 'phones']);
        // return Routes::class;
