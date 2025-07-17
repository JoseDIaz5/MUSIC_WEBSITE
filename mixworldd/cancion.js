$(document).ready(function(){
	
	var barra,total,maximo,audio,currentFile,myinterval;
	
	audio=null;
	
	currentFile=null;
	
	barra=document.querySelector(".bar");
	
	maximo=barra.clientWidth;
	
	document.getElementById("searchicon").addEventListener("click",busca,false);
	
	document.getElementById("botoncomenta").addEventListener("click",comenta,false);
	
	function busca(){
		
		$("#botonbusca").click();
	}
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
	$("#textarea").keyup(function(){
		
		$(".size").text($(this).val().length);
	});
	$(".tarea").keyup(function(){
		
		var id=this.id;
		
		$(".sizetwo"+id).text($(this).val().length);
	});
	$(".optionlink").click(function(){
		
		var id=this.id;
		
		$("#doptions"+id).animate({width:'toggle'},350);
		
	});
	function comenta(){
		
		$("#botoncomentar").click();
	}
	$(".editicon").click(function(){
		
		var id=this.id;
		
		$(".comment"+id).animate({height:'toggle'},350);
		
		$(".ocomment"+id).animate({height:'toggle'},350);
		
		$("#edit"+id).animate({height:'toggle'},350);
	});
	$(".closeedit").click(function(){
		
		var id=this.id;
		
		$(".comment"+id).animate({height:'toggle'},350);
		
		$(".ocomment"+id).animate({height:'toggle'},350);
		
		$("#edit"+id).animate({height:'toggle'},350);
	});
	$(".editcommentbutton").click(function(){
		
		var id=this.id;
		
		var areavalue=$(".tarea").val();
		
		$.ajax({
			
			url:'editcomment.php',type:'POST',data: {id:id,comment:areavalue},dataType: 'json',
			
			success:function(data){
				
				var comentario=data['editedcomment'];
				
				$(".comment"+id).animate({height:'toggle'},350);
				
				$(".ocomment"+id).animate({height:'toggle'},350);
		
				$("#edit"+id).animate({height:'toggle'},350);
				
				$(".scomment"+id).html(comentario);
				
			}
		});
	});
});