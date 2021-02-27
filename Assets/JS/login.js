$('#login').click((e)=>{
    e.preventDefault();
    $.ajax({
      url: '/cedcab/helper.php',
      type: 'post',
      data: {username: $('#username1').val(), password: $('#password1').val(), action: 'checkLogin'},
      success: (data)=>{
        if(data == '-2')
        {
          alert('Wrong Login Credentials!!!...Please Check and Try Again!!!...');
          $('#password1').focus();
        }
        else if(data == '-1'){
          alert('User Blocked!!!...Please Contact Support!!!...');
        }
        else if(data == '0')
        {
          alert('User Logged in');
          window.location.href = './User/';
        }
        else if(data == '1'){
          alert('Admin Logged in');
          window.location.href = './Admin/';
        }
        else{
          alert('Something went wrong!!!... '+data);
        }
      }
    })
  })