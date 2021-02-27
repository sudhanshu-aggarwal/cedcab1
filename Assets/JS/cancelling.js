function cancelling(id) {
    let flag = confirm('Are You Sure to Cancel This Ride?');
    if (flag) {
        $.ajax({
            url: '../helper.php',
            type: 'post',
            data: {
                ride_id: id,
                action: 'cancelling'
            },
            success: (data) => {
                if (data == '1') {
                    alert('Ride Canceled!!!');
                    location.reload();
                } else if (data == 'logged out') {
                    location.reload();
                } else {
                    alert('Some error occured!!!...Try Again!!!...');
                }
            }
        })
    }
}