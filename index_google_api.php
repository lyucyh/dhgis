<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8" />

<link rel="stylesheet" href="css/jquery-ui.css">
<script src="src/external/jquery/jquery.js"></script>
<script src="src/external/jquery/jquery-ui.js"></script>

<script src="src/timegliderJS/modernizr.custom.js" type="text/javascript" charset="utf-8"></script>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="css/jquery-ui.theme.css" type="text/css" media="screen" charset="utf-8">
<link rel="stylesheet" href="src/timeglider/Timeglider.css" type="text/css" media="screen" charset="utf-8">
<style type='text/css'>
#p1 {
	margin: 0px;
	margin-bottom: 0;
	height: 260px;
}

.timeglider-legend {
	width: 180px;
}

</style>
<!-- excel sheet  -->
<style data-jsfiddle="excel_data">
html, body, #map {
	height: 60%;
	width: 100%;
	margin: 0;
	padding: 0;
}
</style>
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="excellib/dist/handsontable.css">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="excellib/dist/pikaday/pikaday.css">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="excellib/demo/css/samples.css?20140331">

<script type="text/javascript" src="./src/markerclusterer.js"></script>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9rAAfLofmxGCXn6nqsRQJueqvo6UFSEI&callback=initialize&libraries=places"></script>
<script data-jsfiddle="common" src="excellib/dist/handsontable.js"></script>
<script src="excellib/demo/js/samples.js"></script>
<script src="excellib/demo/js/highlight/highlight.pack.js"></script>
<script src="src/infobubble.js"></script>
<script data-jsfiddle="excel_data" src="src/main.js"></script>
<script data-jsfiddle="excel_data" src="src/styledmap.js"></script>
<script src="data.json"></script>
<script src="meds.json"></script>
<script src="books.json"></script>

<!-- time line -->
<script src="src/timegliderJS/json2.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/underscore-min.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/backbone-min.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/jquery.tmpl.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/ba-tinyPubSub.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/globalize.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timegliderJS/ba-debug.min.js" type="text/javascript" charset="utf-8"></script>

<script src="src/timeglider/TG_Date.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timeglider/TG_Org.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timeglider/TG_Timeline.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timeglider/TG_TimelineView.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timeglider/TG_Mediator.js" type="text/javascript" charset="utf-8"></script>
<script src="src/timeglider/timeglider.timeline.widget.js" type="text/javascript"></script>
<script>

	$(function() {
		$("#tabs").tabs();
	});
</script>
<script type='text/javascript'>

		var ico = window.ico;

		var tg1 = window.tg1 = "";

		$(function() {
			
			var tg_instance = {};

			tg1 = $("#p1").timeline({

				"min_zoom":38, 
				"max_zoom":55, 
				"timezone":"+8:00",
				"icon_folder":"src/icons/",
				"data_source": "src/json/js_history.json",
				"show_footer":true,
				"display_zoom_level":true,
				"mousewheel":"zoom", // zoom | pan | none
				"constrain_to_data":false,
				"image_lane_height":100,
				"legend":{type:"default"}, // default | checkboxes
				"loaded":function () { 
					// loaded callback function
				 }

		}).resizable({
			stop:function(){ 
				// $(this).data("timeline").resize();
			}
		});
		
		
	
	tg_instance = tg1.data("timeline");

	$("#loadData").click(function() {
		
		var src = $("#loadDataSrc").val();
		
		var cb_fn = function(args, timeline) {
			// called after parsing data, after load
			debug.log("args", args, "timeline", timeline[0].id);
		};
		
		var cb_args = {}; // {display:true};
		
		tg_instance.getMediator().emptyData();
		tg_instance.loadTimeline(src, function(){debug.log("cb!");}, true);
		
		$("#reloadDataDiv").hide();
	});
	
	$("#reloadTimeline").click(function() {
		tg_instance.reloadTimeline("js_history", "src/json/js_history.json");
	});
		

	$("#refresh").click(function() {
		debug.log("timeline refreshed!");
		tg_instance.refresh();
	});

	
	$("#updateEvent").click(function() {
		
		var updatedEventModel = {
			id:"deathofflash",
			title: "Flash struggles to survive in the age of HTML5."
		}
		
		tg_instance.updateEvent(updatedEventModel);
	});	

	
		}); // end document-ready
	
	</script>


<body>

	<!-- ui-dialog -->
	<div id="books"></div><div id="words"></div><div id="bookinfo"></div>
	<!-- <div id="style-selector-control" class="map-control">
		<select id="style-selector" class="selector-control">
			<option value="default">預設風格</option>
			<option value="retro" selected="selected">古地圖風格</option>
			<option value="hiding">Hide features</option>
		</select>
	</div> -->
	<div id="map"></div>
	<div id="tabs">
		<ul>
			<li>
				<a href="#tabs-1">時間軸</a>
			</li>
		</ul>
		<div id="tabs-1">
			<div id="p1"></div>
		</div>


	</div>

</body>
</html>
