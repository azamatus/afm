jQuery(document).ready(function(){
    $('#form_registration form').validate({
        rules: {
            "fos_user_registration_form[username]":{
                required: true
            },
            "fos_user_registration_form[email]":{
                required: true,
                email: true
            },
            "fos_user_registration_form[firstname]":{
                required: true
            },
            "fos_user_registration_form[lastname]":{
                required: true
            },
            "fos_user_registration_form[plainPassword][first]":{
                required: true
            },
            "fos_user_registration_form[plainPassword][second]":{
                required: true,
                equalTo: "#fos_user_registration_form_plainPassword_first"
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("error")){
                element.next().remove();
                element.parent().parent().addClass('error');
                element.parent().append("<span class='help-inline'><i class='icon-remove'></i> "+trans.someMessage.invalide_input+"</span>");
                if(element.attr('id') == 'fos_user_registration_form_plainPassword_second'){
                    element.parent().parent().addClass('error');
                    element.next().remove();
                    element.parent().append("<span class='help-inline'><i class='icon-remove'></i> "+trans.someMessage.password_not_match+"</span>");
                }
            }else {
                element.parent().parent().removeClass('error');
                element.next().remove();
            }
        },
        success: function() {
        }
    })
});