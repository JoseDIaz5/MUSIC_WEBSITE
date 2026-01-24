$(document).ready(function(){
	
	let cancionesreproducidas={};
	
	$(".play").click(function(){
		
		var id=this.id;
		
		if(cancionesreproducidas[id]){
			
			return;
		}
		
		cancionesreproducidas[id]=true;
		
		$.ajax({
			
			url:'manejareproducciones.php',type:'POST',data: {id:id}, dataType: 'json',
			
			success:function(data){
				
				var cantidadreproducciones=data['cantidad'];
				
				$(".rep"+id).html(cantidadreproducciones);
			}
		});
	});
});