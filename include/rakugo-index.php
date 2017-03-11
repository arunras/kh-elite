<?php
	echo '<script type="text/javascript" src="' . HTTP_DOMAIN . 'js/home.js"></script>';
	//$event_rs = getResultSet("SELECT event_id, event_title,event_post FROM tbl_event WHERE event_post >=  '" .date("Y-m-d") . "' LIMIT 10");
	$event_rs = getResultSet("SELECT event_id, event_title, event_post, event_open FROM tbl_event WHERE event_post >=  NOW() ORDER BY event_post, event_open LIMIT 5");
    $user_type = getUserType();
	$perid ="";

    /* Advertisement block : Top */
    if($user_type == ADMINISTRATOR){
        echo '
            <form style="margin: 0; padding: 0; height: auto;" id="form_ads_a">
            <a class="rakugo" style="float: right; display: none;" onclick="return false;" href="#">' . $rLanguage->text("Done") . '</a>
            <div style="height: auto; width: 1080px; margin: 0 0 10px;" class="span-full" id="ad_a">
                <div class="for_textarea"><textarea name="value" id="t_ads_a" style="display: none;">' . $cnfg->getValue("top_ad") . '</textarea></div>
                <div class="display">
                    ' . $cnfg->getValue("top_ad") . '
                </div>
            </div>
            </form>
        ';
    }
    else{
        echo '
            <div style="height: auto; width: 1080px; margin: 0 0 10px;" class="span-full" id="ad_a">
                ' . $cnfg->getValue("top_ad") . '
            </div>
        ';
    }
?>

    		<div class="span-9">
				<div  style="margin: -17px 0 0 0;">
          	   	<?php
					require_once($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/rakugo-schedule/class/schedule.class.php");
					search_filter_panel_top();
				?>
				</div>
<!--==RUN========================================-->
                <div class="span-9" style="padding-left: 5px;">
                	<div class="btn_twitter_search"></div>
                		<script src='http://widgets.twimg.com/j/2/widget.js'></script>
						<script>
                        new TWTR.Widget({
                          version: 2,
                          type: 'search',
						  search: '落語',
                          interval: 3000,
						  title: '',
	  					  subject: '',
                          width: 330,
                          height: 300,
                          theme: {
                            shell: {
                              background: '#FFFFFF',//#DF6060
                              color: '#ffffff'
                            },
                            tweets: {
                              background: '#FFFFF3',
                              color: '#000000',
                              links: '#069'
                            }
                          },
                          features: {
                            scrollbar: true,
                            loop: true,
                            live: true,
                            behavior: 'default',
							avatars: true,
                          }
                        }).render().start();
                        </script>
                        <style type="text/css">
						
							.twtr-hd{ display: none;}
							.twtr-ft{ height: 1px;}
							.twtr-timeline{
								margin: 20px 0px 0px 0px;
								border: 1px #CCC solid;		
							}
							.twtr-avatar{
								width: 15px;
								margin-right: 0px;
								background-image: url(images/avatar_bg.png);
								background-repeat: no-repeat;
							}
							.twtr-avatar .twtr-img{
								display: none;
							}
							.twtr-tweet-text{
								display: table-cell; 
								margin-left: 0px;
							}
							.twtr-tweet-text em{
								display: none;
							}
						</style>
               </div>
<!--==RUN============ohakambojia============================-->
				 <?php
                    /* Advertisement block : Column 1 */
                    if($user_type == ADMINISTRATOR){
                      echo '
                          <form style="margin: 0; padding: 0; height: auto;" id="form_ads_b">
                          <div style="width: 100%; height:auto;" class="span-9" id="ad_b">
                              <div class="for_textarea"><textarea name="value" id="t_ads_b" style="display: none;">' . $cnfg->getValue("ad_b") . '</textarea></div>
                              <div class="display">
                                  ' . $cnfg->getValue("ad_b") . '
                              </div>
                          </div>
                          <a class="rakugo" style="float: right; display: none;" onclick="return false;" href="#">' . $rLanguage->text("Done") . '</a>
                          </form>
                      ';
                  }
                  else{
                      echo '
                          <div style="width: 100%; height:auto; overflow:auto;" id="ad_b" class="span-9">
                              ' . $cnfg->getValue("ad_b") . '
                          </div>
                      ';
                  }
                ?>
            </div>
            <div class="span-9 prepend-min">
				 <!--<h3 class="column-title">Most recent rakugo society </h3>-->
                <div class="btn_news_title span-9"></div>
                <ul class="no-list-style fill span-9">
                <?php
					while($event_info = mysql_fetch_array($event_rs)){

					echo '<li class="dashed-line">
							 <a class="rakugo" href="?page=schedule&action=detail&id='.$event_info[0].'">'.to_date_display($event_info[2]).'
						 	 <span > '.$event_info[1].'</span></a>
						 </li>';

					}
				?>
				
                </ul>
                <hr/>
                <!--<h3 class="column-title">Top Show</h3>-->
                <div class="btn_pickup_title"></div>
                <?php

					$pickup_rs = getResultSet("SELECT pickup_id, pickup_title,pickup_comment,source_id, source_type FROM tbl_pickup LIMIT 3");
					while($pickup_info = mysql_fetch_array($pickup_rs)) {
				?>

                    <table cellpadding=5><tr>
                        <td>
							<?php
							require_once($_SERVER['DOCUMENT_ROOT'] . ROOT . "/application/performer/class/performer.class.php");
							$event_performer = getResultSet("SELECT event_id, performer_id FROM tbl_event_performer WHERE event_id =".$pickup_info[3]." ORDER BY RAND() LIMIT 1");
							while($event_performer_info = mysql_fetch_array($event_performer)) {
								$perid= $event_performer_info[1];
							}
							if ($pickup_info[4]=='performer') {
								$perid = $pickup_info[3];
							}
							
							$per = new performer($perid);
							echo '<div class="btn_pickup_photo" style=""><a class="fancybox" href="'.$per->getPerPicture().'"><img src="'.$per->getPerPicture().'" style="border:none; width:84px; height:106px; margin-left:3px; margin-top:7px;"/></a></div>';
								?>
                        </td>
                        <td>
                            <?php 
								if($pickup_info[4]=='event') {
								
									echo '<a class="rakugo pickup-title" href="?page=schedule&action=detail&id='.$pickup_info[3].'">'.$pickup_info[1].'</a>' ;
								
									}
								else {
							    	echo '<a class="rakugo pickup-title" href="?page=perprofile&perid='.$pickup_info[3].'">'.$pickup_info[1].'</a>';		
									}
							?>
                            
                            <div class="btn_pickup_line"></div>

                            <p style="text-indent: 0; text-align: justify">
                                <?php echo $pickup_info[2];?>
                            </p>
                        </td>
                    </tr></table>
                    <div class="pickup-block-line"></div>
                   <?php } ?>

                <?php
                    /* Advertisement block : Column 2 */
                    if($user_type == ADMINISTRATOR){
                      echo '
                          <form style="margin: 0; padding: 0; height: auto;" id="form_ads_c">
                          <div style="width:100%; height: auto; margin-top: 10px; height: auto; margin-bottom: 10px;" id="ad_c" class="span-9">
                              <div class="for_textarea"><textarea name="value" id="t_ads_c" style="display: none;">' . $cnfg->getValue("ad_c") . '</textarea></div>
                              <div class="display" style="height: auto; overflow-y: auto; overflow-x: hidden;" >
                                  ' . $cnfg->getValue("ad_c") . '
                              </div>
                          </div>
                          <a class="rakugo" style="float: right; display: none;" onclick="return false;" href="#">' . $rLanguage->text("Done") . '</a>
                          </form>
                      ';
                  }
                  else{
                      echo '
                          <div style="width:100%; height: auto; overflow-x: hidden; margin-top: 10px; margin-bottom: 10px;" id="ad_c" class="span-9">
                              ' . $cnfg->getValue("ad_c") . '
                          </div>
                      ';
                  }
                ?>
            </div>

            <div class="span-9 last prepend-min">
                <?php
                    /* Advertisement block : Column 3 */
                    if($user_type == ADMINISTRATOR){
                      echo '
                          <form style="margin: 0; padding: 0; height: auto;" id="form_b_movie">
                          <div style="width: 100%; height:auto;" id="b_movie" class="span-9">
                              <div class="for_textarea"><textarea name="value" id="t_b_movie" style="display: none;">' . $cnfg->getValue("flash_movie") . '</textarea></div>
                              <div class="display">
                                  ' . $cnfg->getValue("flash_movie") . '
                              </div>
                          </div>
                          <a class="rakugo" style="float: right; display: none;" onclick="return false;" href="#">' . $rLanguage->text("Done") . '</a>
                          </form>
                      ';
                  }
                  else{
                      echo '
                          <div style="width: 100%; height:auto;" id="b_movie" class="span-9">
                              ' . $cnfg->getValue("flash_movie") . '
                          </div>
                      ';
                  }
                  if(trim(strip_tags($cnfg->getValue("flash_movie"))) != ""){
                    echo '<div class="pickup-block-line"></div><!-- dot dot line -->';
                  }
                ?>
                <hr class="space"/>
                <div class="column" style="width: 160px; padding-right: 5px; float:	left;">
                    <p align="center">
                        <a class="btn_rakugo_title_left" style="float: left; margin-bottom:10px;"></a>
                    </p>
                    <p align="center">
                      <?php
							$theater_rs = getResultSet("SELECT theater_id, theater_name,theater_image, theater_url FROM tbl_theater WHERE theater_image <>'' AND theater_url <>'' AND show_top = 1 ORDER BY RAND() LIMIT 6");
							while($theater_info = mysql_fetch_array($theater_rs)) {
							
								//if($theater_info[2]!="") {
									echo '<div class="group_picture" style="float:left; padding-left:0;"><a href="'.$theater_info[3].'"><img src="'.HTTP_DOMAIN.'application/'.$theater_info[2].'" height="55" width="156"/></a></div>';
									// }
								/* else {
							echo'<div class="group_filter" style="float: left; margin-left:0;"><a href="'.$theater_info[3].'"><label style="width: 131px; height:53px;">'.$theater_info[1].'</label><span></span></a></div>';
								} */
							}
						?>
                    </p>
                </div>
                <div class="last"  style="width: 156px; float: right;">
                    <p align="center">
                        <a class="btn_rakugo_title_right" style="float: right; margin-bottom:10px;"></a>
                    </p>
                    <p align="center">

                        <?php
							$group_rs = getResultSet("SELECT group_id, group_name,group_image, group_url FROM tbl_group WHERE group_image <>'' AND group_url <>'' ORDER BY RAND() LIMIT 6");
							while($group_info = mysql_fetch_array($group_rs)) {

								//if($group_info[2]!="") {
									echo '<div class="group_picture" style="float:right; margin-right:0;"><a href="'.$group_info[3].'"><img src="'.HTTP_DOMAIN.'application/'.$group_info[2].'" height="55" width="155"/></a></div>';
									// }
							/*	else {
							echo'<div class="group_filter" style="float: right;"><a href="'.$group_info[3].'"><label style="width: 130px; height:53px;">'.$group_info[1].'</label><span></span></a></div>';
								} */
							}
						?>
                   
                    </p>
                </div>
            </div>
           
                  <!-- <div class="button pink" style="float:left;"><label style=" font-size:14px;width:110px;">落語会を検索</label><span></span></div>
                        <div class="last"><div class="btn_rakugo_title" style="float:right;"></div></div>
                </div>
            </div>-->