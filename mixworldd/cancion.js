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

		$(".inicio"+id).show();
		
		$(".detener"+id).hide();
		
		clearInterval(myinterval);
	});
	$(".bar").on("click",function(event){

		var id=this.id;

		var audio=document.getElementById("audios"+id);

		if(audio && !audio.ended){

			var rect = this.getBoundingClientRect();
			
			var ratonx = event.clientX - rect.left;
			
			var anchoTotal = $(this).width();
			
			var nuevotiempo = (ratonx * audio.duration) / anchoTotal;
			
			audio.currentTime = nuevotiempo;
			
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
		
		var areavalue=$(".starea"+id).val();
		
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