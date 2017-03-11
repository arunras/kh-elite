<?php
    ob_start();
    if(!isset($_SESSION))@session_start();

    require_once(dirname(dirname(__FILE__)) . "/module/module.php");

    $user_type = getUserType();

    define("HTTP_DOMAIN",(!empty($_SERVER['HTTPS'])) ? "https://" . $_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', "") : "http://" . $_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', "") . ROOT . "/");

    if(!isset($_SESSION['language_selected'])){
        $_SESSION['language_selected'] = "ja";
    }
    else{
    }

    include(dirname(dirname(__FILE__)) . "/application/tbl/tbl.class.php");

    $cnfg = new tbl("tbl_config", "id", 1);
    $rLanguage = CheckLanguageChange();

?>
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $rLanguage->text("Rakugo"); ?></title>

        <style>
            div.top_sns{
                display: block;
                position: relative;
                z-index: 100;
            }

            div.top_sns div.cleditorMain{
                position: absolute;
                right: 0;
                z-index: 100;
            }
        </style>

        <?php
        echo '
        <!-- Framework CSS -->
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/blueprint/screen.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/button_rakugo.css" type="text/css" media="screen, projection">
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/blueprint/print.css" type="text/css" media="print">
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/menu.css" />


        <!--[if lt IE 8]><link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

        <!-- Import fancy-type plugin for the sample page. -->
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">

        <!-- schedule application -->
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'application/rakugo-schedule/css/rakugo-schedule.css" type="text/css" media="screen, projection">
        <!-- schedule application -->

        <!-- master talble application -->
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'application/master_table/css/master_table.css" type="text/css"/>
        <!-- master talble application -->

         <!-- Loading jQuery -->
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/ui/jquery-ui-1.8.16.custom.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/ui/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/ui/i18n/jquery.ui.datepicker-' . $_SESSION['language_selected'] .'.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/ui/jquery.ui.autocomplete.js"></script>
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'css/jquery.ui-rakugo-theme/jquery-ui-1.8.16.custom.css" />
         
        <!-- data table -->
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_datatable/js/dataTable-' . $_SESSION['language_selected'] .'.js"></script>
        <!-- data table -->

        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/rakugo-main.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/rakugo-r.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/rakugo-y.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/confirm.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/rakugo-o.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/md5.js"></script>

       

        <!-- time entry -->
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_timeentry/jquery.timeentry.min.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_timeentry/jquery.timeentry-' . $_SESSION['language_selected'] .'.js"></script>
        <!-- time entry -->

        <!-- schedule application -->
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_fullcalendar/fullcalendar-' . $_SESSION['language_selected'] .'.js"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_fullcalendar/fullcalendar.js"></script>
        <!-- schedule application -->

        <!-- google map -->
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&language=' . $_SESSION['language_selected'] .'"></script>
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'js/g_map.js"></script>
        <!-- google map -->

        <!-- jqDialog -->
        <link rel="stylesheet" href="' . HTTP_DOMAIN . 'application/_jqdialog/jqdialog.css" />
        <script type="text/javascript" src="' . HTTP_DOMAIN . 'application/_jqdialog/jqdialog.min.js"></script>
        <!-- jqDialog -->
        ';

         if($user_type == ADMINISTRATOR){
            echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'administrator/admin.js"></script>';
            echo '<link rel="stylesheet" type="text/css" href="' . HTTP_DOMAIN . 'administrator/admin.css" />';
            echo '<link rel="stylesheet" type="text/css" href="'.HTTP_DOMAIN.'application/_editor/jquery.cleditor.css" />';
            echo '<script type="text/javascript" src="'.HTTP_DOMAIN.'application/_editor/jquery.cleditor.min.js"></script>';
        }
        echo '
        <script type="text/JavaScript" src="'.HTTP_DOMAIN.'application/_fancybox/jquery.easing-1.3.pack.js"></script>
        <script type="text/JavaScript" src="'.HTTP_DOMAIN.'application/_fancybox/jquery.fancybox-1.3.4.js"></script>
        <link rel="stylesheet" type="text/css" href="'.HTTP_DOMAIN.'application/_fancybox/jquery.fancybox-1.3.4.css" />
        ';

        ?>

    </head>

    <body>
        <?php
            include($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/css/preload_image.php");
            echo '<input type="hidden" id="rLanguage" value="' . $_SESSION['language_selected'] . '" />';
            echo '<input type="hidden" id="base_url" value="' . HTTP_DOMAIN . '" />';

            $page = "index";
            if(isset($_GET['page'])){
                $page = $_GET['page'];
                if(!array_key_exists($page, $path)){
                    $page = "index";
                }
            }
            $include_path = $_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/" . $path[$page];

        ?>
        <div class="container">
        <div class="preload_image"></div>
            <div class="span-full" style="display: block; width: 100%; border-bottom: 1px solid;">
                <table style="width: 100%;">
                <tr>
                <td>
                <!--For Logo-->
                <?php
      		        require_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/include/logo.php");
      		    ?>
                <!--<div class="span-14" style="height:38px; width:570px;"></div>-->
                </td>
                <td style="vertical-align: bottom; text-align: right;" align=right;>

                <!-- for social network connection -->
                <?php
                    if($user_type == ADMINISTRATOR){
                        echo '
                            <form style="margin: 0; padding: 0;" id="sns_top">
                            <a class="rakugo" style="float: right; display: none; position: relative; top: -20px;" onclick="return false;" href="#">' . $rLanguage->text("Done") . '</a>
                            <div class="top_sns" style="width: 100%; height: 30px; margin-bottom: 5px;" id="sns_top">
                                <div class="for_textarea"><textarea name="value" id="sns_top" style="display: none;">' . $cnfg->getValue("sns_top") . '</textarea></div>
                                <div class="display">
                                    ' . $cnfg->getValue("sns_top") . '
                                </div>
                            </div>
                            </form>
                        ';
                    }
                    else{
                        echo '
                            <div style="width: 100%; height: 30px; margin-bottom: 5px;">
                                ' . $cnfg->getValue("sns_top") . '
                            </div>
                        ';
                    }
                ?>
                <!-- for social network connection -->


           		<!--Login Form-->
                <?php
          		    require_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/include/loginform.php");
          		?>
                </td>
                </tr>
                </table>
            </div>
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/include/menu.php"); ?>

            <div id="rakugo-content" class="span-full">
                    <?php
                        include($include_path);
                    ?>
            </div>
            <hr>
            <?php
    	        require_once($_SERVER['DOCUMENT_ROOT'] . "/" . ROOT . "/include/footer.php");
    	    ?>
        </div>

        <!-- preload image -->
        <!--<div class="btn_preload"></div>-->
    </body>