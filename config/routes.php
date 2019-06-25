<?php

use woodpc\Router;



// admin routes
Router::addRoute('^admin$', ['controller' => 'Main', 'action' => 'index', 'prefix' => 'admin']);
Router::addRoute('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

// default routes
Router::addRoute('^$', ['controller' => 'Main', 'action' => 'index']);
Router::addRoute('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');