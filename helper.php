<?php

session_start();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'locationDropdown':
            require_once('./Class/Location.php');
            $arr = [];
            $i = 0;
            $obj = new Location();
            $res = $obj->getLocations();
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = $row;
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'calculateFare':

            require_once('./Class/Ride.php');
            require_once('./Class/Location.php');
            $cabtype = $_POST['cabtype'];
            $luggage = $_POST['luggage'];
            $locObj = new Location();
            $pickup = $locObj->getName($_POST['pickup']);
            $loc1 = $locObj->getDistance($_POST['pickup']);
            $drop = $locObj->getName($_POST['drop']);
            $loc2 = $locObj->getDistance($_POST['drop']);
            $distance = abs($loc1 - $loc2);
            $obj = new Ride();
            $totalFare = $obj->totalFare($pickup, $drop, $distance, $cabtype, $luggage);
            if ($cabtype == 'CedMicro') {
                $luggageReturn = "Not Allowed";
            } elseif ($luggage == "") {
                $luggageReturn = '0 KG';
            } else {
                $luggageReturn = "$luggage KG";
            }
            $cabtypeReturn = $cabtype;
            $arr = [$pickup, $drop, $distance, $totalFare, $luggageReturn, $cabtypeReturn];
            $arr = json_encode($arr);
            print_r($arr);

            break;

        case 'bookRide':



            if (isset($_SESSION['user'])) {
                require_once('./Class/Ride.php');
                require_once('./Class/Location.php');
                $locObj = new Location();
                $pickup = $locObj->getId($_POST['pickup']);

                $drop = $locObj->getId($_POST['drop']);
                $obj = new Ride();
                $res = $obj->bookRide($pickup, $drop, $_POST['distance'], (int)$_POST['luggage'], $_POST['fare'], $_SESSION['user']['user_id'], $_POST['cabType']);
                echo $res;
            } else {
                $_SESSION['book']['pickup'] = $_POST['pickup'];
                $_SESSION['book']['drop'] = $_POST['drop'];
                $_SESSION['book']['cabType'] = $_POST['cabType'];
                $_SESSION['book']['luggage'] = $_POST['luggage'];
                $_SESSION['book']['distance'] = $_POST['distance'];
                $_SESSION['book']['fare'] = $_POST['fare'];
                $_SESSION['book']['time'] = time();
                echo 0;
            }

            break;

        case 'phpmailer':
            $email = $_POST['email'];
            require_once('./Class/User.php');
            $result = new User();
            $response = $result->checkUsername($email);
            if ($response > 0) {
                echo '1';
            } else {
                $res = $result->phpmailer($email);
                if ($res) {
?>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="labelEmail">Email</span>
                        <input type="email" class="form-control" value="<?= $email ?>" aria-describedby="basic-addon1" id="email" required disabled>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="otp" placeholder="Enter OTP sent on Email">
                        <label for="otp">Enter OTP sent on Email</label>
                    </div>
                    <button type="submit" class="btn btn-dark" id="verify">Verify OTP</button>

                <?php
                }
            }
            break;

        case 'verifyEmail':
            if ($_POST['otp'] != $_SESSION['otp']) {
                echo '0';
            } else { ?>
                <form action="Helper/creatingUser.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="labelName">Name</span>
                        <input type="text" class="form-control" placeholder="Enter Name" name="name" aria-describedby="basic-addon1" id="name" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="labelPassword">Phone No.</span>
                        <input type="tel" class="form-control" name="phone" placeholder="Enter Phone Number" id="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Profile Picture</label>
                        <input class="form-control" type="file" name="file" id="file">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="labelEmail">Email</span>
                        <input type="email" class="form-control" value="<?= $_POST['email'] ?>" aria-describedby="basic-addon1" id="emailID" required disabled>
                    </div>
                    <input type="email" name="email" id="email" value="<?= $_POST['email'] ?>" style="display: none;">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="labelName">Password</span>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" aria-describedby="basic-addon1" id="password" required>
                    </div>

                    <input type="hidden" name="action" value="creatingUser">

                    <button type="submit" class="btn btn-dark" name='signup' id="signup">Sign Up</button>
                </form>
<?php
            }
            break;
        case 'creatingUser':
            require_once('./Class/User.php');

            if ($_FILES['file']['size'] != 0) {
                $imageFileType = pathinfo($_FILES['file']['name']);
                $file = $_POST['email'] . "." . $imageFileType['extension'];
                $target_file = './Asset/Uploads/' . $file;
                move_uploaded_file($_FILES['file']['tmp_name'], $target_file);


                $name = $_POST['name'];
                $email = $_POST['email'];
                $mobile = $_POST['phone'];
                $password = $_POST['password'];
                $obj = new User();
                $obj->newUser($name, $email, $mobile, $password, $file);
            } else {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $mobile = $_POST['phone'];
                $password = $_POST['password'];
                $obj = new User();
                $obj->newUser($name, $email, $mobile, $password);
            }


            header('Location: ./login.php');
            break;

        case 'checkLogin':
            require_once('./Class/User.php');
            $username = $_POST['username'];
            $password = $_POST['password'];
            $obj = new User();
            $res = $obj->checkLogin($username, $password);
            print_r($res);
            break;

        case 'bookingAfterLogin':
            $arr = [$_SESSION['book']['pickup'], $_SESSION['book']['drop'], $_SESSION['book']['distance'], $_SESSION['book']['fare'], $_SESSION['book']['luggage'], $_SESSION['book']['cabType']];
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'countRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $arr = $obj->countRides($_SESSION['user']['user_id']);
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'cancelling':

            if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
                require_once('./Class/Ride.php');

                $obj = new Ride();
                echo ($obj->cancelRide($_POST['ride_id']));
            } else {
                echo 'logged out';
            }
            break;

        case 'pendingDetails':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getRides($_SESSION['user']['user_id'], 1);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'viewDetails':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->gettingDetails($_POST['id']);
            $arr = json_encode($res->fetch_assoc());
            print_r($arr);
            break;

        case 'totalRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getTotalRides($_SESSION['user']['user_id']);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'cancelledRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getRides($_SESSION['user']['user_id'], 0);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'completedRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getRides($_SESSION['user']['user_id'], 2);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'countAllRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $arr = $obj->countAllRides();
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'pendingAllDetails':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getAllRides(1);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'approve':

            if (isset($_SESSION['admin'])) {
                require_once('./Class/Ride.php');

                $obj = new Ride();
                echo ($obj->approveRide($_POST['ride_id']));
            } else {
                echo 'logged out';
            }
            break;

        case 'allCancelledRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getAllRides(0);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'allCompletedRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getAllRides(2);
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'everyRides':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->getEveryRides();
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['ride_id' => $row['ride_id'], 'ride_date' => $row['ride_date'], 'total_distance' => $row['total_distance'], 'luggage' => $row['luggage'], 'total_fare' => $row['total_fare'], 'cab_type' => $row['cab_type'], 'pickup' => $row['pickup'], 'drop' => $row['drop'], 'status' => $row['status']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

        case 'users':
            require_once('./Class/Ride.php');
            $obj = new Ride();
            $res = $obj->users();
            $arr = [];
            $i = 0;
            while ($row = $res->fetch_assoc()) {
                $arr[$i] = ['name' => $row['name'], 'email' => $row['email_id'], 'mobile' => $row['mobile'], 'status' => $row['status'], 'user_id' => $row['user_id']];
                $i++;
            }
            $arr = json_encode($arr);
            print_r($arr);
            break;

            case 'blocking':

                if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
                    require_once('./Class/Ride.php');
    
                    $obj = new Ride();
                    echo ($obj->blocking($_POST['user_id']));
                } else {
                    echo 'logged out';
                }
                break;
    }
} else {
    die('You Can Not Access This Page!!!');
}
