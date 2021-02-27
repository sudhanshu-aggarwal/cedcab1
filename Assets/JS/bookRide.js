function bookRide(){
    $.ajax({
        url: '/cedcab/helper.php',
        method: 'post',
        data: {pickup: $('#pickupPoint').text(), drop: $('#dropPoint').text(), luggage: $('#totalLuggage').text(), cabType: $('#typeofCab').text(), distance: $('#totalDistance').text(), fare: $('#totalFare').text(), action: 'bookRide'},
        success: (data)=>{
            if(data == '1')
            {
                alert('Cab Booked');
                window.location.href = 'pendingRides.php';

            }
            else if(data == '2')
            {
                alert('Some Technical Problem Occurred!!!...Please try Again Later!!!...');
            }
            else{
                alert('Please Login for Book Ride');
                window.location.href = './login.php';
            }
        }
    })
}