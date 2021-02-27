<?php
session_start();
if(!isset($_SESSION['user'])){
    header('Location: /cedcab/login.php');
}

include_once('./Layout/header.php');
?>
<div id="main">
    <h1>Book a City Taxi to your destination in town</h1>
    <h3>Choose from a range of categories and prices</h3>
        <div id="data">
            <label for="pickup" class="form-label" id="labelPickup">Enter Pickup Location</label>
            <select class="form-select" aria-label="Default select example" name="pickup" id="pickup">
                <option value="Pickup" selected disabled>Pickup Location</option>
            </select><br>
            <label for="drop" class="form-label" id="labelDrop">Enter Drop Location</label>

            <select class="form-select" aria-label="Default select example" name="drop" id="drop">
                <option value="Drop" selected disabled>Drop Location</option>
            </select><br>
            <label for="cabtype" class="form-label" id="labelCabtype">Select Cab Type</label>

            <select class="form-select" aria-label="Default select example" name="cabtype" id="cabtype">
                <option value="cabtype" selected disabled>Cab Type</option>
                <option value="CedMicro">Ced Micro</option>
                <option value="CedMini">Ced Mini</option>
                <option value="CedRoyal">Ced Royal</option>
                <option value="CedSUV">Ced SUV</option>
                
            </select><br>
            <div class="input-group mb-3">
                <span class="input-group-text" id="labelLuggage">Luggage</span>
                <input type="number" class="form-control" aria-label="Dollar amount (with dot and two decimal places)" placeholder="Luggage in KG" id="luggage">
            </div>
            <button type="submit" class="btn btn-dark" id="calculate">Calculate Fare</button>
            </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="bookRide()">Book Ride</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php

if(isset($_SESSION['book']))
{
    $check = time() - $_SESSION['book']['time'];
    if($check >= 120)
    {
        
        unset($_SESSION['book']);
    }
    else{
?>
    <script>
    $(document).ready(()=>{
        $.ajax({
            url: '/cedcab/helper.php',
            method: 'post',
            data: {action: 'bookingAfterLogin'},
            success: (res)=>{
                
                let response = JSON.parse(res);
                    $('.modal-body').html('Pickup Location: <label id="pickupPoint">' + response[0] + '</label><br>Drop Location: <label id="dropPoint">' + response[1] + '</label><br>Luggage: <label id="totalLuggage">' + response[4] + '</label><br>Cab Type: <label id="typeofCab">' + response[5] + '</label><br>Total Distance: <label id="totalDistance">' + response[2] + '</label> KM<br>Total Fare: Rs <label id="totalFare">' + response[3] + '</label>/-');
                    $('#exampleModal').modal('show');
            }
        })
       
    });
       

    
    </script>
    <?php
}
}
include_once('./Layout/footer.php');

?>
