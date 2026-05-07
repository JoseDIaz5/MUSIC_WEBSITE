$(document).ready(function(){
	
	document.getElementById("songimage").addEventListener("click",seleccionaimagen,false);
	
	document.getElementById("imageselect").addEventListener("change",procesa,false);
	
	
	
	$("#titulo").focus(function(){
		
		$("#titleicon").css("color","#DC143C");
		
		$("#titleicon").css("transition","0.4s");
	});
	$("#titulo").focusout(function(){
		
		$("#titleicon").css("color","#000000");
		
		$("#titleicon").css("transition","0.4s");
	});
	function seleccionaimagen(){
		
		$("#imageselect").click();
	}
	function procesa(e){
		
		var archivo=e.target.files;
		
		var mi_archivo=archivo[0];
		
		var lector=new FileReader();
		
		var extension=mi_archivo.type;
		
		if(extension!='image/jpeg' && extension!='image/jpg' && extension!='image/png' && extension!='image/gif'){
			
			document.getElementById("imageerror").innerHTML="Debe seleccionar una imagen (jpg, png, gif)";
		}else{
			
			lector.readAsDataURL(mi_archivo);
		
			lector.addEventListener("load",mostrar,false);
			
			document.getElementById("imageerror").innerHTML="";
		}
	}
	function mostrar(e){
		
		var resultado=e.target.result;
		
		document.getElementById("imagencanciontres").innerHTML="<img width='100%' height='100%' src='" + resultado + "'>";
	}
		
	$("#botonactualiza").click(function(e){
		
		e.preventDefault();
		
		actualizacancion();
	});
	
	function actualizacancion(){
		
		const form=document.querySelector('form[action="updatingsong.php"]');
		
		const errorImagen=document.getElementById("imageerror");
		
		const inputImagen=document.getElementById("imageselect");
		
		errorImagen.textContent="";
		
		const formData=new FormData(form);
		
		const xhr=new XMLHttpRequest();
		
		xhr.onload=function(){
			
			if(xhr.status===200){
				
				const iduserh=document.getElementsByName("iduserh")[0].value;
				
				window.location.href="cuenta.php?user="+iduserh;
			}else{
				
				const respuesta=xhr.responseText;
				
				errorImagen.textContent=respuesta;
				
				errorImagen.style.color="red";
			}
		};
		
		xhr.open('POST', 'updatingsong.php',true);
		
		xhr.send(formData);
	}
	
	$("#titulo").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9]+/g, ""));
	});
	$("#textarea").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9@.:/]+/g, ""));
	});
});