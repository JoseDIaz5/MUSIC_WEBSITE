$(document).ready(function(){
	
	var micancion, reproducir, barra, progreso, total, maximo,maximodos, audio, currentFile, myinterval;
	
	document.getElementById("searchicon").addEventListener("click",busca,false);
	
	audio=null;
	
	currentFile=null;
	
	barra=document.querySelector(".bar");
	
	maximo=barra.clientWidth;

	var currentAudio=null;
	
	var myinterval=null;
	
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
	function busca(){
		
		$("#botonbusca").click();
	}
	$(".buscador").keyup(function(){
		
		const valor=$(this).val();
		
		$(this).val(valor.replace(/[^a-zA-ZÀ-ÿ\u00f1\u00d1 0-9]+/g, ""));
	});
});
