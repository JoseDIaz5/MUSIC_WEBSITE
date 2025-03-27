$(document).ready(function(){
	
	var micancion, reproducir, barra, progreso, total, maximo, audio, currentFile, myinterval;
	
	document.getElementById("searchicon").addEventListener("click",busca,false);
	
	audio=null;
	
	currentFile=null;
	
	barra=document.querySelector(".bar");
	
	maximo=barra.clientWidth;
	
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
	function busca(){
		
		$("#botonbusca").click();
	}
	$(".buscador").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9]+/g, ""));
	});
});
