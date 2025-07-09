$(document).ready(function(){
	
	document.getElementById("botoncontrasena").addEventListener("click",cambiacontrasena,false);
	
	document.getElementById("iform").addEventListener("submit",validaform,false);
	
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
	$("#password").keyup(function(){
		
		p=$(this).val();
		
		if(p.length<9){
			
			document.getElementById("pmessage").innerHTML="Debe tener más de 8 caracteres";
		}
		if(!p.match(/[a-zÀ-ÿ\u00f1\u00d1]/g)){
			
			document.getElementById("pmessagee").innerHTML="Incluya letras minúsculas";
		}
		if(!p.match(/[A-ZÀ-ÿ\u00f1\u00d1]/g)){
			
			document.getElementById("pmessageee").innerHTML="Incluya letras mayúsculas";
		}
		if(!p.match(/[0-9]/g)){
			
			document.getElementById("pmessageeee").innerHTML="Incluya números";
		}
		if(!p.match(/[!@#$%^~&*_-]/g)){
			
			document.getElementById("pmessageeeee").innerHTML="Incluya 1 carácter especial";
		}
		if(p.length>8){
			
			document.getElementById("pmessage").innerHTML="";
		}
		if(p.match(/[a-zÀ-ÿ\u00f1\u00d1]/g)){
			
			document.getElementById("pmessagee").innerHTML="";
		}
		if(p.match(/[A-ZÀ-ÿ\u00f1\u00d1]/g)){
			
			document.getElementById("pmessageee").innerHTML="";
		}
		if(p.match(/[0-9]/g)){
			
			document.getElementById("pmessageeee").innerHTML="";
		}
		if(p.match(/[!@#$%^~&*_-]/g)){
			
			document.getElementById("pmessageeeee").innerHTML="";
		}
		if($(this).val()==""){
			
			document.getElementById("pmessage").innerHTML="";
			
			document.getElementById("pmessagee").innerHTML="";
			
			document.getElementById("pmessageee").innerHTML="";
			
			document.getElementById("pmessageeee").innerHTML="";
			
			document.getElementById("pmessageeeee").innerHTML="";
		}
	});
	$("#password_confirmation").keyup(function(){
		
		c=$(this).val();
		
		if(c!=$("#password").val()){
			
			document.getElementById("ptmessage").innerHTML="La contraseña no es igual";
		}
		if(c==$("#password").val()){
			
			document.getElementById("ptmessage").innerHTML="";
		}
		if($(this).val()==""){
			
			document.getElementById("ptmessage").innerHTML="";
		}
	});
	function validaform(e){
		
		var pa=$("#password").val();
		
		var ca=$("#password_confirmation").val();
		
		if(pa.length<9){
			
			e.preventDefault();
		}
		if(!pa.match(/[a-zÀ-ÿ\u00f1\u00d1]/g)){
			
			e.preventDefault();
		}
		if(!pa.match(/[A-ZÀ-ÿ\u00f1\u00d1]/g)){
			
			e.preventDefault();
		}
		if(!pa.match(/[0-9]/g)){
			
			e.preventDefault();
		}
		if(!pa.match(/[!@#$%^~&*_-]/g)){
			
			e.preventDefault();
		}
		if(ca!=$("#password").val()){
			
			e.preventDefault();
		}
		if($("#password_confirmation").val()==""){
			
			e.preventDefault();
		}
	}
});