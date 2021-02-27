function viewDetails(id) {
    $.ajax({
        url: '../helper.php',
        type: 'post',
        data: {
            'id': id,
            action: 'viewDetails'
        },
        success: (res) => {
            // console.log(res);
            let response = JSON.parse(res);
            // console.log(response);
            if(response['status'] == '1')
            {
                $('.modal-body').html('Pickup Location: <label id="pickupPoint">' + response['pickup'] + '</label><br>Drop Location: <label id="dropPoint">' + response['drop'] + '</label><br>Luggage: <label id="totalLuggage">' + response['luggage'] + '</label> KG<br>Cab Type: <label id="typeofCab">' + response['cab_type'] + '</label><br>Total Distance: <label id="totalDistance">' + response['total_distance'] + '</label> KM<br>Total Fare: Rs <label id="totalFare">' + response['total_fare'] + '</label>/-<br>Date: '+ response['ride_date']+'<br>Status: Pending');
            }
            else if(response['status'] == '2')
            {
                $('.modal-body').html('Pickup Location: <label id="pickupPoint">' + response['pickup'] + '</label><br>Drop Location: <label id="dropPoint">' + response['drop'] + '</label><br>Luggage: <label id="totalLuggage">' + response['luggage'] + '</label> KG<br>Cab Type: <label id="typeofCab">' + response['cab_type'] + '</label><br>Total Distance: <label id="totalDistance">' + response['total_distance'] + '</label> KM<br>Total Fare: Rs <label id="totalFare">' + response['total_fare'] + '</label>/-<br>Date: '+ response['ride_date']+'<br>Status: Completed');
            }
            else{
                $('.modal-body').html('Pickup Location: <label id="pickupPoint">' + response['pickup'] + '</label><br>Drop Location: <label id="dropPoint">' + response['drop'] + '</label><br>Luggage: <label id="totalLuggage">' + response['luggage'] + '</label> KG<br>Cab Type: <label id="typeofCab">' + response['cab_type'] + '</label><br>Total Distance: <label id="totalDistance">' + response['total_distance'] + '</label> KM<br>Total Fare: Rs <label id="totalFare">' + response['total_fare'] + '</label>/-<br>Date: '+ response['ride_date']+'<br>Status: Cancelled');
            }
            $('#exampleModal').modal('show');
        }
    })
}