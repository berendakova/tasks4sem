<?php

class DataMapper
{
    protected $userName;
    protected $password;
    protected $host;
    protected $dbName;
    protected $tableName;
    protected $pk;
    protected $pdo;
    public $attributes;


    function __construct($id = null)
    {
        $this->pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->userName, $this->password);
        $this->tableName = strtolower(static::class . 's');
        if (!($this->isExistingTable())) {
            throw new PDOException("table isn't exist");
        }
        $query = $this->pdo->prepare("DESCRIBE $this->tableName");
        $query->execute();
        $tableFields = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->attributes = new stdClass();
        foreach ($tableFields as $field) {
            $this->attributes->{$field} = null;
        }
        $this->setPk($this->pk);
        $existingAttributes = $this->select($id);
        if ($existingAttributes !== null) {
            $this->setAttributes($existingAttributes);
        }
    }

    public function setPk($pk): void
    {
        if (self::property_path_exists($this, "attributes->$pk")) {
            $this->pk = $pk;
        } else {
            throw new Exception($pk . ' is not exist');
        }
    }

    public function select($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE $this->pk=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $object = $stmt->fetch(PDO::FETCH_OBJ);
        return ($object !== false) ? $object : null;
    }

    protected function setAttributes($attributes)
    {
        foreach ($this->attributes as $attributeName => &$attributeValue) {
            $attributeValue = $attributes->{$attributeName} ?? null;
        }
        return $this;
    }


    public function delete()
    {
        $stmt = $this->pdo->prepare("DELETE FROM $this->tableName WHERE $this->pk=:id");
        $stmt->bindParam(':id', $this->attributes->id, PDO::PARAM_STR);
        return $stmt->execute();
    }


    public function upsert()
    {
        if (($this->select($this->attributes->id)) === null) {
            $prepareString = $this->prepareInsertString();
            $stmt = $this->pdo->prepare("INSERT INTO $this->tableName (" . $prepareString['columns'] . ") VALUES (" . $prepareString['values'] . ")");
            $result = $stmt->execute((array)$this->attributes);
        } else {
            $prepareString = $this->prepareUpdateString();
            $stmt = $this->pdo->prepare("UPDATE $this->tableName SET {$prepareString['columns']} WHERE {$prepareString[$this->pk]}");
            $result = $stmt->execute((array)$this->attributes);
        }

        return $result;
    }

    public function prepareUpdateString()
    {
        $prepareStrings = [
            'columns' => '',
            $this->pk => '',
        ];

        foreach ($this->attributes as $attributeKey => $attributeValue) {
            if ($attributeKey === $this->pk){
                $prepareStrings[$this->pk] = "$attributeKey=:$attributeKey";
            }else {
                $prepareStrings['columns'] .= "$attributeKey=:$attributeKey, ";
            }

        }
        $prepareStrings['columns'] = rtrim($prepareStrings['columns'], ", \t\n");

        return $prepareStrings;
    }

    public function prepareInsertString()
    {
        $prepareStrings = [
            'columns' => '',
            'values' => '',
        ];

        foreach ($this->attributes as $attributeKey => $attributeValue) {
            $prepareStrings['columns'] .= "$attributeKey, ";
            $prepareStrings['values'] .= ":$attributeKey, ";
        }
        $prepareStrings['columns'] = rtrim($prepareStrings['columns'], ", \t\n");
        $prepareStrings['values'] = rtrim($prepareStrings['values'], ", \t\n");

        return $prepareStrings;
    }

    public function getAllPaginated($offset, $limit)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->tableName LIMIT :offset, :limit ");
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function property_path_exists($object, $property_path)
    {
        $path_components = explode('->', $property_path);

        if (count($path_components) == 1) {
            return property_exists($object, $property_path);
        } else {
            return (
                property_exists($object, $path_components[0]) &&
                static::property_path_exists(
                    $object->{array_shift($path_components)},
                    implode('->', $path_components)
                )
            );
        }
    }

    private function isExistingTable()
    {
        try {
            $result = $this->pdo->query("SELECT 1 FROM $this->tableName");
        } catch (Exception $e) {
            return FALSE;
        }

        return $result !== FALSE;
    }
}