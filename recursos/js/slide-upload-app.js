$(document).ready(function(){

	refrescar_imagenes();

	

	$("#upload-file").submit(function(e){
		e.preventDefault();

		$.ajaxFileUpload({
			url: 	"slide/upload_file",
			secureuri: 	false,
			fileElementId: 	"imagen-file",
			dataType: 	"json",
			data: {
				"url": $("#url").val()
			},
			success: function(data,status){
				if(data.status != "error"){
					//$("#imagenes").html("<p>Recargando imagenes...</p>");
					refrescar_imagenes();
					//delete_img();
					$("#url").val("");

				}else{
					console.log(data.msg + " " + data.success);
				}
				alert(data.msg);
			}
		});
		return false;
	});

});

function refrescar_imagenes(){
	$.get("slide/imagenes",function(data){

		$("#imagenes").html(data);

		$(".delete").click(function(e){
			e.preventDefault();
			eliminar_img($(this));
		});

		$(".url-p").click(function(e){
			e.preventDefault();
			var url = prompt("Edita la Direccion URL",$(this).text());

			if(url != null){
				cambiar_url($(this),url);
			}
			
		});

		$(".activo").click(function(e){
			e.preventDefault
			var img = {}//Creamos un objeto img.
		
			img.id = $(this).val();//Asigamos al atributo id el valor de cual etiqueta nos estamos referenciando cuando hacemos click.

			if($(this).is(":checked") ){//Si esa activa el checkbox.
				img.opcion = "activar";//Asigamos al atributo opcion el valor de activar.
			}else{
				img.opcion = "desactivar";//Asignamos al atributo opcion el valor de desactivar.
			}

			estado_img(img);
		});

		$(".principal").click(function(){//Hacer click en la etiqueta con clase principal.

			if($(this).is(":checked")){//Si esta activo.
				var img = {}//Creamos un objeto img.
				img.id = $(this).val();//Asigamos al atributo id el valor de la misma etiqueta.
				img.opcion = "principal";//Asignamos al atributo opcion el valor de principal.
				estado_img(img);//Pasamos como parametro la img en la funcion peticion.
			}
		});
	});

	
}

function cambiar_url(obj,url){
	if(url != null){
		var id_img = obj;
		obj = {};
		obj.id = id_img.attr("data-img-id");
		obj.url = url;
		$.ajax({
		    url: "slide/editar_url",//Direccion donde se va a procesar la informacion.
		    data:obj,//Informacion a  enviar.
		    type: "POST",//Metodo por el cual se va a enviar dicha informacion.
		    dataType: "json",//Tipo de dato que regresara la peticion.
		    beforeSend:function(){//Metodo que se ejecuta antes de ser enviado.
		                 
		    },
		    success: function (data) {//Metodo que regresa al ser enviado.

		    	if(data.status === "error"){
		    		alert(data.msg);
		    	}else{
		    		refrescar_imagenes();
		    	}
		    	
			    //cargar();//Mandamos a llamar a la funcion llamar para que se recargue nuevamente la informacion.  
			    //Creamos un alet con el mensaje.


		    },error:function(){       
		    	console.log("Error");//Mandamos a consoola un mensaje de error si salio algo mal.(opcional)
		    }
		    
		});
	}
}
function estado_img(obj){

	$.ajax({
	    url: "slide/activar_img",//Direccion donde se va a procesar la informacion.
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

function eliminar_img(obj){
	if(confirm("¿Estas seguro de eliminar esta imagen?")){
				var id_img = obj;

				$.ajax({
					url:"slide/delete_imagen/" + id_img.attr("data-img-id"),
					dataType:"json",
					success:function(data){

						if(data.status === "success"){
							id_img.parents("tr").fadeOut("fast",function(){
								$(this).remove();
							});
						}else{
							alert(data.msg);
						}
					}
				});
			}
}

