$(document).ready(function(){
	
	document.getElementById("botonsesion").addEventListener("click",iniciasesion,false);
	
	$("#correo").focus(function(){
		
		$("#mailicon").css("color","#DC143C");
		
		$("#mailicon").css("transition","0.4s");
	});
	$("#correo").focusout(function(){
		
		$("#mailicon").css("color","#000000");
		
		$("#mailicon").css("transition","0.4s");
	});
	$("#contrasena").focus(function(){
		
		$("#passicon").css("color","#DC143C");
		
		$("#passicon").css("transition","0.4s");
	});
	$("#contrasena").focusout(function(){
		
		$("#passicon").css("color","#000000");
		
		$("#passicon").css("transition","0.4s");
	});
	function iniciasesion(){
		
		$("#sesion").click();
	}
	$("#correo").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[\\'" ]/g,""));
	});
});