$(document).ready(function(){
	
	var total, barra, maximo, audio, currentFile;
	
	
	
	barra=document.querySelector(".bar");
	
	maximo=barra.clientWidth;
	
	document.getElementById("comp").addEventListener("click",comparte,false);
	
	document.getElementById("contcanciones").addEventListener("click",contenido,false);
	
	document.getElementById("delete").addEventListener("click",eliminar,false);
	
	document.getElementById("uploadsongbutton").addEventListener("click",sharesong,false);
	
	document.getElementById("uploadimagesongbutton").addEventListener("click",shareimagesong,false);
	
	document.getElementById("songselect").addEventListener("change",changesongname,false);
	
	document.getElementById("imageselect").addEventListener("change",changeimagesongname,false);
	
	document.getElementById("botonregistra").addEventListener("click",subecancion,false);
	
	document.getElementById("deleteaccountbutton").addEventListener("click",eliminacuenta,false);
	
	document.getElementById("iform").addEventListener("submit",validaform,false);
	
	function comparte(){
		
		$("#uploadsongs").slideToggle(500);
		
		$("#songs").css("display","none");
		
		$(".deleteaccount").css("display","none");
	}
	function contenido(){
		
		$("#songs").slideToggle(500);
		
		$("#uploadsongs").css("display","none");
		
		$(".deleteaccount").css("display","none");
	}
	function eliminar(){
		
		$(".deleteaccount").slideToggle(500);
		
		$("#songs").css("display","none");
		
		$("#uploadsongs").css("display","none");
	}
	function sharesong(){
		
		$("#songselect").click();
	}
	function shareimagesong(){
		
		$("#imageselect").click();
	}
	function changesongname(e){
		
		var archivos=e.target.files;
		
		var archivo=archivos[0];
		
		var extension=archivo.type;
		
		var tamano=archivo.size;
		
		var tamanoconvertido=Math.ceil(tamano/1024);
		
		if(tamanoconvertido>20000){
			
			document.getElementById("filenamethree").innerHTML="El tamaño excede el limite (20000 KB)";
			
			document.getElementById("filenameone").innerHTML="Ningún archivo seleccionado"
			
			$("#filenameone").css("color","black");
			
			$("#filenameone").css("font-weight","bolder");
			
			e.preventDefault();
		}else{
			
			document.getElementById("filenamethree").innerHTML="";
		}
		if(extension!='audio/mpeg' && extension!='audio/x-m4a' && extension!='audio/wav'){
			
			document.getElementById("filenametwo").innerHTML="Seleccione un archivo de audio (mp3, m4a, wav)";
			
			document.getElementById("filenameone").innerHTML="Ningún archivo seleccionado";
			
			$("#filenameone").css("color","black");
			
			$("#filenameone").css("font-weight","bolder");
			
			e.preventDefault();
		}else if(tamanoconvertido>20000){
			
			e.preventDefault();
			
			document.getElementById("filenameone").innerHTML="Ningún archivo seleccionado";
			
			document.getElementById("filenametwo").innerHTML="";
		}else{
			
			document.getElementById("filenameone").innerHTML=archivo.name;
			
			document.getElementById("filenametwo").innerHTML="";
			
			$("#filenameone").css("color","#d40000");
		
			$("#filenameone").css("font-weight","bolder");
		}
	}
	function changeimagesongname(e){
		
		var archivos=e.target.files;
		
		var archivo=archivos[0];
		
		var extension=archivo.type;
		
		if(extension!="image/jpeg" && extension!="image/png" && extension!="image/jpg"){
			
			document.getElementById("filenamei").innerHTML="Seleccione un archivo de tipo imagen (png, jpg)";
			
			$("#filenamei").css("color","black");
			
			$("#filenamei").css("font-weight","bolder");
		}else{
			
			document.getElementById("filenamei").innerHTML=archivo.name;
			
			$("#filenamei").css("color","#d40000");
		
			$("#filenamei").css("font-weight","bolder");
		}
	}
	function validaform(e){
		
		var fileInput = document.getElementById('songselect');
		
		var selectedFile = fileInput.files[0];
		
		var filesize = Math.ceil(selectedFile.size/1024);
		
		var filetype = selectedFile.type;
		
		if(filesize>15000){
			
			e.preventDefault();
		}
		if(filetype!='audio/mpeg' && filetype!='audio/mp4' && filetype!='audio/flac' && filetype!='audio/wav'
			&& filetype!='audio/m4a' && filetype!='audio/x-m4a'){
				
			e.preventDefault();
		}
		
	}
	function subecancion(){
		
		const form = document.getElementById('iform');
		
		const formatosPermitidos = ['image/png', 'image/jpeg', 'image/jpg'];
		
		const formatosAudio = ['audio/mpeg', 'audio/wav', 'audio/flac', 'audio/mp4', 'audio/x-m4a', 'audio/m4a'];
		
		const inputImagen=document.getElementById('imageselect');
		
		const inputCancion=document.getElementById('songselect');
		
		let hayError = false;
    
	    if (!form.checkValidity()) {
			
	        form.reportValidity();
	        
	        return;
	    }
	    
	    const formData = new FormData(form);
	    
	    const xhr = new XMLHttpRequest();
	    
	    const progressContainer = document.getElementById('progress-container');
	    
	    const progressBar = document.getElementById('progressBar');
	    
	    const statusText = document.getElementById('statusText');
	    
	    progressContainer.style.display = 'block';
	    
	    xhr.upload.addEventListener('progress', function(e) {
	        
	        if (e.lengthComputable) {
	            const percent = Math.round((e.loaded / e.total) * 100);
	            progressBar.value = percent;
	            statusText.innerText = percent + '% subido...';
	        }
	    });
	    
	    xhr.onload = function() {
	        
	        if (xhr.status === 200 && xhr.responseText.trim() === "EXITO") {
	            
	            window.location.href = "confirmacioncancion.php";
	        } else {
	            
	            progressContainer.style.display = 'none';
	            
	            const mensajeErrorServidor=xhr.responseText;
	            
	            const mensajeCancion=document.getElementById('filenameone');
	            
	            const mensajeImagen=document.getElementById('filenamei');
	            
	            if(mensajeErrorServidor.includes("AUDIO") || mensajeErrorServidor.includes("ARCHIVOS")){
					
					mensajeCancion.textContent="Error del servidor: " + mensajeErrorServidor;
	            
	            	mensajeCancion.style.color="red";
				}else if(mensajeErrorServidor.includes("IMAGEN")){
					
					mensajeImagen.textContent="Error del servidor: " + mensajeErrorServidor;
					
					mensajeImagen.style.color="red";
				}
				else {
                
                	
                
	                alert("Error en la subida: " + mensajeErrorServidor);
	            }
	        }
	    };
	
	    xhr.open('POST', 'subecancion.php', true);
	    xhr.send(formData);
	}
	function eliminacuenta(){
		
		$("#botonelimina").click();
	}
	$("#campotitulo").focus(function(){
		
		$("#titleicon").css("color","#DC143C");
		
		$("#titleicon").css("transition","0.4s");
	});
	$("#campotitulo").focusout(function(){
		
		$("#titleicon").css("color","#000000");
		
		$("#titleicon").css("transition","0.4s");
	});
	
	var myinterval=null;
	
	var currentAudio=null;
	
	var currentId = null;
	
	$(".play").on("click",function(){

		var id=this.id;
		
		var audio=document.getElementById("audios"+id);
		
		if (currentAudio && currentAudio !== audio) {
	        
	        currentAudio.pause();
	        
	        clearInterval(myinterval);
	        
	        
	        $(".inicio" + currentId).show();
	        
	        $(".detener" + currentId).hide();
	        
	    }
	    
	    audio.play();
	    
	    currentAudio = audio;
	    
	    currentId = id;
	
	    $(".inicio" + id).hide();
	    
	    $(".detener" + id).show();
    	
    	myinterval = setInterval(function() {
			
	        if (!audio.paused) {
	        
	            let barraContenedora = $(".barra" + id).width();
	        
	            let avance = (audio.currentTime / audio.duration) * barraContenedora;
	        
	            $(".progreso" + id).css("width", avance + "px");
	        }
	
	        if (audio.ended) {
	        
	            clearInterval(myinterval);
	        
	            $(".inicio" + id).show();
	        
	            $(".detener" + id).hide();
	        
	            $(".progreso" + id).css("width", "0px");
	        }
	    }, 500);
		
		
	});
	$(".pause").on("click",function(){

		var id=this.id;
		
		var audio=document.getElementById("audios"+id);

		audio.pause();

		$(".inicio" + id).show();
		
	    $(".detener" + id).hide();
	    
	    clearInterval(myinterval);
	});
	$(".bar").on("click",function(event){

		var id=this.id;

		var audio=document.getElementById("audios"+id);

		if (audio && !audio.ended) {
        
	        var rect = this.getBoundingClientRect();
	        
	        var ratonx = event.clientX - rect.left;
	        
	        var anchoTotal = $(this).width();
	
	        var nuevotiempo = (ratonx * audio.duration) / anchoTotal;
	        
	        audio.currentTime = nuevotiempo;
	        
	        $(".progreso" + id).css("width", ratonx + "px");
	    }
		
	});
	$(".optionlink").click(function(){
		
		var id=this.id;
		
		$(".dropoptions"+id).animate({height:'toggle'},350);
		
	});
	$(".seguir").click(function(){
		
		var id=this.id;
		
		$.ajax({
			
			url:'manejaseguidores.php',type:'POST',data: {id:id}, dataType: 'json',
			
			success:function(data){
				
				var seguidor=data['siguiendo'];
				
				$(".divseguir"+id).html(seguidor);
			}
		});
	});
	$("#desc").keyup(function(){
		
		$(".counter").text($(this).val().length);
	});
	$("#campotitulo").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9]+/g,""));
	});
	$("#desc").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9@.:/]+/g,""));
	});
	$(".shareicon").click(function(){
		
		$(".shareprofileicons").toggle(350);
	});
});