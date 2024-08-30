$(document).ready(function() {
    var template = "";
    var table = $('#example').DataTable({
        "ajax":{
        		"url": "../../controllers/lote.php",
        		"type": "POST",
        		"data": { funcion: 'datos_lote' },
                //"dataSrc": function(json) {
            		//console.log(json); // Esto imprimirá los datos recibidos en la consola
            		//return json.data; // Devuelve solo el array 'data' dentro del objeto JSON
        		//}
        
        },
        "columns": [
            { "data": "id_lote" },
            { "data": "nombre" },
            { "data": "descripcion" },
            { "data": "latitud" },
            { "data": "longitud" },
            
            
                  
                    
           

        ],
         "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
        
        
    // Manejar el evento de cambio del checkbox
    $('#example').on('change', '.estado-switcher', function() {
         var checkbox = $(this);
         var idLote = $(this).data('id');
         var nuevoEstado = $(this).is(':checked');
         //console.log(nuevoEstado);
            
         if(nuevoEstado){
         	Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Estás seguro de que deseas habilitar este lote?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                   	var funcion = "habilitar"
                    $.post('../../controllers/lote.php',
                      {
                      funcion,
          			  idLote,
                    }, (response) => {
          				
                    	if(response == "habilitado"){
                            table.ajax.reload(null, false);
                    		alertaCorrecto('Éxito', 'La operación se completó correctamente.');
                       	}
                    
                    
                    })
                   
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    alertaError('Operación cancelada', 'Los cambios han sido revertidos');
                    // Si el usuario cancela, revertir el estado del checkbox
                	checkbox.prop('checked', !checkbox.is(':checked'));
                }
            })
         }else{
         	Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Estás seguro de que deseas deshabilitar este lote?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                   	var funcion = "deshabilitar"
                    $.post('../../controllers/lote.php',
                      {
                      funcion,
          			  idLote,
                    }, (response) => {
          				
                    	if(response == "deshabilitado"){
                            table.ajax.reload(null, false);
                    		alertaCorrecto('Éxito', 'La operación se completó correctamente.');
                       	}
                    
                    
                    })
                   
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    alertaError('Operación cancelada', 'Los cambios han sido revertidos');
                    // Si el usuario cancela, revertir el estado del checkbox
                	checkbox.prop('checked', !checkbox.is(':checked'));
                }
            })
         
         }
        //var nuevoEstado = $(this).is(':checked') ? '1' : '2'; // '1' para activo, '0' para inactivo

        
    });
        
        
        
        
    // TODO: BTN CREAR LOTE
  	$('#btnnuevo').click(function () {
    	$('#myModalForm')[0].reset();
    	$('#myModalLabel').html('CREAR LOTE');
    	$("#accion").val("crear_lote");
    	$('#myModal').modal('show');
  	});
	
        
  	//TODO: INSERTAR USUARIO
	$('#myModalForm').submit(function(e) {
        e.preventDefault();
        
        let id_lote = $('#id_lote').val();
        let nombre = $('#nombre').val();
        let descripcion = $('#des').val();
        let latitud = $('#latitud').val();
        let longitud = $('#longitud').val();
        var accion = $("#accion").val();

        let data = {
            funcion: accion,
            id_lote: id_lote,
            nombre: nombre,
            descripcion: descripcion,
            latitud: latitud,
            longitud: longitud
        };

        $.post('../../controllers/lote.php', data, function(response) {
            response = response.trim();
            console.log(response);
            if (response === "add") {
                table.ajax.reload(null, false);
                alertaCorrecto('Éxito', 'Se creó el lote correctamente.');
            } else if (response === "noadd") {
                alertaError('Error', 'No se completó correctamente.');
            } else if (response === "edit") {
                table.ajax.reload(null, false);
                alertaCorrecto('Éxito', 'Se editó el lote correctamente.');
            } else {
                const errores = JSON.parse(response);
                for (const clave in errores) {
                    const valor = errores[clave];
                    $('#' + clave).hide('slow').show(1000).delay(2000).hide(1000);
                    $('#' + clave).html('<span><i class="fas fa-times m-1"></i>' + valor + '</span>');
                }
            }
        });
    });
        
        
    // TODO: BTN EDITAR LOTE
    $('#example tbody').on('click', '.edit-btn', function() {
        // Obtener el ID del lote del atributo data-id
        let id_lote = $(this).data('id');
        
        // Actualizar el título del modal y otros elementos
        $('#myModalLabel').html('EDITAR LOTE');
        $("#accion").val("editar_lote");
        $("#id_lote").val(id_lote);
        $("#myModal").modal('show');
        
        // Hacer una petición POST a '../../controllers/lote.php'
        $.ajax({
            url: '../../controllers/lote.php', // La URL del script PHP
            type: 'POST', // Tipo de petición (GET, POST, etc.)
            dataType: 'json', // Espera una respuesta en formato JSON
            data: { funcion: 'datos_lote_id', id_lote: id_lote }, // Datos a enviar al servidor
            success: function(data) {
                 console.log(data)
                // Maneja los datos recibidos
                if (data) {
                    // Rellena el formulario en el modal con los datos recibidos
                    $('#nombre').val(data.nombre);
                    $('#des').val(data.descripcion);
                    $('#latitud').val(data.latitud);
                    $('#longitud').val(data.longitud);
                    // Añade más campos según sea necesario
                } else {
                    
                    alertaError('Error', 'No se encontraron datos para el ID especificado')
                }
            },
            error: function(xhr, status, error) {
                // Maneja los errores
                console.error('Error:', error);
            }
        });
    });

        
    
   function alertaError(titulo, texto){
   		Swal.fire({
    			title: titulo,
    			text: texto,
    			icon: 'error',
    			confirmButtonText: 'Entendido'
		});
   
   }
        
   function alertaCorrecto(titulo, texto){
   		Swal.fire({
    			title: titulo,
    			text: texto,
    			icon: 'success',
    			confirmButtonText: 'Entendido'
		});
   
   
   
   }
        
        
        
})