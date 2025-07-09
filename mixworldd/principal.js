$(document).ready(function(){
	
	var micancion, reproducir, barra, progreso, total, maximo,maximodos, audio, currentFile, myinterval;
	
	document.getElementById("searchicon").addEventListener("click",busca,false);
	
	audio=null;
	
	currentFile=null;
	
	barra=document.querySelector(".bar");
	
	maximo=barra.clientWidth;

	var currentAudio=null;
	
	$(".play").on("click",function(){

		var id=this.id;
		
		var audio=document.getElementById("audios"+id);
		
		if(currentAudio && currentAudio!=audio){

			currentAudio.pause();

			$(".inicio"+id).css("display","block");
		
			$(".detener"+id).css("display","none");
		}
		if($(".pause").css("display","block")){
					
			$(".pause").css("display","none");
			
			$(".play").css("display","block");
		}
		
		currentAudio=audio;

		audio.play();

		$(".inicio"+id).css("display","none");
		
		$(".detener"+id).css("display","block");

		myinterval=setInterval(function(){
			
			total=parseInt(audio.currentTime*maximo/audio.duration);
			
			var tamanoavance=$(".progreso"+id).width();
			
			var tamanoavancedos=$(".bar").width();
			
			if(tamanoavance<=tamanoavancedos){
				
				$(".progreso"+id).css("width",total+"px");
			}
			
			if(audio.ended){
			
				clearInterval(myinterval);
				
				$(".pause").css("display","none");
					
				$(".play").css("display","block");
				
				$(".progreso"+id).width(0);
			}
		});
	});
	$(".pause").on("click",function(){

		var id=this.id;
		
		var audio=document.getElementById("audios"+id);

		audio.pause();

		$(".inicio"+id).css("display","block");
		
		$(".detener"+id).css("display","none");
	});
	$(".bar").on("click",function(event){

		var id=this.id;

		var audio=document.getElementById("audios"+id);

		if((audio.paused==false) && (audio.ended==false)){

			var ratonx=event.pageX-this.offsetLeft;
			
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
