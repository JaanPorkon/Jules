<?php

namespace Jules\Db\Adapter\Pdo;

class MySQL
{
    private $pdo = null;

    public function __construct($config = array())
    {
        $config = array_merge($config, array('charset' => 'utf8'));

        try
        {
            $this->pdo = new \PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'].';charset='.$config['charset'], $config['username'], $config['passwd']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(Exception $err)
        {
            throw new \Exception($err->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function query($query)
    {
        return $this->pdo->query($query);
    }

    public function prepare($query)
    {
        return $this->pdo->prepare($query);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}