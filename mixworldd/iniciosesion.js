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
		
		var correo=$("#correo").val();
		
		var contrasena=$("#contrasena").val();
		
		$.ajax({
			
			url:'validasesion.php',type:'POST',data:{correo:correo,contrasena:contrasena},dataType:'json',
			
			success:function(data){
				
				if(data.exito){
					
					window.location.href=data.redireccion;
				}else{
					
					$("#mensaje-servidor").text(data.mensaje).fadeIn();
				}
			}
		});
	}
	$("#correo").on("input", function() {
	    
	    const limpio = $(this).val().replace(/[ "'\\()]/g, "");
	    $(this).val(limpio);
	});
	$("#correo").on("blur",function(){
		
		const email = $(this).val().trim();
	    const regexOrden = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
	
	    if (email === "") {
	        $("#cmessage").hide();
	        return;
	    }
	    if (!regexOrden.test(email)) {
	        
	        $("#cmessage").text("Formato inválido (ej: usuario@dominio.com)").show();
	        
	    } else {
	        
	        $("#cmessage").hide();
	        
	    }
	});
});