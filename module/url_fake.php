<?php

    /* return url fake real value */
    function url_fake_value($val){
        $l = strlen($val);
        $head = substr($val, 0, 1);

        $val_index = 33 + $head;
        $val_end   = $l - 32;
        return substr($val, $val_index, $val_end - $val_index);
    }
	
	function isValidURL($url) {
			return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	 }