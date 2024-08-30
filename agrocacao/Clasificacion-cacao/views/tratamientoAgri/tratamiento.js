$(document).ready(function() {
    var template = "";
    
    var table = $('#example').DataTable({
    "ajax": {
        "url": "../../controllers/tratamiento.php",
        "type": "POST",
        "data": { funcion: 'dato_estado_cacao' },
        //"dataSrc": function(json) {
            //console.log(json); // Esto imprimirá los datos recibidos en la consola
            //return json.data; // Devuelve solo el array 'data' dentro del objeto JSON
        //}
    },
    "columns": [
        { "data": "id_estado_cacao" },
        { "data": "nombre" },
        { "data": "aplicar" },
        { "data": "dosis" },
        { "data": "tiempo" },
        { "data": "aplicacion"},
        { "data": "medida_manejo"},
        
    ],
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar:",
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

        
    
    // Manejar el evento click del botón usando jQuery
    $('#example tbody').on('click', '.btn-action', function() {
        //handleButtonClick(id_escaneo);
         id_escaneo = $(this).data('id');
         console.log(id_escaneo);
        // Mostrar el m1odal
        $('#myModal').modal('show');
            
    });
        
    //editar
    $('#example tbody').on('click', '.edit-btn', async function() {
    	// Obtener el id del tratamiento
    	var id_estado_cacao = $(this).data('id');
        $("#id_st").val(id_estado_cacao);
    
    	
    
    	// Definir la función y la URL
    	const funcion = 'tratamiento_id';
    	const url = '../../controllers/tratamiento.php';
    
    	// Crear el objeto URLSearchParams para los datos de la solicitud
    	const data = new URLSearchParams();
    	data.append('id_estado_cacao', id_estado_cacao);
    	data.append('funcion', funcion);

    	try {
        	// Realizar la petición con fetch
        	const response = await fetch(url, {
            	method: 'POST',
            	body: data
        	});

        	// Verificar si la respuesta es exitosa
        	if (!response.ok) {
            	throw new Error('Error en la solicitud. Estado: ' + response.status);
        	}

        	// Convertir la respuesta a texto
        	//const responseData = await response.text();
            // Convertir la respuesta a json
            const responseData = await response.json();
        
        	// Procesar la respuesta
        	console.log(responseData);
        
        	// Aquí puedes agregar el código para actualizar el contenido del modal
            const tratamiento = responseData[0];

            // Actualizar los campos del modal con los datos recibidos
            $('#nombre').val(tratamiento.nombre);
            $('#aplicar').val(tratamiento.aplicar );
            $('#dosis').val(tratamiento.dosis);
            $('#tiempo').val(tratamiento.tiempo);
            $('#aplicacion').val(tratamiento.aplicacion);
            $('#med_mane').val(tratamiento.medida_manejo);
            // Mostrar el modal
    		$("#myModalEditar").modal('show');

    	} catch (error) {
        // Manejar el error
        console.error('Hubo un problema con la solicitud:', error);
    	}
	});
        
        
        
    // Manejar el evento de clic en el botón de "Guardar Cambios"
$('#guardarCambiosBtn').on('click', async function() {
    var funcion = "editar";
    
    // Obtener los valores actuales de los campos del modal
    var id = $('#id_st').val();
    var nombre = $('#nombre').val();
    var aplicar = $('#aplicar').val();
    var dosis = $('#dosis').val();
    var tiempo = $('#tiempo').val();
    var aplicacion = $('#aplicacion').val();
    var med_mane = $('#med_mane').val();
    
    //console.log(id);
    
    // Validar los datos antes de enviarlos
    if (nombre === '' || aplicar === '' || dosis === '' || tiempo === '' || aplicacion === '' || med_mane === '' ) {
        alertaError("¡Error!", "Ingresa todos los datos");
    } else {
        const url = '../../controllers/tratamiento.php'; // Ruta del archivo PHP para guardar cambios
        
        const data = new URLSearchParams();
        
        data.append('funcion', funcion);
        data.append('id', id);
        data.append('nombre', nombre);
        data.append('aplicar', aplicar);
        data.append('dosis', dosis);
        data.append('tiempo', tiempo);
        data.append('aplicacion', aplicacion);
        data.append('med_mane', med_mane);
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: data
            });

            if (!response.ok) {
                throw new Error('Error en la solicitud. Estado: ' + response.status);
                alertaError("¡Error!", "Error en la solicitud. Estado: " + response.status);
            }

            const responseData = await response.text();
            
            console.log(responseData);
            if (responseData == "update") {
                // Cierra el modal después de guardar los cambios
                $("#myModalEditar").modal('hide');
                table.ajax.reload(null, false);
                alertCorrecto("Éxito", "Actualizado con éxito");
            }
        } catch (error) {
            console.error('Hubo un problema al guardar los cambios:', error);
            alertaError("¡Error!", "Hubo un problema al guardar los cambios");
        }
    }
});


    
   function alertaError(titulo, texto){
   		Swal.fire({
    		 title: titulo,
    		 text: texto,
    		 icon: 'error',
    		 confirmButtonText: 'Entendido'
		});
   
   }
        
   function alertCorrecto(titulo, texto){
        Swal.fire({
    			title: titulo,
    			text: texto,
    			icon: 'success',
    		    confirmButtonText: 'Entendido'
		});
   
   
   }
        

    
        
   
        
   

})


