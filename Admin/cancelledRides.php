<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
}
include_once('./Layout/header.php');
include_once('./Layout/ridesDetails.php');
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
    <br><br>
    <div class="input-group mb-3">
        <h1>Cancelled Rides:-</h1>
        <!-- <select class="mx-5 " id="sort" aria-label="Default select example">
            <option selected disabled>Sort By</option>
            <option value="1">Fare</option>
            <option value="2">Distance</option>
            <option value="3">Date</option>
        </select> -->


    </div>
    <table class="table table-dark table-striped" id="table3">
        
            <tr>
                <th>Pickup Point</th>
                <th>Drop Point</th>
                <th>Cab Type</th>
                <th>Ride Date</th>
                <th>Total Distance(in KM's)</th>
                <th>Luggage(in KG's)</th>
                <th>Total Fare(in INR)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        
    </table>

<?php


include_once('./Layout/footer.php');
?>
