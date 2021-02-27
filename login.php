<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: User/');
    echo 'user';
}
elseif(isset($_SESSION['admin'])){
    header('Location: Admin/');
    echo 'admin';

}
else{
include_once('./Layout/header.php');
?>

<div id="loginMain">
<h1>Go With<span style="color: #419A1c"> Eco-Friendly</span> Cabs</h1>
<div id="loginData">
<div class="input-group mb-3">
  <span class="input-group-text" id="labelUsername">Username</span>
  <input type="text" class="form-control" placeholder="Enter Username" aria-label="Username" aria-describedby="basic-addon1" id="username1">
</div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="labelPassword">Password</span>
                <input type="password" class="form-control"  placeholder="Enter Password" id="password1">
            </div>
            <button type="submit" class="btn btn-dark" id="login">Login</button>
            </div>
</div>

</div>


<?php
include_once('./Layout/footer.php');

}