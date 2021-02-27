<?php
require_once('Dbcon.php');
class Ride extends Dbcon
{
    public $pickup;
    public $drop;
    public $distance;
    public $cabtype;
    public $luggage;
    public $totalAmount;
    public $customer_user_id;
    public function __construct()
    {
        $this->abst();
    }
    public function abst()
    {
        $this->connection();
    }
    // public function connection($serverName = 'localhost', $username = 'root', $password = '', $database = 'CedCab')
    // {  
    //     $this->serverName = $serverName;
    //     $this->username = $username;
    //     $this->password = $password;
    //     $this->database = $database;
    //     $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
    // }

    public function cabtypeFare()
    {
        switch ($this->cabtype) {
            case 'CedMicro':
                return ['baseFare' => 50, 'distance1' => 13.5, 'distance2' => 12, 'distance3' => 10.2, 'distance4' => 8.5];
            case 'CedMini':
                return ['baseFare' => 150, 'distance1' => 14.5, 'distance2' => 13, 'distance3' => 11.2, 'distance4' => 9.5];
            case 'CedRoyal':
                return ['baseFare' => 200, 'distance1' => 15.5, 'distance2' => 14, 'distance3' => 12.2, 'distance4' => 10.5];
            case 'CedSUV':
                return ['baseFare' => 250, 'distance1' => 16.5, 'distance2' => 15, 'distance3' => 13.2, 'distance4' => 11.5];
        }
    }

    public function luggageFare()
    {
        $fare = 0;
        if ($this->cabtype == 'CedMicro') {
            return $fare;
        } else if ($this->luggage <= 0) {
            return $fare;
        } else {
            if ($this->luggage <= 10) {
                $fare = 50;
            } elseif ($this->luggage <= 20) {
                $fare = 100;
            } else {
                $fare = 200;
            }

            if ($this->cabtype == 'CedSUV') {
                return 2 * $fare;
            }
            return $fare;
        }
    }

    public function distanceFare()
    {
        $charges = $this->cabtypeFare();
        $fare = 0;
        if ($this->distance == 0) {
            return $fare;
        }

        $fare = $charges['baseFare'];
        $distance = $this->distance;
        if ($distance <= 10) {
            $fare += ($distance * $charges['distance1']);
            return $fare;
        }
        $distance -= 10;
        $fare += (10 * $charges['distance1']);
        if ($distance <= 50) {
            $fare += ($distance * $charges['distance2']);
            return $fare;
        }
        $distance -= 50;
        $fare += (50 * $charges['distance2']);
        if ($distance <= 100) {
            $fare += ($distance * $charges['distance3']);
            return $fare;
        }
        $distance -= 100;
        $fare += (100 * $charges['distance3']);
        $fare += ($distance * $charges['distance4']);
        return $fare;
    }

    public function totalFare($pickup, $drop, $distance, $cabtype, $luggage)
    {
        $this->pickup = $pickup;
        $this->drop = $drop;
        $this->distance = $distance;
        $this->cabtype = $cabtype;
        $this->luggage = $luggage;
        $luggageCharge = $this->luggageFare();
        $distanceCharge = $this->distanceFare();
        $this->totalAmount = $luggageCharge + $distanceCharge;
        return $this->totalAmount;
    }

    public function bookRide($from, $to, $total_distance, $luggage, $total_fare, $customer_user_id, $cab_type)
    {
        $this->pickup = $from;
        $this->drop = $to;
        $this->distance = $total_distance;
        $this->cabtype = $cab_type;
        $this->luggage = $luggage;
        $this->totalAmount = $total_fare;
        $this->customer_user_id = $customer_user_id;
        $sql = "insert into `tbl_ride`(`ride_date`, `from`, `to`, `total_distance`, `luggage`, `total_fare`, `status`, `customer_user_id`, `cab_type`) values(current_date(), '$from', '$to', '$total_distance', '$luggage', '$total_fare', '1', '$customer_user_id', '$cab_type');";
        if ($this->conn->query($sql)) {
            return 1;
        }
        return 2;
    }

    // public function getCompletedRides($id)
    // {
    //     $sql = "select a.`ride_date`, b.`name` as `pickup`, c.`name` as `drop`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "' and a.`status` = '2';";
    //     return $this->conn->query($sql);
    // }

    // public function getCancelledRides($id)
    // {
    //     $sql = "select a.`ride_date`, b.`name` as `pickup`, c.`name` as `drop`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "' and a.`status` = '0';";
    //     return $this->conn->query($sql);
    // }

    // public function getPendingRides($id)
    // {
    //     $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "' and a.`status` = '1';";
    //     return $this->conn->query($sql);
    // }

    public function getRides($id, $status)
    {
        $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "' and a.`status` = '$status';";
        return $this->conn->query($sql);
    }

    public function countRides($id)
    {
        $res1 = $this->getRides($id, 0);
        $res2 = $this->getRides($id, 1);
        $res3 = $this->getTotalRides($id);
        $res = $this->getTotalExpenses($id);
        if (isset($res['sum'])) {
            return ["cancelledRides" => $res1->num_rows, "pendingRides" => $res2->num_rows, "totalRides" => $res3->num_rows, "totalAmount" => $res['sum']];
        } else {
            return ["cancelledRides" => $res1->num_rows, "pendingRides" => $res2->num_rows, "totalRides" => $res3->num_rows, "totalAmount" => '0'];
        }
    }

    public function getTotalRides($id)
    {
        $sql = "select a.`ride_id`, a.`ride_date`, b.`name` as `pickup`, c.`name` as `drop`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, a.`status` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "';";
        return $this->conn->query($sql);
    }

    public function getTotalExpenses($id)
    {
        $sql = "select SUM(`total_fare`) as sum from tbl_ride where customer_user_id = '" . $id . "' and status = '2';";
        $res = $this->conn->query($sql);
        return $res->fetch_assoc();
    }

    public function cancelRide($id)
    {
        $sql = "update `tbl_ride` set `status` = '0' where `ride_id` = '" . $id . "';";
        if ($this->conn->query($sql)) {
            return 1;
        }
        return 0;
    }

    public function sortingPendingRides($id, $sort)
    {
        $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "' and a.`status` = '1' order by {$sort};";
        return $this->conn->query($sql);
    }

    public function sortingTotalRides($id, $sort)
    {
        $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop`, a.`status` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`customer_user_id` = '" . $id . "'  order by {$sort};";
        return $this->conn->query($sql);
    }

    public function gettingDetails($ride_id)
    {
        $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop`, a.`status` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`ride_id` = '" . $ride_id . "';";
        return $this->conn->query($sql);
    }

    public function countAllRides()
    {
        $res1 = $this->getAllRides( 0);
        $res2 = $this->getAllRides( 1);
        $res3 = $this->getEveryRides();
        $res = $this->getTotalEarning();
        $res4 = $this->getUsers();
        if (isset($res['sum'])) {
            return ["cancelledRides" => $res1->num_rows, "pendingRides" => $res2->num_rows, "totalRides" => $res3->num_rows, "totalAmount" => $res['sum'], "users"=> $res4];
        } else {
            return ["cancelledRides" => $res1->num_rows, "pendingRides" => $res2->num_rows, "totalRides" => $res3->num_rows, "totalAmount" => '0', "users"=> $res4];
        }
    }

    public function getAllRides($status)
    {
        $sql = "select a.`ride_id`, a.`ride_date`,  a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, b.`name` as `pickup`, c.`name` as `drop` , a.`status` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id` where a.`status` = '$status';";
        return $this->conn->query($sql);
    }

    public function getEveryRides()
    {
        $sql = "select a.`ride_id`, a.`ride_date`, b.`name` as `pickup`, c.`name` as `drop`, a.`total_distance`, a.`luggage`, a.`total_fare`, a.`cab_type`, a.`status` from `tbl_ride` as a JOIN `tbl_location` as b ON a.`from` = b.`id` JOIN `tbl_location` as c ON a.`to` = c.`id`";
        return $this->conn->query($sql);
    }

    public function getTotalEarning()
    {
        $sql = "select SUM(`total_fare`) as sum from tbl_ride where status = '2';";
        $res = $this->conn->query($sql);
        return $res->fetch_assoc();
    }

    public function getUsers()
    {
        $sql = "select Distinct(`customer_user_id`) from tbl_ride";
        $res = $this->conn->query($sql);
        return $res->num_rows;
    }

    public function approveRide($id)
    {
        $sql = "update `tbl_ride` set `status` = '2' where `ride_id` = '" . $id . "';";
        if ($this->conn->query($sql)) {
            return 1;
        }
        return 0;
    }

    public function users()
    {
        $sql = "select * from `tbl_user` where `is_admin` = '0'";
        return $this->conn->query($sql);
    }
}
