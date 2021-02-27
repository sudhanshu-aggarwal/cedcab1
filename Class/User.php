<?php
require_once('Dbcon.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;

class User extends Dbcon{

    const TABLE = 'tbl_user';
    public $name;
    public $email;
    public $mobile;
    public $password;
    public $is_admin;

    public function __construct()
    {
        $this->connection();
    }

    public function abst(){
        $this->connection();
    }
    public function connection($serverName = 'localhost', $username = 'root', $password = '', $database = 'CedCab')
    {  
        $this->serverName = $serverName;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->conn = new mysqli($this->serverName, $this->username, $this->password, $this->database);
    }

    public function checkUsername($email){
        $sql  = "select `email_id` from `tbl_user` where email_id = '$email'";
        $res = $this->conn->query($sql);
        return $res->num_rows;
    }
    
    public function checkLogin($email_id, $password)
    {
        $sql = "select * from `tbl_user` where email_id = '$email_id' AND password = MD5('$password')";
        $res = $this->conn->query($sql);
            // return $res;
            if($res->num_rows > 0){
                $fetch = $res->fetch_assoc();
                // return $fetch;
            if($fetch['is_admin'] == 1)
            {
                $_SESSION['admin']['name'] = $fetch['name'];
                $_SESSION['admin']['user_id'] = $fetch['user_id'];
                return 1;
            }
            else if($fetch['status'] == 1){
                $_SESSION['user']['name'] = $fetch['name'];
                $_SESSION['user']['user_id'] = $fetch['user_id'];
                return 0;
            }
            else{
                return -1;
            }
        }
        else{
            return -2;
        }
    }

    public function newUser($name, $email, $mobile, $password,$file = null, $is_admin = 0)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->password = $password;
        $this->is_admin = $is_admin;
        $sql = "insert into `".self::TABLE."`(`email_id`,`name`,`dateofsignup`,`mobile`,`status`,`password`,`is_admin`, `picture`) values('$email','$name',now(),'$mobile',1,md5('$password'),'$is_admin', '$file')";
        $this->conn->query($sql);
    }

    public function phpmailer($email){

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";
        
        $mail = new PHPMailer();
        $mail->SMTPOptions = array(
          'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
          )
          );
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $otp = rand(1001,9999);
        
        $_SESSION['otp'] = $otp;
        
        $mail->isHTML(true);
        $mail->setFrom($email, 'CEDCAB Registration');
        $mail->addAddress($email);
        $mail->Subject = ("OTP for Registration");
        $mail->Body = 'OTP for your Registration is: '.$otp;
        
        
        
        return $mail->send();
    }

    public function getUsers()
    {
        $sql = "select * from `tbl_user` where `is_admin` = '0'";
        $res = $this->conn->query($sql);
        return $res->num_rows;
    }
}