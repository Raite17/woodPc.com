<?php

use woodpc\Router;

//user routes
Router::addRoute('^product/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Product', 'action' => 'view']);

//category routes
Router::addRoute('^category/(?P<alias>[a-z0-9-]+)/?$', ['controller' => 'Category', 'action' => 'view']);


// admin routes
Router::addRoute('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::addRoute('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

// default routes
Router::addRoute('^$', ['controller' => 'Main', 'action' => 'index']);
Router::addRoute('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');