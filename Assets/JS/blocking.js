function blocking(id) {
    let flag = confirm('Are You Sure to Block This User?');
    if (flag) {
        $.ajax({
            url: '../helper.php',
            type: 'post',
            data: {
                user_id: id,
                action: 'blocking'
            },
            success: (data) => {
                if (data == '1') {
                    alert('User Blocked!!!');
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