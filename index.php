<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8" />

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
	$("#loadingQuery").hide();
	$("#loadinggif").hide();
    jQuery("#tabs").tabs();
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
  box-shadow: 4px 4px 3px grey; /* see http://www.w3schools.com/css/css3_shadows.asp */
  -moz-box-shadow: 4px 4px 3px grey;
  -webkit-box-shadow: 4px 4px 3px grey;
}
</style>


<body>
	<!-- json資料js -->
	<script src="dist/ezui/dynasty.json"></script>


	<!-- ui-dialog -->
	<div id="books"></div>
	<div id="showDetail" class="dailog_class easyui-dialog" ></div> <!-- 顯示文本中的權威詞 -->
	<div id="words" class="easyui-dialog" data-options="left:300,top:20">
		<div id="tabs" style="display: none">
			<ul>
				<li>
					<a id="Library_list" href="#tabs-1">文本查詢權威詞</a>
					
				</li>
				<li>
					<a href="#tabs-2">地名列表</a>
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
	<div id="book_time" class="easyui-layout" style="height: 100%;">
		<div data-options="region:'center',title:''">
		    <div id="loadingQuery" style="z-index:99999999;position:absolute;left:50%; top:50%;"><img src="images/loading.gif"><b>繪製圖層與區域查詢</b></div>
			<div id="map" style="width: 100%; height: 900px;position:absolute;"></div>
			
		</div>
		<div data-options="region:'west',split:true" title="時間資料查詢" style="width: 257px;">
			<div>
				請選擇年代區間(西元年):
				<br>
				<input type="text" name="FromYear" size="4" />
				年 -
				<input type="text" name="ToYear" size="4" />
				年
				<input id="year_search" type="button" value="載入文本" onclick="javascript:loadBookList(false);">
				<br>
				<br>
			</div>
			<b> 權威檔類型:</b>
			<br>
			<br>
			<div id="libraryType" class="easyui-datalist" style="width: 230px; height: 150px"></div>
			<b> 文本列表:</b>
			<br>
			<div id="bookList" class="easyui-datalist" style="width: 250px; height: 500px"></div>
			<br>
			
			<input id="library_search" type="button" value="權威詞篩選" onclick="javascript:queryLibrary(0,true,false,false);">
			<label id="loadinggif"><img src="images/loading.gif"></label>
		</div>
	</div>
 
	<input name="gid" type="hidden" value="<?php if(isset($_GET['gid'])){ echo $_GET['gid']; }else{ echo "107";}?>" title="gid">
	<input name="uid" type="hidden" value="<?php if(isset($_GET['user_id'])){ echo $_GET['user_id']; }else{ echo "60";}?>" title="uid">
	<input id="textid" type="hidden" title="texeid">
	<input name="textidfromdh" type="hidden" title="textidfromdh" value="<?php if(isset($_GET['text_id'])){ echo $_GET['text_id']; }else{ echo "";}?>">
	<input id="authority1" name="authority1" type="hidden" title="authority1">
	<input id="authority2" name="authority2" type="hidden" title="authority2">

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
	<link rel="stylesheet"  href="dist/ezui/easyui.css" />
	<link rel="stylesheet"  href="dist/ezui/demo.css" />
	<script type="text/javascript" src="dist/ezui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="dist/ezui/datagrid-filter.js"></script>
	<script type="text/javascript" src="dist/ezui/ezuimain.js"></script>


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
	<script src="dist/main_leaflet.js"></script>
	<!-- leaflet客製Tools js: CleanMapLayer, -->
	<script src="dist/custom/CustomTools.js"></script>
	<script type="text/javascript">
  //===============加入客製化的清理marker功能至map======dist/custom/CustomTools.js=======
    map.addControl(new CleanMapLayer());

    //=================載入權威詞/地名==================dist/custom/CustomTools.js========
   // map.addControl(new LoadLibrary());
    </script>



</body>
</html>
