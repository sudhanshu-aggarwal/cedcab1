$(document).ready(()=>{
    $.ajax({
        url: '../helper.php',
        type: 'post',
        data: {action: 'users'},
        success: (response)=>{
            console.log(response);
            // $('#table tbody > tr').remove();
            let res = JSON.parse(response);
            // console.log(res);
            // console.log(res[0]['pickup']);
            let tr;
            for(let i =0 ; i<res.length;i++)
            {
                tr = $('<tr></tr>');
                let td1 = $('<td></td>').text(res[i]['name']);
                let td2 = $('<td></td>').text(res[i]['email']);
                let td3 = $('<td></td>').text(res[i]['mobile']);
                let td5;
                let td4 = $('<td></td>');
                let button1;
                if(res[i]['status'] == '1')
                {
                td5 = $('<td></td>').text('Unblocked');

                    button1 = $('<button class="btn btn-danger" onclick = "blocking('+res[i]["user_id"]+')"></button>').text('Block');
                }
                else
                {
                td5 = $('<td></td>').text('Blocked');
                button1 = $('<button class="btn btn-success" onclick = "unblocking('+res[i]["user_id"]+')"></button>').text('Unblock');
                }
                td4.append(button1);
               
                tr.append(td1,td2,td3,td5,td4);
                $('#table5').append(tr);
            }
        }
    })
})