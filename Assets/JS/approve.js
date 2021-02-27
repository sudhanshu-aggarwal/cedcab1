function approve(id) {
    let flag = confirm('Are You Sure to Approve This Ride?');
    if (flag) {
        $.ajax({
            url: '../helper.php',
            type: 'post',
            data: {
                ride_id: id,
                action: 'approve'
            },
            success: (data) => {
                if (data == '1') {
                    alert('Ride Approved!!!');
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