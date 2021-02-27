<?php
require_once('Dbcon.php');
class Location extends Dbcon{

    public function __construct()
    {
        $this->abst();
    }

    public function abst(){
        $this->connection();
    }

    public function getLocations()
    {
        $sql = "select `id`, `name` from `tbl_location` where `is_available` = '1'";
        $res = $this->conn->query($sql);
        return $res;
    }

    public function getDistance($id)
    {
        $sql = "select `distance` from `tbl_location` where `id` = '$id'";
        $res = $this->conn->query($sql);
        $distance = $res->fetch_assoc();
        return $distance['distance'];
    }

    public function getName($id){
        $sql = "select `name` from `tbl_location` where `id` = '$id'";
        $res = $this->conn->query($sql);
        $name = $res->fetch_assoc();
        return $name['name'];
    }

    public function getId($name){
        $sql = "select `id` from `tbl_location` where `name` = '$name'";
        $res = $this->conn->query($sql);
        $id = $res->fetch_assoc();
        return $id['id'];
    }

}