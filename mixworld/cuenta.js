$(document).ready(function(){
	
	var total, barra, maximo, audio, currentFile, myinterval;
	
	audio=null;
	
	currentFile=null;
	
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
		
		if(extension!='audio/mpeg' && extension!='audio/flac' && extension!='audio/wav' && extension!='audio/x-m4a'){
			
			document.getElementById("filenameone").innerHTML="Seleccione un archivo de audio (mp3, flac, wav, m4a)";
			
			$("#filenameone").css("color","black");
			
			$("#filenameone").css("font-weight","bolder");
		}else{
			
			document.getElementById("filenameone").innerHTML=archivo.name;
			
			$("#filenameone").css("color","#d40000");
		
			$("#filenameone").css("font-weight","bolder");
		}
	}
	function changeimagesongname(e){
		
		var archivos=e.target.files;
		
		var archivo=archivos[0];
		
		var extension=archivo.type;
		
		if(extension!="image/jpeg" && extension!="image/png" && extension!="image/jpg"){
			
			document.getElementById("filenametwo").innerHTML="Seleccione un archivo de tipo imagen (png, jpg)";
			
			$("#filenametwo").css("color","black");
			
			$("#filenametwo").css("font-weight","bolder");
		}else{
			
			document.getElementById("filenametwo").innerHTML=archivo.name;
			
			$("#filenametwo").css("color","#d40000");
		
			$("#filenametwo").css("font-weight","bolder");
		}
	}
	function subecancion(){
		
		$("#botonregistrados").click();
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
	$("#desc").focus(function(){
		
		$(this).animate({"height":"100px"},"slow");
	});
	$("#desc").blur(function(){
		
		$(this).animate({"height":"20px"},"slow");
	});
	$(".play").click(function(){
		
		var id=this.id;
		
		var song=$(this);
		
		var ruta=song.attr("data-file");
		
		if(audio && currentFile==ruta){
			
			audio.currentTime=0;
			
			audio.play();
			
			$(".inicio"+id).css("display","none");
			
			$(".detener"+id).css("display","block");
		}
		else{
			
			if(audio){
				
				if($(".pause").css("display","block")){
					
					$(".pause").css("display","none");
					
					$(".play").css("display","block");
				}
				
				audio.pause();
				
				clearInterval(myinterval);
			}
			
			audio=new Audio(ruta);
			
			currentFile=ruta;
			
			audio.play();
			
			$(".inicio"+id).css("display","none");
			
			$(".detener"+id).css("display","block");
		}
		
		myinterval=setInterval(function(){
			
			total=parseInt(audio.currentTime*maximo/audio.duration);
			
			$(".progreso"+id).css("width",total+"px");
			
			if(audio.ended){
				
				clearInterval(myinterval);
				
				$(".pause").css("display","none");
				
				$(".play").css("display","block");
			}
		},50);
	});
	$(".pause").click(function(){
		
		var id=this.id;
		
		if(audio){
			
			audio.pause();
			
			$(".inicio"+id).css("display","block");
			
			$(".detener"+id).css("display","none");
			
			clearInterval(myinterval);
		}
	});
	$(".bar").click(function(posicion){
		
		var id=this.id;
		
		if((audio.paused==false) && (audio.ended==false)){
			
			var ratonx=posicion.pageX-this.offsetLeft;
			
			var nuevotiempo=ratonx*audio.duration/maximo;
			
			audio.currentTime=nuevotiempo;
			
			$(".progreso"+id).css("width",ratonx+"px");
		}
	});
	$(".optionlink").click(function(){
		
		var id=this.id;
		
		$(".options"+id).fadeToggle(350);
		
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
});