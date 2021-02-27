$('#register').click((e)=>{
    e.preventDefault();
    // console.log('abc');
    if($('#email').val() != "")
    {
      $.ajax({
      url: '/cedcab/helper.php',
      type: 'post',
      data: {email: $('#email').val(), action: 'phpmailer'},
      success: (res)=>{
        if(res == '1')
        {
          alert('Email Already Registered!!!!...Try Again with different Email ID!!!');
          $('#email').focus();
        }
        else{
          $('#loginData').html(res);
          $('#verify').click((e)=>{
    e.preventDefault();
    if($('#otp').val() == "")
    {
      alert('Please Enter OTP!!!');
      // console.log($('#verify').val());
    }
    else{
      $.ajax({
        url: '/cedcab/helper.php',
        type: 'post',
        data: {email: $('#email').val(), otp: $('#otp').val(), action: 'verifyEmail'},
        success: (data)=>{
          // console.log(data);
          if(data == '0')
          {
            alert('Wrong OTP!!!..Try Again!!!..');
          }
          else{
            $('#loginData').html(data);
          }
        }
      })
    }
  })
        }
      },
      error: (e)=>{
        console.log(e);
      }
    })
    }
    else{
        alert('Please Enter Email ID!!!...');
    }
    
  });