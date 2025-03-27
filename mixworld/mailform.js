$(document).ready(function(){
	
	$("#mail").focus(function(){
		
		$("#mailicon").css("color","#DC143C");
		
		$("#mailicon").css("transition","0.4s");
	});
	$("#mail").focusout(function(){
		
		$("#mailicon").css("color","#000000");
		
		$("#mailicon").css("transition","0.4s");
	});
});