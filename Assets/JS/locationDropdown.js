$(document).ready(()=>{
    $.ajax({
        url: '/cedcab/helper.php',
        type: 'post',
        data: {action: 'locationDropdown'},
        success: (res)=>{
            // console.log(res);
            let response = JSON.parse(res);
            for(let i=0;i<response.length;i++)
            {
                let option = $('<option value = '+response[i]['id']+'></option>').text(response[i]['name']);
                let option1 = $('<option value = '+response[i]['id']+'></option>').text(response[i]['name']);
                $('#pickup').append(option);
                $('#drop').append(option1);
            }
        }
    })
})