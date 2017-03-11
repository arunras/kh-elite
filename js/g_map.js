/*function initialize_map_location(xx,yy) {
		if (GBrowserIsCompatible()) {
			map = new GMap2(document.getElementById("map_canvas"));
			x = xx;
			y = yy;

            var center = new GLatLng(x, y);

            var map = new GMap2(document.getElementById("map_canvas"));
            map.setCenter(center, 13);

			var letteredIcon = new GIcon(G_DEFAULT_ICON);
			map.setMapType(G_MAPMAKER_NORMAL_MAP);
			if(true){
				var marker = new GMarker(center, {icon:letteredIcon,draggable: true});
				GEvent.addListener(marker, "dragstart", function() {
					map.closeInfoWindow();
				});

				GEvent.addListener(marker, "dragend", function() {
					var str = marker.getLatLng().toString();
					str = str.split(',')
					str[0]=str[0].substring(1,str[0].length);
					str[1]=str[1].substring(0,str[1].length-1);

					x = str[0]+0;
					y = str[1]+0;
				});
			}
			else{
				var marker = new GMarker(center,{draggable:false});
			}
			map.addOverlay(marker);
			GEvent.addListener(marker, "click", function() {
  				marker.openInfoWindowHtml("abc");
			});
		}
	}*/
    var new_marker;
    var scr_theater;

    function initialize_map_location(xx,yy, editable, src){
        if(xx == "" || yy == ""){
            getLatLngByAddress(editable, src);
            return;
        }
        
        var theater_location = new google.maps.LatLng(xx,yy);
        scr_theater = src;
        var myOptions = {
            zoom: 16,
            center: theater_location,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker;
        if(editable == "true"){
            marker = new google.maps.Marker({draggable:true, position: theater_location, map: map});
            new_marker = marker.getPosition();
            google.maps.event.addListener(marker, 'dragend', function() {
                new_marker = marker.getPosition();
            });
    	}
    	else{
    		marker = new google.maps.Marker({draggable:false, position: theater_location, map: map});
    	}
    }

    function save_map(){
        $("#save_map_result").fadeIn(10).html("Saving.....");
        $.ajax({
            url: base_url + "application/rakugo-schedule/save_theater_location.php?lt=" + new_marker.lat() + "&ln=" + new_marker.lng() + "&tid=" + scr_theater,
            success: function(data){
                $("#save_map_result").html(data).fadeOut(1500);
            }
        });
        $("#save_map_result").fadeIn(10).html("");
    }
    
    function getLatLngByAddress(editable, src){
        var address = document.getElementById("address").value;
        var geocoder = new google.maps.Geocoder();
        var xx, yy;
        geocoder.geocode( {'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                //marker = (results[0].geometry.location);
                xx = results[0].geometry.location.lat();
                yy = results[0].geometry.location.lng();
                initialize_map_location(xx, yy, editable, src);
            } else {
                xx = 35.68949252516748;
                yy = 139.69170222955336;
                initialize_map_location(xx, yy, editable, src);
                //alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    /*function loadScript() {
      var script = document.createElement("script");
      script.type = "text/javascript";
      script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
      document.body.appendChild(script);
    }

    window.onload = loadScript;
    */