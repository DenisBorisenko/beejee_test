<?php

namespace Core;

use PDO;
use PDOException;

abstract class Model {

    public $db;
    public $table;
    public $dataResult;

    public function __construct($select = false) {
        $this->db = App::$database;

        $this->retrieveTableName();
        $this->processSelectQuery($select);
    }

    public function __toString() {
        $data = [];
        foreach ($this->fieldsTable() as $key => $value) {
            $data[$key] = $this->$key;
        }
        return json_encode($data);
    }

    public function retrieveTableName() {
        $modelName = get_class($this);
        $arrExp = explode('\\', $modelName);
        $tableName = strtolower($arrExp[count($arrExp) - 1]);

        $this->table = $tableName;
    }

    public function processSelectQuery($select) {

        $sql = $this->retrieveSelectQuery($select);
        if ($sql) {
            $this->applySelectQuery("SELECT * FROM $this->table" . $sql);
        }
    }

    public function retrieveSelectQuery($selectParams) {
        if (!is_array($selectParams)) return false;

        $querySql = "";

        if (isset($selectParams['WHERE'])) {
            $querySql .= " WHERE " . $selectParams['WHERE'];
        }

        if (isset($selectParams['ORDER'])) {
            $querySql .= " ORDER BY " . $selectParams['ORDER'];
        }

        if (isset($selectParams['LIMIT'])) {
            $querySql .= " LIMIT " . $selectParams['LIMIT'];
        }

        if (isset($selectParams['OFFSET'])) {
            $querySql .= " OFFSET " . $selectParams['OFFSET'];
        }

        return $querySql;
    }

    public function applySelectQuery($sql) {
        $stmt = $this->db->query($sql);
        $this->dataResult = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function save() {
        $arrayAllFields = array_keys($this->fieldsTable());
        $arraySetFields = [];
        $arrayData = [];

        foreach ($arrayAllFields as $field) {
            if (!empty($this->$field)) {
                $arraySetFields[] = $field;
                $arrayData[] = $this->$field;
            }
        }
        $forQueryFields = implode(', ', $arraySetFields);
        $rangePlace = array_fill(0, count($arraySetFields), '?');
        $forQueryPlace = implode(', ', $rangePlace);

        $stmt = $this->db->prepare("INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)");
        $result = $stmt->execute($arrayData);

        return $result;
    }

    public function update() {
        $arrayAllFields = array_keys($this->fieldsTable());
        $arrayForSet = [];

        foreach ($arrayAllFields as $field) {
            if (!empty($this->$field)) {
                if (strtoupper($field) != 'ID') {
                    $arrayForSet[] = $field . ' = "' . $this->$field . '"';
                } else {
                    $whereID = $this->$field;
                }
            }
        }

        $strForSet = implode(', ', $arrayForSet);

        var_dump($strForSet);

        $db = $this->db;
        $stmt = $db->prepare("UPDATE $this->table SET $strForSet WHERE `id` = $whereID");
        $result = $stmt->execute();

        return $result;
    }

    public function selectTotalCountRows() {
        $stmt = $this->db->query("SELECT COUNT(1) FROM $this->table");
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function getAllRows() {
        if (!isset($this->dataResult) || empty($this->dataResult)) return false;
        return $this->dataResult;
    }

    public function getOneRow() {
        if (!isset($this->dataResult) OR empty($this->dataResult)) return false;
        return $this->dataResult[0];
    }

    public function fetchOne() {
        if (!isset($this->dataResult) || empty($this->dataResult)) return false;
        foreach ($this->dataResult[0] as $key => $val) {
            $this->$key = $val;
        }
        return true;
    }
}

