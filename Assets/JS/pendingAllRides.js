$(document).ready(()=>{
    $.ajax({
        url: '../helper.php',
        type: 'post',
        data: {action: 'pendingAllDetails'},
        success: (response)=>{
            console.log(response);
            // $('#table tbody > tr').remove();
            let res = JSON.parse(response);
            console.log(res);
            // console.log(res[0]['pickup']);
            let tr;
            for(let i =0 ; i<res.length;i++)
            {
                tr = $('<tr></tr>');
                let td1 = $('<td></td>').text(res[i]['pickup']);
                let td2 = $('<td></td>').text(res[i]['drop']);
                let td3 = $('<td></td>').text(res[i]['cab_type']);
                let td4 = $('<td></td>').text(res[i]['ride_date']);
                let td5 = $('<td></td>').text(res[i]['total_distance']);
                let td6 = $('<td></td>').text(res[i]['luggage']);
                let td7 = $('<td></td>').text(res[i]['total_fare']);
                let button1 = $('<button class="btn btn-danger" onclick = "cancelling('+res[i]["ride_id"]+')"></button>').text('Cancel');
                let button2 = $('<button class="btn btn-success" value='+res[i]['ride_id']+' onclick="approve('+res[i]['ride_id']+')"></button>').text('Approve');
                
                let td8 = $('<td></td>');
                let td9 = $('<td></td>').text("Pending");
               
                td8.append(button2);
                td8.append(button1);
                tr.append(td1,td2,td3,td4,td5,td6,td7,td9,td8);
                $('#table').append(tr);
            }
        }
    })
})