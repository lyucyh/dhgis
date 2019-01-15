<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8" />
<title>地理權威詞統計與視覺化</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link rel="stylesheet" href="dist/leaflet.css" />
<link rel="stylesheet" href="dist/leaflet.draw.css" />
<link rel="stylesheet" href="dist/search/leaflet-search.css" />
<link rel="stylesheet" href="dist/custom/CustomTools.css" />
<link rel="stylesheet" href="dist/MarkerCluster.css" />
<link rel="stylesheet" href="dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="css/jquery-ui.theme.css" type="text/css" media="screen">

<link rel="stylesheet" href="css/jquery-ui.css">
<script src="src/external/jquery/jquery.js"></script>
<script src="src/external/jquery/jquery-ui.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	$("#loadingQuery").show();
	//$("#loadinggif").hide();
    jQuery("#tabs").tabs();
    queryLibrary(0,false,false,false);
});
$(function() {  
	
});
</script>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<style>
html, body, #mapid {
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
.hover-cyan4:focus, .hover-cyan4:hover {
    color: #3bc9db;
    font-size:15px;
}
</style>


<body>
	<!-- json資料js 
	<script src="dist/ezui/dynasty.json"></script>-->


	<!-- ui-dialog -->
	<div id="books"></div>
	<div id="showDetail" class="dailog_class easyui-dialog"></div>
	<!-- 顯示文本中的權威詞 -->
	<div id="words" class="easyui-dialog" data-options="left:50,top:10">
		<div id="tabs" style="display: none">
			<ul>
				<li>
					<a id="Library_list" href="#tabs-1">權威詞</a>

				</li>
				<li>
					<a id="Places_list" href="#tabs-2">地名列表</a>
				</li>
				<li>
					<a href="#tabs-3">面積查詢地名</a>
				</li>
			</ul>
			<div id="tabs-1"></div>
			<div id="tabs-2"></div>
			<div id="tabs-3"></div>
		</div>
	</div>

	<div id="bookinfo"></div>
	<div id="placeList"></div>
	<div id="map" style="width: 100%; height: 100%; position: absolute;"></div>
	<div id="loadingQuery" style="z-index: 99999999; position: absolute; left: 30%; top: 30%; ">
		<img src="images/loading2.gif">
		
	</div>


	<input name="gid" type="hidden" value="<?php if(isset($_GET['gid'])){ echo $_GET['gid']; }else{ echo "107";}?>" title="gid">
	<input name="uid" type="hidden" value="<?php if(isset($_GET['user_id'])){ echo $_GET['user_id']; }else{ echo "60";}?>" title="uid">
	<input name="textid" id="textid" type="hidden" title="textid" value="<?php if(isset($_GET['text_id'])){ echo $_GET['text_id']; }else{ echo "";}?>">
	<input name="authority1" type="hidden" title="authority1" value="<?php if(isset($_GET['authority1'])){ echo $_GET['authority1']; }else{ echo "";}?>">
	<input name="authority2" type="hidden" title="authority2" value="<?php if(isset($_GET['authority2'])){ echo $_GET['authority2']; }else{ echo "";}?>">
	<input name="authority1_n" type="hidden" title="authority1_n" value="<?php if(isset($_GET['authority1_n'])){ echo $_GET['authority1_n']; }else{ echo "地名";}?>">
	<input name="authority2_n" type="hidden" title="authority2_n" value="<?php if(isset($_GET['authority2_n'])){ echo $_GET['authority2_n']; }else{ echo "權威詞";}?>">
	<input name="task_id" type="hidden" title="task_id" value="<?php if(isset($_GET['task_id'])){ echo $_GET['task_id']; }else{ echo "";}?>">
	<input name="limit" type="hidden" title="limit" value="<?php if(isset($_GET['limit'])){ echo $_GET['limit']; }else{ echo "";}?>">


	<!-- 主程式 -->
	<script src="dist/leaflet-src.js"></script>
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


	<!-- load booklist主程式 -->
	<link rel="stylesheet" href="dist/ezui/easyui.css" />
	<link rel="stylesheet" href="dist/ezui/demo.css" />
	<script type="text/javascript" src="dist/ezui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="dist/ezui/datagrid-filter.js"></script>
	<script type="text/javascript" src="dist/ezui/ezuimain_v2.js"></script> <!-- 主要資料功能表格的程式檔 -->


	<!-- Cluster js -->
	<script src="dist/leaflet.markercluster-src.js"></script>


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
	<script src="dist/main_leaflet.js"></script><!-- 主要地圖功能的程式檔 -->
	<!-- leaflet客製Tools js: CleanMapLayer, -->
	<script src="dist/custom/CustomTools.js"></script>
	<script type="text/javascript">
  //===============加入客製化的清理marker功能至map======dist/custom/CustomTools.js=======
    map.addControl(new CleanMapLayer());

    //=================載入權威詞/地名==================dist/custom/CustomTools.js========
   // map.addControl(new LoadLibrary());
    </script>



</body>
<footer>(程式開發: 陳欣瑜 shinyu@gate.sinica.edu.tw)</footer>
</html>
