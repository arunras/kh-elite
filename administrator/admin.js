$(document).ready(function(){

    /* For block sns top: sns */
    var pre_sns = $("div#sns_top div.display").html();
    $("div#sns_top").addClass("ads_block");

    //$("#ad_a textarea").parents("div.cleditorMain").hide();

    $("div#sns_top").click(function(){
        setEditor("sns_top", 520, 100, "bold italic underline strikethrough subscript superscript | image link unlink | cut copy paste pastetext | source");
        $(this).prev().show();
        $("textarea#sns_top").html(pre_sns);

        $(this).removeClass("ads_block");
        $(this).find("div.display").hide();

        $(this).prev("a").click(function(){
            $.post(
                base_url + "administrator/save_config.php?param=sns_top",
                $("form#sns_top").serialize(),
                function(data){
                    remove_cleditor("sns_top");
                    $("div#sns_top").prev("a").hide();
                    $("div#sns_top div.display").html(data).show();
                    $("div#sns_top").addClass("ads_block");
                }
            );
        });
    });

    /* for top advertisement */
    var pre_a = $("#ad_a div.display").html();
    $("#ad_a").addClass("ads_block");

    //$("#ad_a textarea").parents("div.cleditorMain").hide();

    $("#ad_a").click(function(){
        setEditor("t_ads_a", 1080, 100);
        $(this).prev().show();
        $("#t_ads_a").html(pre_a);

        $(this).removeClass("ads_block");
        $(this).find("div.display").hide();

        $(this).prev("a").click(function(){
            $.post(
                base_url + "administrator/save_config.php?param=ads_a",
                $("#form_ads_a").serialize(),
                function(data){
                    remove_cleditor("t_ads_a");
                    $("#ad_a").prev("a").hide();
                    $("#ad_a div.display").html(data).show();
                    $("#ad_a").addClass("ads_block");
                }
            );
        });
    });


    /* for advertisement in block 1 */
    var pre_b = $("#ad_b div.display").html();
    $("#ad_b").addClass("ads_block");

    //$("#ad_a textarea").parents("div.cleditorMain").hide();

    $("#ad_b").click(function(){
        setEditor("t_ads_b", 320, 248);
        $(this).next().show();
        $("#t_ads_b").html(pre_b);

        $(this).removeClass("ads_block");
        $(this).find("div.display").hide();

        $(this).next("a").click(function(){
            $.post(
                base_url + "administrator/save_config.php?param=ads_b",
                $("#form_ads_b").serialize(),
                function(data){
                    remove_cleditor("t_ads_b");
                    $("#ad_b").next("a").hide();
                    $("#ad_b div.display").html(data).show();
                    $("#ad_b").addClass("ads_block");
                }
            );
        });
    });

    /* for advertisement in block 2 */
    var pre_b = $("#ad_c div.display").html();
    $("#ad_c").addClass("ads_block");

    //$("#ad_a textarea").parents("div.cleditorMain").hide();

    $("#ad_c").click(function(){
        setEditor("t_ads_c", 320, 248);
        $(this).next().show();
        $("#t_ads_c").html(pre_b);

        $(this).removeClass("ads_block");
        $(this).find("div.display").hide();

        $(this).next("a").click(function(){
            $.post(
                base_url + "administrator/save_config.php?param=ads_c",
                $("#form_ads_c").serialize(),
                function(data){
                    remove_cleditor("t_ads_c");
                    $("#ad_c").next("a").hide();
                    $("#ad_c div.display").html(data).show();
                    $("#ad_c").addClass("ads_block");
                }
            );
        });
    });

    /* For block 3: movie */
    var pre_b = $("#b_movie div.display").html();
    $("#b_movie").addClass("ads_block");

    //$("#ad_a textarea").parents("div.cleditorMain").hide();

    $("#b_movie").click(function(){
        setEditor("t_b_movie", 320, 248);
        $(this).next().show();
        $("#t_b_movie").html(pre_b);

        $(this).removeClass("ads_block");
        $(this).find("div.display").hide();

        $(this).next("a").click(function(){
            $.post(
                base_url + "administrator/save_config.php?param=flash_movie",
                $("#form_b_movie").serialize(),
                function(data){
                    remove_cleditor("t_b_movie");
                    $("#b_movie").next("a").hide();
                    $("#b_movie div.display").html(data).show();
                    $("#b_movie").addClass("ads_block");
                }
            );
        });
    });

});

function setEditor(txtarea_id, w, h, c){
    //remove_cleditor("#t_ads_a");
    //remove_cleditor("#t_ads_b");
    //remove_cleditor("#t_ads_a");

    $("textarea#" + txtarea_id).cleditor({
        width: w,
        height: h,
        controls: c
    });
}

function remove_cleditor(txtarea_id){
    var old_val = $("textarea#" + txtarea_id).html();
    var parent = $("textarea#" + txtarea_id).parents("div.for_textarea");
    parent.find("div.cleditorMain").remove();
    parent.html('<textarea name="value" id="' + txtarea_id + '" style="display: none;">' + old_val + '</textarea>');
}