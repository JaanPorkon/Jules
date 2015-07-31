<?php

include('../Jules/autoloader.php');

try
{
    $loader = new Jules\Loader();

    $loader->registerDirs(
        array(
            'views' => '../app/views/',
            'controllers' => '../app/controllers/',
            'models' => '../app/models/'
        )
    );

    $config = Jules\Config\Adapter\Ini::parse('../app/config/config.ini');

    $loader->set('db', function() use($config)
    {
        return new \Jules\Db\Adapter\Pdo\MySQL(array(
            'host' => $config->mysql->host,
            'username' => $config->mysql->username,
            'passwd' => $config->mysql->passwd,
            'dbname' => $config->mysql->dbname
        ));
    });

    $app = new Jules\Mvc\App($loader);
    $app->run();
}
catch(Exception $err)
{
    echo '<pre>Error: '.$err->getMessage().PHP_EOL.$err->getTraceAsString().'</pre>';
}