$(document).ready(function(){

    //=============Password Reset Form
    $('#password_form').on('submit', function(e){
        e.preventDefault()
        let btn = $('.submit_btn')
        let old = $('#old_password').val()
        let npp = $('#new_password').val()
        let cpp = $('#confirm_password').val()

        if(old == '' || npp == '' || cpp == ''){
            notification('Fields cannot be empty');
        }else{
            
            if(npp != cpp){
                notification("Password Mismatch")
                return false;
            }else{
                if(old == npp){
                    notification('New password cannot be old password')
                }else{
                    $.ajax({
                        url: '/account/password',
                        method: 'POST',
                        data: {old, new:npp},
                        dataType: 'json',
                        beforeSend: function(){
                            btn.attr('disabled', 'disabled');
                        },
                        success: function(e){
                            notification(e, 'fff', '1b55e2')
                            btn.attr('disabled', false);
                            $('input#confirm_password').val('')
                            $('input#new_password').val('')
                            $('input#old_password').val('')
                        },
                        error: function(e){
                            console.log(e);
                            btn.attr('disabled', false);
                            notification(e.responseJSON)
                        }
                    })
                }
            }
        }
    })

    // =========== Update Profile settings
    $('.updateUser').on('submit', function(e){
        e.preventDefault();
        let btn = $('.submit_btn')
        let ths = $(this)
        $.ajax({
            url: '/account/update-profile',
            method: 'POST',
            data: ths.serialize(),
            cache: false,
            dataType: 'json',
            beforeSend: function(){
                btn.attr('disabled', 'disabled');
            },
            success: function(e){
                notification(e, 'fff', '1b55e2')
                btn.attr('disabled', false);
            },
            error: function(e){
                $(ths)[0].reset();
                btn.attr('disabled', false);
                notification(e.responseJSON)
            }
        })
    })

    $('#profileDp').on('change', function(e){
        let parent = $(this).parents('.up-controls');

        let reader = new FileReader()
        reader.onload = (e) => {
            parent.after(`
            <img src="${e.target.result}" style="height: 100px;width: 100px;object-fit: cover;" alt="">`)
        }
        reader.readAsDataURL(this.files[0])
        $('#updateButton').fadeIn()
    })

    $(document).on('submit', '#UpdateDp', function(e){
        e.preventDefault()
        $.ajax({
            url: '/account/update-pic',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(e){
                notification('Updated', 'fff', '8dbf42');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(e){
                notification('Tryagain', 'fff', 'e7515a')
            }
        })
    })

    //!==========Notification=============
    function notification(text, color = 'fff', bg = '3b3f5c'){
        Snackbar.show({
            pos: 'top-right',
            text: text,
            actionTextColor: '#'+color,
            backgroundColor: '#'+bg
        });
    }
})

// Primary #1b55e2
// Info #2196f3
// Success #8dbf42
// Danger #e7515a