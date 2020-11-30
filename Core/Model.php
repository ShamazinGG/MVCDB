<?php
include 'App/Config.php';
abstract class Model
{
    protected $attributes = [];
    protected $table;

    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);
            // показывать предупреждение если есть ошибки
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    function getAll()
    {
        $table = $this->table;
        $db = static::getDB();
        $attributes = $db->query("SELECT * FROM $table");
        return $attributes->fetchAll(PDO::FETCH_ASSOC);

    }

    function getById($id)
    {

        $attributes = $this->getAll();
       foreach ($attributes as $attribute) {
            if ($attribute['id'] == $id) {
               return $attribute;
           }
       }
       return null;
    }

    function putDB($data)
    {
        $attributes = implode(',', $this->attributes);
        var_dump($attributes);
        $db = static::getDB();
        $stmt = "INSERT INTO $this->table ($attributes) VALUES (NULL, '$data')";
        var_dump($stmt);
        $query = $db->query($stmt);

    }


    function create ($data)
    {
        $attributes = implode("','", $data);
        $this->putDB($attributes);
        return $data;

    }

    function update($id,$data)
    {

        $dataArray1 = $this->getAll();
        foreach ($dataArray1 as $i => $item)
        {
            if($item['id'] == $id)
            {
                $dataArray = implode("','",$data);
                $this->delete($id);
                $this->putDB($dataArray);
            }
        }
    }

        function delete($id)
        {
            $attributes = $this->getAll();
            foreach ($attributes as $i => $attribute) {
                if ($attribute['id'] == $id) {
                    $db = static::getDB();
                    $sql = $db->query("DELETE FROM $this->table WHERE id='$id'");

                }
            }
        }

    public function getId()
    {
        $url = $_SERVER['REQUEST_URI'];
        $routeParts = explode('/', $url);
        $id = $routeParts[2];
        return $id;
    }




}