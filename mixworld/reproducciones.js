$(document).ready(function(){
	
	$(".play").click(function(){
		
		var id=this.id;
		
		$.ajax({
			
			url:'manejareproducciones.php',type:'POST',data: {id:id}, dataType: 'json',
			
			success:function(data){
				
				var cantidadreproducciones=data['cantidad'];
				
				$(".rep"+id).html(cantidadreproducciones);
			}
		});
	});
});