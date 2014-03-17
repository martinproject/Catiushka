var $j = jQuery.noConflict();

$j(window).load(function(){

	function map_init() {
			
			var center = new google.maps.LatLng();
			var mapLatitude =  parseFloat($j("#mapLatitude").val());
			var mapLongitude =  parseFloat($j("#mapLongitude").val());
			var mapZoom = parseInt($j("#mapZoom").val());

			if((mapLatitude != '') && (mapLongitude != '')) {
				center = new google.maps.LatLng(mapLatitude, mapLongitude);
			}

			var myOptions = {
				'zoom': mapZoom,
				'center': center,		
				'mapTypeId': google.maps.MapTypeId.ROADMAP	
			};

			var mapDiv = document.getElementById('googleMap');
			var map = new google.maps.Map(mapDiv, myOptions);
			var marker = new google.maps.Marker({
				position: center,
				map: map,
				title: "Ad Located"
			});
		
			function placeMarker(location) {
				marker.setPosition(location);
				map.setCenter(location);
				if((location.lat() != '') && (location.lng() != '')) {
					$j("#mapLatitude").val(location.lat());
					$j("#mapLongitude").val(location.lng());
				}
					

			}		
		}
		
		map_init();
		
		$j('.has-map').click(function() { map_init(); }	);
		
});