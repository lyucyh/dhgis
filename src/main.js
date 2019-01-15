var infowindow,map,marker;
var markers = [];


function initialize() {
	

	
	var wmsMapType = new google.maps.ImageMapType({
		maxZoom: 18,
		minZoom: 7,
		name: "custom1",
		// 每個磚格設定為 256 X 256
		tileSize: new google.maps.Size(256, 256),
		isPng: true,
		// 使用國土測繪中心的 wmts 來進行範例
		getTileUrl: function(coord, zoom) {
			return ['http://gis.sinica.edu.tw/ccts/file-exists.php?img=ad0140-png-{TileMatrix}-{TileCol}-{TileRow}'].join('');
		}
	});

	
	var center = new google.maps.LatLng(27.337692, 117.483398);

	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 7,
		center:center,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
			mapTypeIds: ['custom1', 'roadmap'],
		},
		streetViewControlOptions: {
			position: google.maps.ControlPosition.LEFT_TOP
		},
		zoomControlOptions: {
			position: google.maps.ControlPosition.LEFT_TOP
		},
		fullscreenControl: false
	});



	map.mapTypes.set('custom1', wmsMapType);
    map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    map.overlayMapTypes.push(wmsMapType);


	var options = {
			gridSize:40, 
			imagePath: 'images/m'
	};

	var markerCluster = new MarkerClusterer(map, markers, options);


	
}