<?php

set_include_path('.');

// Init global variables
$Jules_mysql = null;
$Jules_view = null;

// Root
require_once('Jules.php');

// Config adapters
require_once('Config/Adapter/Ini.php');

// Db Adapters
require_once('Db/Adapter/Pdo/MySQL.php');

// Http
require_once('Http/Curl.php');
require_once('Http/Request.php');
require_once('Http/Response.php');

// MVC
require_once('Mvc/Tag.php');
require_once('Mvc/Views.php');

// Core
require_once('Mvc/Controller.php');
require_once('Mvc/ModelObject.php');
require_once('Mvc/Model.php');
require_once('Mvc/App.php');