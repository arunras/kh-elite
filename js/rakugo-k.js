function load_hash_change_k(hash){
    result = false;

    /*
    * use this hash variable to determine what to do like which page to load or sth
    * e.g.
    * switch(hash){
    *   case "a": do_sth(); resutl = true; break;
    *   case "b": do_other_thing(); result = true; break;
    *   default: result = false; break;
    * }
    */
    hash = hash.split("/"); //try adding #shedule_detail/1 to the url
    switch(hash[0]){
        case "schedule_detail" : load_schedule_detail(hash[1]);
    }

    return result;
}


function load_schedule_detail(id){
    $("div#rakugo-content").html("");
}