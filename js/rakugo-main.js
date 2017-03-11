var base_url;
var rLanguage;
var fullCalendarLanguage;
var dataTableLanguage;
$(document).ready(function(){
    //base_url = window.location.toString();
    //var i = base_url.indexOf("rakugo", 0) + 7;
    //base_url = base_url.substr(0, i);
    base_url = $("#base_url").val();

    rLanguage = $("#rLanguage").val();


    $("a.fancybox").fancybox({
    'overlayShow'	: true,
    'transitionIn'	: 'elastic',
    'transitionOut'	: 'elastic',
    'easingIn' : 	'swing',
    'easingOut' : 	'swing',
    'autoDimensions': true
    });
    
    if($.browser.msie){
        $("a").click(function(){
            var lc = $(this).attr("href");
            if(lc != "#" && lc != ""){
                window.location = lc;
            }
        });
    }
        
});

function load_index(){
    $("div#rakugo-content").load("include/rakugo-index.php");
}


function toDate(value, lang){
    if(lang == "ja")
        return Date.parse(value.match(/[\d\.]+/g) + " 00:00:00");
    else return Date.parse(value + " 00:00:00");
}
