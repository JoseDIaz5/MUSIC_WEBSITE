$(document).ready(function(){
	
	$(".dislikesong").click(function(){
		
		var id=this.id;
		
		$.ajax({
			
			url:'manejadislikescanciones.php',type:'POST',data: {id:id}, dataType: 'json',
			
			success:function(data){
				
				var megustacancion=data['like'];
				
				var nomegustacancion=data['dlike'];
				
				$(".spandislike"+id).html(nomegustacancion);
				
				$(".spanlike"+id).html(megustacancion);
			}
		});
	});
});