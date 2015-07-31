<?php

set_include_path('.');

// Root
require_once('Jules.php');

// Http
require_once('Http/Curl.php');
require_once('Http/Request.php');
require_once('Http/Response.php');

// MVC
require_once('Mvc/Tag.php');
require_once('Mvc/Views.php');

// Core
require_once('Mvc/Controller.php');
require_once('Mvc/App.php');