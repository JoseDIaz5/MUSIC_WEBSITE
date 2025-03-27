$(document).ready(function(){
	
	$(".likesong").click(function(){
		
		var id=this.id;
		
		$.ajax({
			
			url:'manejalikescanciones.php',type:'POST',data: {id:id}, dataType: 'json',
			
			success:function(data){
				
				var megustacancion=data['like'];
				
				var nomegustacancion=data['dlike'];
				
				$(".spanlike"+id).html(megustacancion);
				
				$(".spandislike"+id).html(nomegustacancion);
			}
			
		});
	});
});