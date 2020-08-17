<?php
namespace App\Model;

use Cu\Model\Model;
use Cu\Db\DBContext;

class PersonModel extends Model
{
    protected $table_name;
    public function __construct()
    {
        // $this->sayHello();
        $this->table_name = 'persons';
    }

    public function getExistingEmail($id, $data)
    {
        // initialize response;
        $res = [];
          
        $connection = DBContext::getConnection();
        if($connection == null) {
          $res['err'] = "Can not get connection";
          return $res;
        }

        // set up query
        $where = '';
        foreach ($data as $colName => $value) {
            $where .= " `$colName` = :$colName and";
        }
        
        $query = "SELECT * FROM $this->table_name WHERE $where id != :id";
        $data['id'] = $id;
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

    public function getPeopleByName($searchingName)
    {
        // initialize response;
        $res = [];

        $connection = DBContext::getConnection();
        if($connection == null) {
          $res['err'] = "Can not get connection";
          return $res;
        }
        
        $query = "SELECT *, CONCAT(first_name, ' ' ,last_name) as `full_name` FROM `persons` WHERE CONCAT(first_name, ' ' ,last_name) LIKE '%$searchingName%'";

        $res['query'] = $query;

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
}
