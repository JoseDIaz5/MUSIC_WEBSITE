$(document).ready(function(){
	
	document.getElementById("pictureicon").addEventListener("click",selecciona,false);
	
	document.getElementById("imageselect").addEventListener("change",procesa,false);
	
	document.getElementById("pictureicons").addEventListener("click",seleccionados,false);
	
	document.getElementById("imageselects").addEventListener("change",procesados,false);
	
	document.getElementById("botonregistra").addEventListener("click",creacuenta,false);
	
	$("#usuario").focus(function(){
		
		$("#usericon").css("color","#DC143C");
		
		$("#usericon").css("transition","0.4s");
	});
	$("#usuario").focusout(function(){
		
		$("#usericon").css("color","#000000");
		
		$("#usericon").css("transition","0.4s");
	});
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
    $("#confirmar").focus(function(){

        $("#passicon2").css("color","#DC143C");

        $("#passicon2").css("transition","0.4s");
    });
    $("#confirmar").focusout(function(){

        $("#passicon2").css("color","#000000");

        $("#passicon2").css("transition","0.4s");
    });
    $("#facebook").focus(function(){

        $("#facebookicon").css("color","#DC143C");

        $("#facebookicon").css("transition","0.4s");
    });
    $("#facebook").focusout(function(){

        $("#facebookicon").css("color","#000000");

        $("#facebookicon").css("transition","0.4s");
    });
    $("#instagram").focus(function(){

        $("#instagramicon").css("color","#DC143C");

        $("#instagramicon").css("transition","0.4s");
    });
    $("#instagram").focusout(function(){

        $("#instagramicon").css("color","#000000");

        $("#instagramicon").css("transition","0.4s");
    });
    $("#twitter").focus(function(){

        $("#xicon").css("color","#DC143C");

        $("#xicon").css("transition","0.4s");
    });
    $("#twitter").focusout(function(){

        $("#xicon").css("color","#000000");

        $("#xicon").css("transition","0.4s");
    });
    function selecciona(){
	
		$("#imageselect").click();
	}
	function procesa(e){
		
		var archivo=e.target.files;
		
		var mi_archivo=archivo[0];
		
		var lector=new FileReader();
		
		var extension=mi_archivo.type;
		
		if(extension!='image/jpeg' && extension!='image/jpg' && extension!='image/png' && extension!='image/gif'){
			
			document.getElementById("imageerror").innerHTML="Debe seleccionar una imagen (jpg, png, gif)";
			
			if(document.getElementById("perf")){
				
				var simg=document.getElementById("perf");
				
				var parent=simg.parentNode;
				
				parent.removeChild(simg);
			}
			
		}else{
		
			lector.readAsDataURL(mi_archivo);
			
			lector.addEventListener("load",mostrar,false);
			
			document.getElementById("imageerror").innerHTML="";
		
		}
	}
	function mostrar(e){
		
		var resultado=e.target.result;
		
		document.getElementById("imagenperfiltres").innerHTML="<img id='perf' width='100%' height='100%' src='" + resultado + "'>";
	}
	function seleccionados(){
		
		$("#imageselects").click();
	}
	function procesados(e){
		
		var archivos=e.target.files;
		
		var mi_archivo=archivos[0];
		
		var lector=new FileReader();
		
		var extension=mi_archivo.type;
		
		if(extension!='image/jpeg' && extension!='image/jpg' && extension!='image/png' && extension!='image/gif'){
			
			document.getElementById("imageerrortwo").innerHTML="Debe seleccionar una imagen (jpg, png, gif)";
			
			if(document.getElementById("port")){
				
				var dimg=document.getElementById("port");
				
				var parent=dimg.parentNode;
				
				parent.removeChild(dimg);
			}
			
		}else{
			
			lector.readAsDataURL(mi_archivo);
		
			lector.addEventListener("load",mostrardos,false);
			
			document.getElementById("imageerrortwo").innerHTML="";
		}
	}
	function mostrardos(e){
		
		var resultado=e.target.result;
		
		document.getElementById("contportadatres").innerHTML="<img id='port' width='100%' height='100%' src='" + resultado + "'>";
	}
	function creacuenta(){
		
		$("#botonregistrados").click();
	}
	$("#usuario").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9]+/g, ""));
	});
	$("#correo").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[\\'" ]/g,""));
	});
	$("#contrasena").keyup(function(){
		
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
	$("#confirmar").keyup(function(){
		
		c=$(this).val();
		
		if(c!=$("#contrasena").val()){
			
			document.getElementById("ptmessage").innerHTML="La contraseña no es igual";
		}
		if(c==$("#contrasena").val()){
			
			document.getElementById("ptmessage").innerHTML="";
		}
		if($(this).val()==""){
			
			document.getElementById("ptmessage").innerHTML="";
		}
	});
});