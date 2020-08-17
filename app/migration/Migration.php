<?php
namespace App\Migration;

use Cu\Db\DBContext;

class Migration
{
    public static function migrate()
    {

        $queries = [
            'DROP DATABASE IF EXISTS cuongnm3_smart_osc',
            'CREATE DATABASE cuongnm3_smart_osc',
            'CREATE TABLE cuongnm3_smart_osc.persons(
          id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
          first_name VARCHAR(30) NOT NULL,
          last_name VARCHAR(30) NOT NULL,
          email VARCHAR(70) NOT NULL UNIQUE,
          is_active BINARY NOT NULL
        )',
            "INSERT INTO cuongnm3_smart_osc.persons(`first_name`, `last_name`, `email`, `is_active`) VALUES ('Peter', 'Parker', 'peterparker@gmail.com', true)",
            "INSERT INTO cuongnm3_smart_osc.persons(`first_name`, `last_name`, `email`, `is_active`) VALUES ('Marry', 'Smith', 'marrysmith@gmail.com' , true)",
            "INSERT INTO cuongnm3_smart_osc.persons(`first_name`, `last_name`, `email`, `is_active`) VALUES ('Azzan', 'tazz', 'azzantazz@gmail.com', true)",
            "INSERT INTO cuongnm3_smart_osc.persons(`first_name`, `last_name`, `email`, `is_active`) VALUES ('Parku', 'San', 'parkusan@gmail.com', true)",
            "INSERT INTO cuongnm3_smart_osc.persons(`first_name`, `last_name`, `email`, `is_active`) VALUES ('Nata', 'Bon', 'natabon@gmail.com', true)",

        ];
        $isSucess = true;
        foreach ($queries as $query) {
            $connection = DBContext::getConnection(true);
            try {
                $connection->beginTransaction();
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $stmt = null;
                $connection->commit();
            } catch (\Exception $ex) {
                $isSucess = false;
                echo $ex->getMessage();
                echo $query;
                $connection->rollback();
            }
            $connection = null;
        }
        return $isSucess;
    }

}
