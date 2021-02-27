$(document).ready(()=>{
    $.ajax({
        url: '/cedcab/helper.php',
        type: 'post',
        data: { action: 'countRides'},
        success: (res)=>{
            let response = JSON.parse(res);
            $('#cancelledRides').html(response['cancelledRides']);
            $('#pendingRides').html(response['pendingRides']);
            $('#totalRides').html(response['totalRides']);
            $('#totalSpent').html(response['totalAmount']+'/-');
        }
    })
})