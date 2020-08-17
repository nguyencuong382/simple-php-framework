<?php
namespace Cu\Model;

use Cu\Db\DBContext;
use Cu\Model\IModel;

class Model implements IModel
{
    protected $table_name = '';

    public function __construct()
    {
    }

    public function all()
    {
        $res = [];

        $connection = DBContext::getConnection();
        if ($connection == null) {
            $res['err'] = "Can not get connection";
            return $res;
        }

        $query = "SELECT * FROM $this->table_name";
        $stmt = $connection->prepare($query);

        try {
            $result = array();
            $connection->beginTransaction();
            $stmt->execute();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                array_push($result, $row);
            }

            $stmt = null;
            $connection->commit();

            $res['data'] = $result;
        } catch (\Exception $ex) {
            //throw $th;
            $res['err'] = $ex->getMessage();
            $connection->rollback();
        }
        $connection = null;

        return $res;
    }

    public function get($data)
    {
        // initialize response;
        $res = [];

        $res = [];

        $connection = DBContext::getConnection();
        if ($connection == null) {
            $res['err'] = "Can not get connection";
            return $res;
        }

        // set up query
        $where = '';
        foreach ($data as $colName => $value) {
            $where .= " `$colName` = :$colName and";
        }
        $where = substr($where, 0, strlen($where) - 3);

        $query = "SELECT * FROM $this->table_name WHERE $where";

        $res['query'] = $query;

        $stmt = $connection->prepare($query);

        try {
            $result = array();
            $connection->beginTransaction();
            $stmt->execute($data);

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                array_push($result, $row);
            }

            $stmt = null;
            $connection->commit();

            $res['data'] = $result;
        } catch (\Exception $ex) {
            //throw $th;
            $res['err'] = $ex->getMessage();
            $connection->rollback();
        }
        $connection = null;

        return $res;
    }

    public function add($data)
    {
        // initialize response;
        $res = [];

        $connection = DBContext::getConnection();
        if ($connection == null) {
            $res['err'] = "Can not get connection";
            return $res;
        }

        // set up query
        $set = "";
        $value_insert = "";
        foreach ($data as $colName => $value) {
            $set .= "`$colName`,";
            $value_insert .= "'$value',";
        }
        $set = substr_replace($set, "", -1);
        $value_insert = substr_replace($value_insert, "", -1);

        $query = "INSERT INTO $this->table_name($set) VALUES ($value_insert)";
        // end of set up query

        $res['query'] = $query;
        $last_id = -1;
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare($query);
            $row_effect = $stmt->execute();
            $stmt = null;
            $data['id'] = $connection->lastInsertId();
            $connection->commit();
            $res['data'] = $data;
        } catch (\Exception $ex) {
            $connection->rollback();
            $res['err'] = $ex->getMessage();
        }

        $connection = null;
        return $res;
    }

    public function edit($id, $data)
    {
        $res = [];

        $connection = DBContext::getConnection();
        if ($connection == null) {
            $res['err'] = "Can not get connection";
            return $res;
        }
        $set = "";
        foreach ($data as $colName => $value) {
            $set .= "$colName = :$colName,";
        }
        $set = substr_replace($set, "", -1);
        $query = "UPDATE $this->table_name SET $set WHERE id = $id";
        $res['query'] = $query;
        $row_effected = 0;
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare($query);
            $row_effected = $stmt->execute($data);
            $stmt = null;
            $connection->commit();
        } catch (\Exception $ex) {
            $res['err'] = $ex->getMessage();
            $connection->rollback();
        }

        $res['row_effected'] = $row_effected;

        if ($row_effected === 0) {
            $res['err'] = 'Failed to update';
        }

        return $res;

    }

    public function delete($id)
    {
        $data = ['is_active' => 0];
        $result = $this->edit($id, $data);
        $result['data'] = "Deleted record with id = $id";
        return $result;
    }
}
