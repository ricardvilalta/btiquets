function checkregisterform(form,reg_username,reg_surnames,reg_email,reg_tel,reg_password,reg_password_r,poutput) 
{    
    if(reg_username.val() != "" && reg_surnames.val() != "" && reg_email.val() != "" && reg_tel.val() != "" && reg_password.val() != "" && reg_password.val() == reg_password_r.val())
    {
        formhash(form, reg_password, poutput);
    }
    else
    {
        if(reg_username.val()=="")
        {
            reg_username.addClass('missing');
        }        
        else
        {
            reg_username.removeClass('missing');
        }
        
        if(reg_surnames.val()=="")
        {
            reg_surnames.addClass('missing');
        }        
        else
        {
            reg_surnames.removeClass('missing');
        }
        
        if(reg_email.val()=="")
        {
            reg_email.addClass('missing');
        }
        else
        {
            reg_email.removeClass('missing');
        }
        
        if(reg_tel.val()=="")
        {
            reg_tel.addClass('missing');
        }
        else
        {
            reg_tel.removeClass('missing');
        }
        
        if(reg_password.val() != reg_password_r.val())
        {
            reg_password.addClass('missing');
            reg_password_r.addClass('missing');
        }
        else
        {
            reg_password.removeClass('missing');
            reg_password_r.removeClass('missing');
        }
    }
}


function checkregisterform_edit_user(form,reg_username,reg_surnames,reg_email,reg_tel) 
{
    if(reg_username.val() != "" && reg_surnames.val() != "" && reg_email.val() != "" && reg_tel.val() != "")
    {
        $(form).submit();
    }
    else
    {
        if(reg_username.val()=="")
        {
            reg_username.addClass('missing');
        }        
        else
        {
            reg_username.removeClass('missing');
        }
        
        if(reg_surnames.val()=="")
        {
            reg_surnames.addClass('missing');
        }        
        else
        {
            reg_surnames.removeClass('missing');
        }
        
        if(reg_email.val()=="")
        {
            reg_email.addClass('missing');
        }
        else
        {
            reg_email.removeClass('missing');
        }
        
        if(reg_tel.val()=="")
        {
            reg_tel.addClass('missing');
        }
        else
        {
            reg_tel.removeClass('missing');
        }
    }
}

function checkregisterform_edit_password(form,reg_password,reg_password_r,poutput) 
{
    if(reg_password.val() != "" && reg_password.val() == reg_password_r.val())
    {
        formhash(form, reg_password, poutput);
    }
    else
    {
        if(reg_password.val() != reg_password_r.val())
        {
            reg_password.addClass('missing');
            reg_password_r.addClass('missing');
        }
        else
        {
            reg_password.removeClass('missing');
            reg_password_r.removeClass('missing');
        }
    }
}

function formhash(form, password, poutput) 
{
   $(poutput).val(hex_sha512($(password).val()));
   // Make sure the plaintext password doesn't get sent.
   $(password).val("");
   // Finally submit the form.
   $(form).submit();
}
