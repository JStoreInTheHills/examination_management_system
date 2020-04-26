$(function () {
    $('#register_button').on('click', function (e) {
        e.preventDefault();
        var formData = {
            'full_name' : $('#full_name').val(),
            'email' : $('#email').val(),
            'password' : $('#password').val(),
            'repeat_password' : $('#repeat-password').val()
        };

        if (formData.password !== formData.repeat_password ){
            iziToast.error({
                title: 'Error',
                position: 'topRight',
                message: 'Password Dont Match.. Check the Username and Password..',
            });
        }else{
            $.ajax({
                'url' : './auth/add_user.php',
                'type' : 'post',
                data : formData,
            }).done(function (response) {
                var arr = JSON.parse(response);

                if (arr.success === true) {
                    iziToast.success({
                        title: 'Success',
                        position: 'topRight',
                        message: arr.message,
                    });
                } else {
                    iziToast.error({
                        title: 'Error',
                        position: 'topRight',
                        message: arr.message,
                    });
                }
            })
        }

    })
});