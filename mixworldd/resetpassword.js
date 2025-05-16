$(document).ready(function(){
	
	document.getElementById("botoncontrasena").addEventListener("click",cambiacontrasena,false);
	
	$("#password").focus(function(){
		
		$("#passicon").css("color","#DC143C");
		
		$("#passicon").css("transition","0.4s");
	});
	$("#password").focusout(function(){
		
		$("#passicon").css("color","#000000");
		
		$("#passicon").css("transition","0.4s");
	});
	function cambiacontrasena(){
		
		$("#enviacontrasena").click();
	}
});