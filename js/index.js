$(document).ready(function () {
    $('#username').focus();
    $('.login-btn, .signup-btn').click(function () {
        $('.error').css('color','orange').html('Processing your request...');
        var method = $(this).val(), user = $('#username').val(), password = $('#password').val();
        console.log(method);
        $.ajax({
            type: 'GET',
            url: 'authenticate.php',
            data: { method: method, user: user, pass: password },
            success: function (response) {
                response = response.split(',');
                if( response[0] == '1' ){
                    $('.error').css('color', '#0d5').html(response[1]);
                    window.setTimeout(function(){window.location.href='dashboard.php';}, 1000);
                } else {
                    $('.error').css('color', 'crimson').html(response[1]);
                }
            },
            error: function (error) {
                $('.error').css('color','crimson').html('Please try after sometime!');
            }
        });
    });
    $('#password, #username').keydown(function(event){
        if(event.which == 13) $('.login-btn').click();
    });
});