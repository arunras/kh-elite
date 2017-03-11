function sethash(text){
    window.location.hash = text;
}

function gethash(){return window.location.hash.replace("#","");}

$(window).hashchange(function(){
    check_hash_change();
});

$(window).load(function(){
    check_hash_change();
});


function check_hash_change(){
    var hash = gethash();
    if(hash){
        if(load_hash_change_k(hash));
        else if(load_hash_change_r(hash));
        else if(load_hash_change_o(hash));
        else if(load_hash_change_y(hash));
    }
    else{
        url = window.location.toString();
        if(url.indexOf("#", 0) > 0 ){
            tmp = url.split("#");
            window.location = tmp[0];
        }
        load_index();
    }
}