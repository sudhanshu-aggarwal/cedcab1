$(document).ready(()=>{
    $.ajax({
        url: '/cedcab/helper.php',
        type: 'post',
        data: { action: 'countAllRides'},
        success: (res)=>{
            let response = JSON.parse(res);
            $('#cancelledRides').html(response['cancelledRides']);
            $('#pendingRides').html(response['pendingRides']);
            $('#totalRides').html(response['totalRides']);
            $('#totalEarning').html(response['totalAmount']+'/-');
            $('#users').html(response['users']);
        }
    })
})