<?php

namespace Jules\Mvc;

class Model
{
    private $customVars = array();
    private $tableName = null;
    private $error = null;

    public function __construct()
    {
        $this->tableName = strtolower(get_called_class());
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->customVars))
        {
            return $this->customVars[$name];
        }
        else
        {
            return false;
        }
    }

    public function __set($name, $value)
    {
        $this->customVars[$name] = $value;
    }

    public function __call($name, $args)
    {
        echo $name;
    }

    public static function find($args = null)
    {
        global $Jules_mysql;

        $tableName = strtolower(get_called_class());
        $queryStr = 'SELECT * FROM '.$tableName;

        if(is_array($args))
        {
            if(isset($args['where']))
            {
                $queryStr .= ' WHERE '.$args['where'];
            }

            if(isset($args['orderby']))
            {
                $queryStr .= ' ORDER BY '.$args['orderby'];
            }

            if(isset($args['limit']))
            {
                $queryStr .= ' LIMIT '.$args['limit'];
            }
        }
        else
        {
            if(!is_null($args))
            {
                $queryStr .= ' WHERE '.$args;
            }
        }

        $response = null;

        try
        {
            $result = $Jules_mysql->query($queryStr);
            $response = $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $err)
        {
            throw $err;
        }

        $output = array();

        if(!is_null($response))
        {
            foreach($response as $row)
            {
                $modelObject = new \Jules\Mvc\ModelObject($tableName);

                foreach($row as $key => $val)
                {
                    $modelObject->$key = $val;
                }

                $output[] = $modelObject;
            }
        }

        return $output;
    }

    public static function findOne($args = null)
    {
        global $Jules_mysql;
        $tableName = strtolower(get_called_class());

        $queryStr = 'SELECT * FROM '.$tableName;

        if(is_array($args))
        {
            if(isset($args['where']))
            {
                $queryStr .= ' WHERE '.$args['where'];
            }

            if(isset($args['orderby']))
            {
                $queryStr .= ' ORDER BY '.$args['orderby'];
            }

            if(isset($args['limit']))
            {
                $queryStr .= ' LIMIT '.$args['limit'];
            }
        }
        else
        {
            $queryStr .= ' WHERE '.$args;
        }

        $queryStr .= ' LIMIT 0,1';

        $response = null;

        try
        {
            $result = $Jules_mysql->query($queryStr);
            $response = $result->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $err)
        {
            throw $err;
        }

        $modelObject = new \Jules\Mvc\ModelObject($tableName);

        foreach($response[0] as $key => $val)
        {
            $modelObject->$key = $val;
        }

        return $modelObject;
    }

    private function getTableName()
    {
        return $this->tableName;
    }

    private function getCustomVars()
    {
        return $this->customVars;
    }

    public function save($args = array())
    {
        global $Jules_mysql;

        if(count($args) > 0)
        {
            $data = $args;
        }
        else
        {
            $data = $this->getCustomVars();
        }

        try
        {
            $queryStr = 'INSERT INTO '.$this->getTableName().' ';

            $columns = array();
            $values = array();

            foreach($data as $key => $val)
            {
                $columns[] = $key;
                $values[] = ':'.$key;
            }

            $queryStr .= '('.join(', ', $columns).') VALUES ('.join(', ', $values).')';

            $prepare = $Jules_mysql->prepare($queryStr);
            $exec = $prepare->execute($data);

            $this->id = $Jules_mysql->lastInsertId();

            if($exec)
            {
                return $this;
            }
        }
        catch(\PDOException $err)
        {
            echo $err->getMessage();
            return false;
        }
    }

    private function setMessages($exception)
    {
        $this->error = $exception;
    }

    public function getMessages()
    {
        return $this->error;
    }
}