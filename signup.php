
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
  <span class="input-group-text" id="labelEmail">Email</span>
  <input type="email" class="form-control" placeholder="Enter Email" aria-describedby="basic-addon1" id="email" required>
</div>

            
            <button type="submit" class="btn btn-dark" id="register">Register Email ID</button>
</div>

</div>



<?php
include_once('./Layout/footer.php');
}