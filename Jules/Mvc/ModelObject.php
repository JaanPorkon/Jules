<?php

namespace Jules\Mvc;

class ModelObject
{
    private $tableName = null;
    private $customVars = array();

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->customVars))
        {
            return $this->customVars[$name];
        }
        else
        {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $this->customVars[$name] = $value;
    }

    private function getTableName()
    {
        return $this->tableName;
    }

    private function getCustomVars()
    {
        return $this->customVars;
    }

    public function remove()
    {
        global $Jules_mysql;

        $getKeys = $Jules_mysql->query('SHOW KEYS FROM '.$this->getTableName().' WHERE Key_name = "PRIMARY"');
        $keyName = $getKeys->fetchAll()[0]['Column_name'];

        $queryStr = 'DELETE FROM '.$this->getTableName().' WHERE '.$keyName.' = :'.$keyName;

        $prepare = $Jules_mysql->prepare($queryStr);

        $data = $this->getCustomVars();
        $vars = array(':'.$keyName => $data[$keyName]);

        if($prepare->execute($vars))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function save()
    {
        global $Jules_mysql;

        $getKeys = $Jules_mysql->query('SHOW KEYS FROM '.$this->getTableName().' WHERE Key_name = "PRIMARY"');
        $keyName = $getKeys->fetchAll()[0]['Column_name'];

        $queryStr = 'UPDATE '.$this->getTableName().' SET ';

        $tmp = array();

        foreach($this->getCustomVars() as $key => $value)
        {
            if($key != $keyName)
            {
                $tmp[] = $key.' = :'.$key;
            }
        }

        $queryStr .= join(', ', $tmp);
        $queryStr .= ' WHERE '.$keyName.' = :'.$keyName;

        $prepare = $Jules_mysql->prepare($queryStr);

        if($prepare->execute($this->getCustomVars()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}