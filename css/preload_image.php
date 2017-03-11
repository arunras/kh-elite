<style type="text/css">
    @media screen {
	div#preloader {
		position: absolute;
		left: -9999px;
		top:  -9999px;
		}
	div#preloader img {
		display: block;
		}
	}

    @media print {
	div#preloader,
	div#preloader img {
		visibility: hidden;
		display: none;
		}
	}
</style>

<?php
    echo '
        <div id="preloader">
        	<img src="' . HTTP_DOMAIN . 'images/button_rakugo/button_headserch_on.jpg" width="1" height="1" />
        	<img src="' . HTTP_DOMAIN . 'images/button_rakugo/button_serch_on.jpg" width="1" height="1" />
        	<img src="' . HTTP_DOMAIN . 'images/button_rakugo/button_send_on.jpg" width="1" height="1" />
        	<img src="' . HTTP_DOMAIN . 'images/button_rakugo/button_logout_on.jpg" width="1" height="1" />
        </div>
    ';
?>