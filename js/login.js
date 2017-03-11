var login_url;
function check_valid(){
    login_url = window.location;
    if($("#txtid").val() == "" || $("#txtpassword").val() == ""){
            return false;
    }
    return true;
}

function finish_login(){
    window.location = login_url;
}