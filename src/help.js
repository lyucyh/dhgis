$(function(){


//	操作說明步驟
	$("#step1_2").click(function () {
		$("#step1").addClass('hideMe');
		$("#step2").removeClass('hideMe');
		$("#step3").addClass('hideMe');
		$("#step4").addClass('hideMe');
	});
	$("#step2_3").click(function () {
		$("#step1").addClass('hideMe');
		$("#step2").addClass('hideMe');
		$("#step3").removeClass('hideMe');
		$("#step4").addClass('hideMe');

	});
	$("#step2_1").click(function () {
		$("#step1").removeClass('hideMe');
		$("#step2").addClass('hideMe');
		$("#step3").addClass('hideMe');
		$("#step4").addClass('hideMe');

	});
	$("#step3_2").click(function () {
		$("#step1").addClass('hideMe');
		$("#step2").removeClass('hideMe');
		$("#step3").addClass('hideMe');
		$("#step4").addClass('hideMe');

	});
	$("#step3_4").click(function () {
		$("#step1").addClass('hideMe');
		$("#step2").addClass('hideMe');
		$("#step3").addClass('hideMe');		
		$("#step4").removeClass('hideMe');

	});

	/* initial dialog(first) */
	$( "#help_dialog" ).dialog({
		autoOpen: true,
		title: "歡迎使用數位人文平台-文本與空間查詢系統",
		width: 500,
		height: 300

	}); 
});
