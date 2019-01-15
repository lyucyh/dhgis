<!doctype html>
<html lang="us">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet"	href="dist/custom/fontawesome-all.min.css">
<link rel="stylesheet" href="dist/leaflet1.3.1.css" />
<link rel="stylesheet" href="dist/custom/leaflet-sidebar.css" />
<link rel="stylesheet" href="dist/custom/leaflet.Dialog.css" />
<!-- <link rel="stylesheet" href="dist/leaflet.css" /> -->
<link rel="stylesheet" href="dist/leaflet.draw.css" />
<link rel="stylesheet" href="dist/ezui/easyui.css" />
<link rel="stylesheet" href="dist/ezui/demo.css" />
<link rel="stylesheet" href="dist/search/leaflet-search.css" />
<link rel="stylesheet" href="dist/custom/CustomTools.css" />
<link rel="stylesheet" href="css/jquery-ui.theme.css" type="text/css"
	media="screen">

<link rel="stylesheet" href="css/jquery-ui.css">
<script src="src/external/jquery/jquery.js"></script>
<script src="src/external/jquery/jquery-ui.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	$("#loadingQuery").show();
	//$("#loadinggif").hide();
    jQuery("#tabs").tabs();
    queryLibrary(0,false,false,false);
    sidebar.open('f1');
});
$(function() {  
	
});
</script>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<style>
html, body {
	height: 100%;
	width: 100%;
	margin: 0;
	padding: 0;
}

.ui-datepicker-calendar {
	display: none;
}

div.dailog_class {
	overflow: hidden; /*dialog scoller hidden*/
}

.circleforMarker {
	background: #0000ff; /* color of the circle */
	border-radius: 50%; /* make the div a circular shape */
	box-shadow: 4px 4px 3px grey;
	/* see http://www.w3schools.com/css/css3_shadows.asp */
	-moz-box-shadow: 4px 4px 3px grey;
	-webkit-box-shadow: 4px 4px 3px grey;
}


</style>


<body>
	<!-- json資料js -->
	<script src="dist/ezui/dynasty.json"></script>

	<!-- ui-dialog -->

	<div id="sidebar" class="sidebar collapsed">
		<!-- Nav tabs -->
		<div class="sidebar-tabs">
			<ul role="tablist">
				<li><a href="#f1" role="tab"><i class="fa fa-list"></i></a></li>
				<li><a href="#f2" role="tab"><i class="fa fa-map-marker"></i></a></li>
				<li><a href="#f3" role="tab"><i class="fa fa-object-group"></i></a></li>
				<li><a href="#f4" role="tab"><i class="fa fa-file-alt"></i></a></li>
			</ul>
            <!-- 
			<ul role="tablist">
				<li><a href="#settings" role="tab"><i class="fa fa-gear"></i></a></li>
			</ul> -->
		</div>

		<!-- Tab panes -->
		<div class="sidebar-content">
			<div class="sidebar-pane" id="f1">
				<h1 class="sidebar-header">
					<span  id="Library_list">人名</span><span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
				</h1>
				<br>
				<div id="tabs-1" style="width:300px"></div>

			</div>

			<div class="sidebar-pane" id="f2">
				<h1 class="sidebar-header">
					<span  id="Places_list">地名</span><span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
					
				</h1>
				<br>
				<div id="tabs-2" style="width:300px"></div>
			</div>

			<div class="sidebar-pane" id="f3">
				<h1 class="sidebar-header">
					面積查詢地名<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
				</h1>
				<br>
				<div id="tabs-3" style="width:300px"></div>
			</div>

			<div class="sidebar-pane" id="f4">
				<h1 class="sidebar-header">
					文本內容<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
				</h1>
				<br>
				<div id="tabs-4" style="width:300px"></div>
			</div>


		</div>
	</div>
	<div id="map" style="width: 100%; height: 100%; position: absolute;"
		class="sidebar-map"  data-attribution="中央研究院-數位文化中心"></div>
	<div id="loadingQuery"
		style="z-index: 99999999; position: absolute; left: 30%; top: 30%;">
		<img src="images/loading2.gif">

	</div>


	<input name="gid" type="hidden"
		value="<?php if(isset($_GET['gid'])){ echo $_GET['gid']; }else{ echo "107";}?>"
		title="gid">
	<input name="uid" type="hidden"
		value="<?php if(isset($_GET['user_id'])){ echo $_GET['user_id']; }else{ echo "60";}?>"
		title="uid">
	<input name="textid" id="textid" type="hidden" title="textid"
		value="<?php if(isset($_GET['text_id'])){ echo $_GET['text_id']; }else{ echo "";}?>">
	<input name="authority1" type="hidden" title="authority1"
		value="<?php if(isset($_GET['authority1'])){ echo $_GET['authority1']; }else{ echo "";}?>">
	<input name="authority2" type="hidden" title="authority2"
		value="<?php if(isset($_GET['authority2'])){ echo $_GET['authority2']; }else{ echo "";}?>">
	<input name="authority1_n" type="hidden" title="authority1_n"
		value="<?php if(isset($_GET['authority1_n'])){ echo $_GET['authority1_n']; }else{ echo "地名";}?>">
	<input name="authority2_n" type="hidden" title="authority2_n"
		value="<?php if(isset($_GET['authority2_n'])){ echo $_GET['authority2_n']; }else{ echo "權威詞";}?>">
	<input name="task_id" type="hidden" title="task_id"
		value="<?php if(isset($_GET['task_id'])){ echo $_GET['task_id']; }else{ echo "";}?>">
	<input name="limit" type="hidden" title="limit"
		value="<?php if(isset($_GET['limit'])){ echo $_GET['limit']; }else{ echo "";}?>">


	<!-- 主程式 -->
	<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-rc.1/leaflet-src.js"></script>-->
	<script src="dist/leaflet-src1.3.1.js"></script>
	<!--  <script src="dist/leaflet-src.js"></script>-->
	<script src="dist/custom/leaflet-sidebar.js"></script>
	<script src="dist/Leaflet.draw.js"></script>
	<script src="dist/Leaflet.Draw.Event.js"></script>
	<script src="dist/Toolbar.js"></script>
	<script src="dist/Tooltip.js"></script>

	<!-- leaflet geometry js  -->
	<script src="dist/ext/GeometryUtil.js"></script>
	<script src="dist/ext/LatLngUtil.js"></script>
	<script src="dist/ext/LineUtil.Intersect.js"></script>
	<script src="dist/ext/Polygon.Intersect.js"></script>
	<script src="dist/ext/Polyline.Intersect.js"></script>
	<script src="dist/ext/TouchEvents.js"></script>

	<!-- leaflet客製Tools js: CleanMapLayer,route,dialog -->
	<script src="dist/custom/CustomTools.js"></script>
	<script src="dist/custom/L.Polyline.SnakeAnim.js"></script>
	<script src="dist/custom/Leaflet.Dialog.js"></script>
	

	<!-- load booklist主程式 -->

	<script type="text/javascript" src="dist/ezui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="dist/ezui/datagrid-filter.js"></script>
	<script type="text/javascript" src="dist/ezui/ezuimain_v4.js"></script>


	<!-- 編輯/繪圖圖層js -->
	<script src="dist/draw/DrawToolbar.js"></script>
	<script src="dist/draw/handler/Draw.Feature.js"></script>
	<script src="dist/draw/handler/Draw.SimpleShape.js"></script>
	<script src="dist/draw/handler/Draw.Polyline.js"></script>
	<script src="dist/draw/handler/Draw.Marker.js"></script>
	<script src="dist/draw/handler/Draw.Circle.js"></script>
	<script src="dist/draw/handler/Draw.CircleMarker.js"></script>
	<script src="dist/draw/handler/Draw.Polygon.js"></script>
	<script src="dist/draw/handler/Draw.Rectangle.js"></script>
	<script src="dist/Control.Draw.js"></script>
	<script src="dist/edit/EditToolbar.js"></script>
	<script src="dist/edit/handler/EditToolbar.Edit.js"></script>
	<script src="dist/edit/handler/EditToolbar.Delete.js"></script>
	<script src="dist/edit/handler/Edit.Poly.js"></script>
	<script src="dist/edit/handler/Edit.SimpleShape.js"></script>
	<script src="dist/edit/handler/Edit.Rectangle.js"></script>
	<script src="dist/edit/handler/Edit.Marker.js"></script>
	<script src="dist/edit/handler/Edit.CircleMarker.js"></script>
	<script src="dist/edit/handler/Edit.Circle.js"></script>
	<!-- 檢索js -->
	<script src="dist/search/leaflet-search.js"></script>

	<!-- 圖層js -->
	<script src="dist/layers.js"></script>

	<!-- leaflet前端控制js -->
	<script src="dist/main_leaflet_v3.js"></script>
	<script type="text/javascript">
  //===============加入客製化的清理marker功能至map======dist/custom/CustomTools.js=======
   
    var sidebar = L.control.sidebar('sidebar').addTo(map);

    //=================載入權威詞/地名==================dist/custom/CustomTools.js========
   // map.addControl(new LoadLibrary());
    </script>



</body>
</html>
