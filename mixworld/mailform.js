$(document).ready(function(){
	
	document.getElementById("botoncorreo").addEventListener("click",enviacorreo,false);
	
	$("#mail").focus(function(){
		
		$("#mailicon").css("color","#DC143C");
		
		$("#mailicon").css("transition","0.4s");
	});
	$("#mail").focusout(function(){
		
		$("#mailicon").css("color","#000000");
		
		$("#mailicon").css("transition","0.4s");
	});
	function enviacorreo(){
		
		$("#enviacorreo").click();
	}
});