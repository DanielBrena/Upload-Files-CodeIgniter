$(document).ready(function(){

	refrescar_noticias();

	$(".opcion").click(function(){//Hacer click en la etiqueta con clase principal.

		if($(this).is(":checked")){//Si esta activo.

				if($(this).val() == "pdf"){
					$("#url").attr("disabled","disabled");
					$("#pdf-file").removeAttr("disabled");
					$("#url").val("");
				}else{
					$("#pdf-file").attr("disabled","disabled");
					$("#url").removeAttr("disabled");
					$("#pdf-file").val("");
				}
				
		}
	});



	var options = { 

	    url: 'noticia/upload_file',
	    dataType:"json",
	    type:"post",
	    success:    function(data) { 
	        
	        $("#titulo").val("");
	        $(":file").val("");
	        alert(data.msg); 
	        refrescar_noticias();
	    } 
	}; 
	 
	 
	$('#upload-file').ajaxForm(options);
	

});

function refrescar_noticias(){
	$.get("noticia/noticias",function(data){

		$("#noticias").html(data);

		$(".url-p").click(function(e){
			e.preventDefault();
			var url = prompt("Edita la Direccion URL",$(this).text());

			if(url != null){
				cambiar_url($(this),url);
			}
			
		});

		$(".titulo-p").click(function(e){
			e.preventDefault();
			var titulo = prompt("Edita el titulo",$(this).text());

			if(titulo != null){
				cambiar_titulo($(this),titulo);
			}
			
		});

		$(".delete").click(function(e){
			e.preventDefault();
			eliminar_not($(this));
		});


		$(".activo").click(function(e){
			e.preventDefault
			var not = {}//Creamos un objeto img.
		
			not.id = $(this).val();//Asigamos al atributo id el valor de cual etiqueta nos estamos referenciando cuando hacemos click.

			if($(this).is(":checked") ){//Si esa activa el checkbox.
				not.opcion = "activar";//Asigamos al atributo opcion el valor de activar.
			}else{
				not.opcion = "desactivar";//Asignamos al atributo opcion el valor de desactivar.
			}

			estado_not(not);
		});


		$(".principal").click(function(){//Hacer click en la etiqueta con clase principal.

			if($(this).is(":checked")){//Si esta activo.
				var not = {}//Creamos un objeto img.
				not.id = $(this).val();//Asigamos al atributo id el valor de la misma etiqueta.
				not.opcion = "principal";//Asignamos al atributo opcion el valor de principal.
				estado_not(not);//Pasamos como parametro la img en la funcion peticion.
			}
		});



	});

	
}


function eliminar_not(obj){
	if(confirm("¿Estas seguro de eliminar esta noticia?")){
		var id_not = obj;
		$.ajax({
			url:"noticia/delete_noticia/" + id_not.attr("data-not-id"),
			dataType:"json",
				success:function(data){
					if(data.status === "success"){
						id_not.parents("tr").fadeOut("fast",function(){
							$(this).remove();
						});
					}else{
						alert(data.msg);
					}
				}
			});
		}
}


function estado_not(obj){

	$.ajax({
	    url: "noticia/activar_not",//Direccion donde se va a procesar la informacion.
	    data:obj,//Informacion a  enviar.
	    type: "POST",//Metodo por el cual se va a enviar dicha informacion.
	    dataType: "json",//Tipo de dato que regresara la peticion.
	    beforeSend:function(){//Metodo que se ejecuta antes de ser enviado.
	                 
	    },
	    success: function (data) {//Metodo que regresa al ser enviado.

		    //cargar();//Mandamos a llamar a la funcion llamar para que se recargue nuevamente la informacion.  
		    alert(data.msg);//Creamos un alet con el mensaje.

	    },error:function(){       
	    	console.log("Error");//Mandamos a consoola un mensaje de error si salio algo mal.(opcional)
	    }
	    
	});

}


function cambiar_url(obj_,url){
	if(url != null){
		var id_not = obj_;
		obj = {};
		obj.id = id_not.attr("data-not-id");
		obj.url = url;
		$.ajax({
		    url: "noticia/editar_url",//Direccion donde se va a procesar la informacion.
		    data:obj,//Informacion a  enviar.
		    type: "POST",//Metodo por el cual se va a enviar dicha informacion.
		    dataType: "json",//Tipo de dato que regresara la peticion.
		    beforeSend:function(){//Metodo que se ejecuta antes de ser enviado.
		                 
		    },
		    success: function (data) {//Metodo que regresa al ser enviado.

		    	if(data.status === "error"){
		    		alert(data.msg);
		    	}else{
		    		refrescar_noticias();
		    	}
		    	
			    //cargar();//Mandamos a llamar a la funcion llamar para que se recargue nuevamente la informacion.  
			    //Creamos un alet con el mensaje.


		    },error:function(){       
		    	console.log("Error");//Mandamos a consoola un mensaje de error si salio algo mal.(opcional)
		    }
		    
		});
	}
}


function cambiar_titulo(obj_,titulo){
	if(url != null){
		var id_not = obj_;
		obj = {};
		obj.id = id_not.attr("data-not-id");
		obj.titulo = titulo;
		$.ajax({
		    url: "noticia/editar_titulo",//Direccion donde se va a procesar la informacion.
		    data:obj,//Informacion a  enviar.
		    type: "POST",//Metodo por el cual se va a enviar dicha informacion.
		    dataType: "json",//Tipo de dato que regresara la peticion.
		    beforeSend:function(){//Metodo que se ejecuta antes de ser enviado.
		                 
		    },
		    success: function (data) {//Metodo que regresa al ser enviado.

		    	if(data.status === "error"){
		    		alert(data.msg);
		    	}else{
		    		refrescar_noticias();
		    	}
		    	
			    //cargar();//Mandamos a llamar a la funcion llamar para que se recargue nuevamente la informacion.  
			    //Creamos un alet con el mensaje.


		    },error:function(){       
		    	console.log("Error");//Mandamos a consoola un mensaje de error si salio algo mal.(opcional)
		    }
		    
		});
	}
}