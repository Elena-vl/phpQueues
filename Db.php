<?php

/**
 * Class Db
 * элементы очереди, хранятся в базе данных в отдельной таблице, в которой будет три столбца: идентификатор, идентификатор пользователя, пароль пользователя.
 */
class Db
{
    private $mysqli = NULL;

    public function __construct($host,$user,$pass,$db) {

        $this->mysqli = new mysqli($host,$user,$pass,$db);
        if ($this->mysqli->connect_error) {
            die('Ошибка подключения (' . $this->mysqli->connect_errno . ') '
                . $this->mysqli->connect_error);
        }
    }

    public function __destruct() {
        $this->mysqli->close();
    }

    public function changePassword($post,$id) {
        ///!!!md5();
        $query = "UPDATE `users` SET `password` = '".md5($this->mysqli->real_escape_string($post['password']))."' WHERE `id` = ".$id;
        $this->mysqli->query($query);
        return TRUE;
    }

    public function saveList($arr,$id) {


        $queryDelete = "DELETE FROM `passwords` WHERE `user_id` = ".$id;
        $this->mysqli->query($queryDelete);

        $queryInsert = "INSERT INTO `passwords` (`user_id`,`password`) VALUES ";
        foreach($arr as $key=>$item) {
            if($key > 0) {
                $queryInsert .= ",";
            }
            $queryInsert .= "(";
            $queryInsert .= "'".$id."','".$item."'";
            $queryInsert .= ")";
        }

        $this->mysqli->query($queryInsert);
        return TRUE;
    }

    public function getPasswordsList($id) {
        ///!!!md5();
        $query = "SELECT `password` FROM `passwords` WHERE `user_id` = ".$id;
        $result = $this->mysqli->query($query);
        if($result) {
            return array_map(function($item) {
                return $item[0];
            },$result->fetch_all());
        }
        return FALSE;
    }
}