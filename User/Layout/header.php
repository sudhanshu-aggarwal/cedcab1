<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <title>CedCab</title>

    <link rel="stylesheet" href="/cedcab/Assets/CSS/index.css">
    <link rel="stylesheet" href="/cedcab/Assets/CSS/header.css">
    <link rel="stylesheet" href="/cedcab/Assets/CSS/login.css">
    <link rel="stylesheet" href="/cedcab/Assets/CSS/tiles.css">
    
</head>

<body>
    <header>
        <div id="logo">
            <a href="index.php"><img src="../Assets/Images/logo.png" alt="CEDCAB" width="100px" height="100px"></a>
            <a href="index.php"><h1>CEDCAB</h1></a>
        </div>
        <nav class="navlinks">
            <a href="index.php">Home</a>
            <a href="pendingRides.php">Rides</a>
            <a href="/cedcab/logout.php">Logout</a>
            <a href="#">Hello <?=$_SESSION['user']['name']?></a>
        </nav>
    </header>