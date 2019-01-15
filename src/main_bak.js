var infowindow,map,marker;
var markers = [];


function initialize() {
	var center = new google.maps.LatLng(27.337692, 117.483398);

	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 5,
		center:center,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
            position: google.maps.ControlPosition.TOP_CENTER,
            mapTypeIds: ['OSM', google.maps.MapTypeId.ROADMAP],
        },
		streetViewControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        },
        zoomControlOptions: {
            position: google.maps.ControlPosition.LEFT_TOP
        },
        fullscreenControl: false,
        mapTypeControl: false
	});

	
	 // Add a style-selector control to the map.
    //var styleControl = document.getElementById('style-selector-control');
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(styleControl);

    // Set the map's style to the initial value of the selector.
    //var styleSelector = document.getElementById('style-selector');
    //map.setOptions({styles: styles[styleSelector.value]});

    // Apply new JSON when the user selects a different style.
    //styleSelector.addEventListener('change', function() {
      //map.setOptions({styles: styles[styleSelector.value]});
    //});
    
    /*
	for (var i = 0; i < data.length; i++) {
		var html,
		datav = data[i],
		latLng = new google.maps.LatLng(datav.xy[0],datav.xy[1]),
		finalLatLng = latLng,
		newLat = datav.xy[0] + (Math.random() -.5) / 1500,// * (Math.random() * (max - min) + min);
		newLng = datav.xy[1] + (Math.random() -.5) / 1500;// * (Math.random() * (max - min) + min);

		//finalLatLng = new google.maps.LatLng(newLat,newLng);
		finalLatLng = new google.maps.LatLng(datav.xy[0],datav.xy[1]);
		marker = new google.maps.Marker({
			map: map,
			position: finalLatLng
		});


		addClicker(marker, datav);
		markers.push(marker);
	}
*/
/*
	function addClicker(marker, datav) {
		
		
		var _k1 = datav.k1.split("|"),
		_k2 = datav.k2.split("|");
		

		if(datav.k1.split("|").length>1){

			google.maps.event.addListener(marker, 'click', function() {

				if (infowindow) {
					infowindow.close();
				}
				infowindow = new InfoBubble({
					disableAnimation: true
				});
				for (var j = 0; j < _k1.length; j++){
					var k2str = '藥名:'+_k2[j]+'<p>座標:'+datav.xy[0]+','+datav.xy[1];
					
					infowindow.addTab(_k1[j], k2str);
				}
				infowindow.open(map, marker);
			});	


		}else{
			google.maps.event.addListener(marker, 'click', function() {
				
				var k2str2 = '地名:'+datav.k1+'<p>藥名:'+datav.k2+'<p>座標:'+datav.xy[0]+','+datav.xy[1];
				if (infowindow) {
					infowindow.close();
				}
				infowindow = new InfoBubble({
					disableAnimation: true,
					content:k2str2
				});
				infowindow.open(map, marker);
			});	
		}
	}
*/
	
	
	
	//Define OSM as base layer in addition to the default Google layers
	var osmMapType = new google.maps.ImageMapType({
	                getTileUrl: function (coord, zoom) {
	                    return "http://tile.openstreetmap.org/" +
		            zoom + "/" + coord.x + "/" + coord.y + ".png";
	                },
	                tileSize: new google.maps.Size(256, 256),
	                isPng: true,
	                alt: "OpenStreetMap",
	                name: "OSM",
	                maxZoom: 19
	            });

	//Define custom WMS tiled layer
	var SLPLayer = new google.maps.ImageMapType({
	                getTileUrl: function (coord, zoom) {
	                    var proj = map.getProjection();
	                    var zfactor = Math.pow(2, zoom);
	                    // get Long Lat coordinates
	                    var top = proj.fromPointToLatLng(new google.maps.Point(coord.x * 256 / zfactor, coord.y * 256 / zfactor));
	                    var bot = proj.fromPointToLatLng(new google.maps.Point((coord.x + 1) * 256 / zfactor, (coord.y + 1) * 256 / zfactor));

	                    //corrections for the slight shift of the SLP (mapserver)
	                    var deltaX = 0.0013;
	                    var deltaY = 0.00058;

	                    //create the Bounding box string
	                    var bbox =     (top.lng() + deltaX) + "," +
		                               (bot.lat() + deltaY) + "," +
		                               (bot.lng() + deltaX) + "," +
		                               (top.lat() + deltaY);

	                    //base WMS URL
	                    var url = "http://mapserver-slp.mendelu.cz/cgi-bin/mapserv?map=/var/local/slp/krtinyWMS.map&";
	                    url += "&REQUEST=GetMap"; //WMS operation
	                    url += "&SERVICE=WMS";    //WMS service
	                    url += "&VERSION=1.1.1";  //WMS version  
	                    url += "&LAYERS=" + "typologie,hm2003"; //WMS layers
	                    url += "&FORMAT=image/png" ; //WMS format
	                    url += "&BGCOLOR=0xFFFFFF";  
	                    url += "&TRANSPARENT=TRUE";
	                    url += "&SRS=EPSG:4326";     //set WGS84 
	                    url += "&BBOX=" + bbox;      // set bounding box
	                    url += "&WIDTH=256";         //tile size in google
	                    url += "&HEIGHT=256";
	                    return url;                 // return URL for the tile

	                },
	                tileSize: new google.maps.Size(256, 256),
	                isPng: true
	            });
	
	
	
	var options = {
			gridSize:40, 
			imagePath: 'images/m'
	};

	var markerCluster = new MarkerClusterer(map, markers, options);


	/* =================================Excel Script====================== */  
	var  excel_data,
	//searchFiled,
	hot3;
	excel_data = document.getElementById('excel_data');
	//searchFiled = document.getElementById('search_field'),
	hot3 = new Handsontable(excel_data, {
		data : data,
		search: {
			searchResultClass: 'customClass'
		},
		colWidths: [55, 80, 80, 80, 80, 80, 80], //can also be a number or a function
		rowHeaders : true,
		colHeaders : true,
		stretchH : 'all',
		minSpareRows : 1,
		startRows: 7,
		startCols: 4,
		afterOnCellMouseDown: excelclick,
		columnSorting: true,
		colHeaders: ['Score','地名', '藥名', '座標'],
		contextMenu : true
		//comments: false,
		//cell: [
			//{row: 0, col: 0, comment: {value: '這是藥1的comment'}},
			//{row: 1, col: 0, comment: {value: '這是藥2的comment'}},
			//{row: 2, col: 0, comment: {value: '這是藥3的comment'}}
			//]
	});
    
	/*
	var searchFiled = document.getElementById('search_field');
	Handsontable.dom.addEvent(searchFiled,'keyup', function (event) {
		var queryResult = hot3.search.query(this.value);
		console.log(queryResult);
		hot3.render();
	});
	*/

	function excelclick(e,d){

		var getdatas = hot3.getData(),
		    xy =getdatas[d.row][3].split(','),
		    _xy = new google.maps.LatLng(parseFloat(xy[0]),parseFloat(xy[1])),
		  _k1 = getdatas[d.row][1].split("|"),
		  _k2 = getdatas[d.row][2].split("|"),
		  k2str;
			
		map.panTo(_xy); 
		map.setZoom(15);
	    
	    if(_k1.length>1){

				if (infowindow) {
					infowindow.close();
				}
				infowindow = new InfoBubble({position:_xy});

		    	for (var j = 0; j < _k1.length; j++){
						k2str = '藥名:'+_k2[j]+'<p>座標:'+xy[0]+','+xy[1];
						infowindow.addTab(_k1[j], k2str);
					}
		    	infowindow.open(map,marker);

		}else{
				
			k2str = '地名:'+getdatas[d.row][1]+'<p>藥名:'+getdatas[d.row][2]+'<p>座標:'+xy[0]+','+xy[1];

				if (infowindow) {
					infowindow.close();
				}
				infowindow = new InfoBubble({
					position:_xy,
					content:k2str
					});
				infowindow.open(map,marker);		
		}
	    

	}
}