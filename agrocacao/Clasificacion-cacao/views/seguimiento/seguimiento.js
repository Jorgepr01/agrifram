$(document).ready(function() {
    var template = "";
    var table = $('#example').DataTable({
    "ajax": {
        "url": "../../controllers/seguimiento.php",
        "dataSrc": "data" // Asegúrate de que apunta a la clave correcta
    },
    "columns": [
        { "data": "id_escaneo" },
        { "data": "nombre_estado_cacao_escaneo" },
        { "data": "nombre_lote" },
        { "data": "escaneo" },
        {
            "data": "estado_cacao_escaneo",
            "orderable": false,
            "render": function(data, type, row) {
                if (data == "cacao_sano") {
                    return '<label>Sano</label>';
                } else if (data == 1) {
                    return '<label>Sano</label>';
                } else if (data == 2 || data == 3) {
                    return '<label style="color:red;">Infectado</label>';
                } else {
                    return '<label>Desconocido</label>'; // Para cualquier otro valor de estado_escaneo
                }
            }
        },
        { "data": "fecha_escaneo" },
        { "data": "porcentaje_escaneo" },
        {
            "data": "imgen_escaneo",
            "render": function(data, type, row) {
                return '<img src="../../uploads/cacao/' + data + '" alt="Imagen" style="width:60px;height:50px;border-radius:30px;"/>';
            }
        },
        { "data": "nombre_estado_cacao_trazabilidad" },
        {
            "data": "estado_cacao_trazabilidad",
            "orderable": false,
            "render": function(data, type, row) {
                if (data == 1) {
                    return '<label>Sano</label>';
                } else if (data == 2 || data == 3) {
                    return '<label style="color:red;">Infectado</label>';
                } else {
                    return '<label></label>';
                }
            }
        },
        { "data": "fecha_trazabilidad" },
        { "data": "porcentaje_trazabilidad" },
        {
            "data": "imagen_trazabilidad",
            "render": function(data, type, row) {
                console.log("Valor de data:", data); // Imprime el valor de data en la consola
                if (data === null || data === "null" || data === "") {
                    return '<label></label>'; // Retorna una etiqueta vacía si data está vacío
                } else {
                    // Retorna un elemento <img> con la ruta basada en el valor de data
                    return '<img src="../../uploads/cacao/' + data + '" alt="Imagen" style="width:60px;height:50px;border-radius:30px;"/>';
                }
            }
        },
        { "data": "observacion" },
        {
            "data": null,
            "orderable": false,
            "render": function(data, type, row) {
                return '<button class="btn-action" data-id="' + row.id_escaneo + '" style="margin-right: 5px; color:green"><i class="fa fa-leaf"></i></button>' +
                       '<button class="delete-btn" data-id="' + row.id_escaneo + '" style="margin-right: 5px; color:red"><i class="fa fa-trash"></i></button>';
            }
        }
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
    },
    //Usar initComplete de DataTables
    "initComplete": function(settings, json) {
        console.log(json); // Verifica los datos aquí para asegurarte de que 'nombre_estado_cacao_trazabilidad' está presente
    }
	});


	//$('#example').on('xhr.dt', function(e, settings, json, xhr) {
    	//console.log('Petición Ajax completada. Datos:', json);
	//});

	var id_escaneo
    // Manejar el evento click del botón usando jQuery
    $('#example tbody').on('click', '.btn-action', function() {
        //handleButtonClick(id_escaneo);
         id_escaneo = $(this).data('id');
        // Mostrar el m1odal
        $('#myModal').modal('show');
            
    });
        
    //editar
    $('#example tbody').on('click', '.edit-btn', function() {
        //handleButtonClick(id_escaneo);
         id_escaneo = $(this).data('id');
         console.log(id_escaneo);
        $("#myModalEditar").modal('show');
            
    });
        
   //eliminar
   $('#example tbody').on('click', '.delete-btn', function() {
       //handleButtonClick(id_escaneo);
       var funcion = "delete"
       id_escaneo = $(this).data('id');
        console.log(id_escaneo);
        Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, bórralo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('../../controllers/usuario.php',
                      {
                      funcion,
          			  id_escaneo,
                    }, (response) => {
          				
                    	if(response == "delete"){
                            table.ajax.reload(null, false);
                            Swal.fire({
    								title: '¡Borrado!',
    								text: 'Tu archivo ha sido borrado.',
    								icon: 'success',
    								confirmButtonText: 'Entendido'
							});
                       	}
                    
                    
                    })
                   
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
    							title: 'Cancelado',
    							text: 'Tu archivo está seguro',
    							icon: 'error',
    							confirmButtonText: 'Entendido'
							});
                }
            })
          
   })

    // Función de JavaScript para manejar el click del botón
    //function handleButtonClick(id_escaneo) {
        // Aquí puedes agregar la lógica que deseas ejecutar al hacer clic en el botón
        //alert('Button clicked for id_escaneo: ' + id_escaneo);
    //}
        
   // Ejecutar funciones cuando el modal se muestra completamente
	$('#myModal').on('shown.bs.modal', function () {
       console.log(id_escaneo)
	   const URL = 'https://teachablemachine.withgoogle.com/models/60UzVx4Sm/';
	   let model, webcam, labelContainer, maxPredictions, img, stopLoop, imagennn, camara;
	   let classMaster = null;
	   const btncompra = document.getElementById('enviarData');
	   btncompra.disabled = true;
	   const load = document.getElementById("loading");
	   const overlay = document.getElementById("overlay");
       load.style.visibility = "hidden";
       overlay.style.visibility = "hidden";
	   //console.log("a")
                // let selectedLoteId = null;

        // fetch('http://agrocacao.medianewsonline.com/agrocacao/Clasificacion-cacao/controllers/lote.php', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/x-www-form-urlencoded',
        //     },
        //     body: 'funcion=datos_lote_select'
        // })
        // .then(response => {
        //     if (!response.ok) {
        //         throw new Error('Network response was not ok ' + response.statusText);
        //     }
        //     return response.json();
        // })
        // .then(data => {
        //     console.log("data received:", data);
        //     const select = document.getElementById('loteSelect');
        //     if (!select) {
        //         console.error('Element with ID loteSelect not found');
        //         return;
        //     }
        //     data.data.forEach(lote => {
        //         const option = document.createElement('option');
        //         option.value = lote.id_lote;
        //         option.textContent = lote.nombre;
        //         select.appendChild(option);
        //     });

        //     select.addEventListener('change', function() {
        //         const selectedOption = select.options[select.selectedIndex];
        //         selectedLoteId = selectedOption.value;
        //         console.log('Lote seleccionado: ' + selectedOption.textContent + ' (ID: ' + selectedLoteId + ')');
        //     });
        // })
        // .catch(error => console.error('Error:', error));
        
        
        
		camara = document.getElementById("webcam-container");

		const inputImg = document.getElementById("file-upload");
		inputImg.addEventListener('change', ModelFile); // leer el file

        // Cuando presiono el botón abrir webcam en HTML, me hace que funcione esta función
        async function init() {
          //console.log("a")
        img = document.getElementById("preview-image");
        if (!camara || !camara.hasChildNodes()) {
        stopLoop = false;
        const modelURL = URL + "model.json";
        const metadataURL = URL + "metadata.json";
        model = await tmImage.load(modelURL, metadataURL);
        maxPredictions = model.getTotalClasses();
        
        // Configurar la webcam
        const flip = true; // si se debe voltear la webcam
        webcam = new tmImage.Webcam(520, 450, flip); // ancho, alto, flip
        await webcam.setup(); // solicitar acceso a la webcam
        await webcam.play();
        window.requestAnimationFrame(loop);
        // añadir elementos al DOM
        camara.appendChild(webcam.canvas);
        img.style.display = "none";
        camara.style.display = "flex";
        labelContainer = document.getElementById("label-container");
        labelContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos elementos
        for (let i = 0; i < maxPredictions; i++) { // y etiquetas de clase
            labelContainer.appendChild(document.createElement("div"));
        }
    } else {
        img.style.display = "flex";
        while (camara.firstChild) {
            img.src = "./DefaulFinal.png";
            camara.removeChild(camara.firstChild);
            camara.style.display = "none";
            webcam.stop();
        }
    }
	}

	// Actualiza la webcam continuamente
	async function loop() {
    	webcam.update(); // actualizar el fotograma de la webcam
    	await predict(webcam.canvas);
    	if (!stopLoop) {
        	window.requestAnimationFrame(loop);
    	}
	}

        async function ModelFile() {

                var file = this.files;

                if(file.length>0){
                        overlay.style.visibility  = "visible"
                        load.style.visibility  = "visible"
                        imagennn=document.getElementById("preview-image")
                        imagennn.style.display = "flex";
                        if (camara.hasChildNodes()){
                                webcam.stop()
                                camara.removeChild(camara.firstChild);
                        }
                        stopLoop = true; 
                        document.getElementById("webcam-container").style.display = "none";
                        if (file[0]) {
                                var reader = new FileReader();
                                reader.onload = function(event) {
                                        imagennn.setAttribute('src', event.target.result);
                                        imagennn.style.display = "block";
                                };
                                reader.readAsDataURL(file[0]);
                        } else {
                                document.getElementById('preview-image').setAttribute('src', '#');
                        }
                        const modelURL = URL + "model.json";
                        const metadataURL = URL + "metadata.json";
                        model = await tmImage.load(modelURL, metadataURL);
                        maxPredictions = model.getTotalClasses();
                        document.getElementById("ContDeteccion").style.display = "grid";
                        labelContainer = document.getElementById("label-container");
                        for (let i = 0; i < maxPredictions; i++) { // and class labels
                                labelContainer.appendChild(document.createElement("div"));
                        }
                        predict(imagennn);

                }else{
                        // Swal.fire({
                        //     position: "center",
                        //     icon: "error",
                        //     title: "Oops...",
                        //     text: "Tienes que subir un archivo...",
                        //     showCloseButton:true,
                        //     timer: 4500
                        //   });
                        Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Tienes que subir un archivo...",
                                showConfirmButton: false,
                                showCloseButton:true,
                                timer: 2000
                        });
                        return
                }
                overlay.style.visibility  = "hidden"
                load.style.visibility  = "hidden"
        }


        async function getDatosLote(classMaster,id_estado) {
            const response = await fetch('http://agrocacao.medianewsonline.com/agrocacao/Clasificacion-cacao/controllers/tratamiento.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'funcion': 'un_estado_cacao',
                    'estado_id': id_estado
                })
            });

            if (response.ok) {
                const data = await response.json();
                return data;
            } else {
                throw new Error('Error al obtener datos del lote');
            }
        }
        
        

		let probabilityMax;
		const classMax = document.createElement("span");

		async function predict(imgagess) {
		// predict can take in an image, video or canvas html element
            const prediction = await model.predict(imgagess);
            probabilityMax =0
            for (let i = 0; i < maxPredictions; i++) {
                clase=prediction[i].className
                probabilidad = prediction[i].probability
                if (probabilidad>=probabilityMax){
                    probabilityMax=probabilidad
                    classMaster=clase
                }
                //const classPrediction = clase + ": " + probabilidad.toFixed(2);
                //labelContainer.childNodes[i].innerHTML = classPrediction;
            }

 				const classPrediction = classMaster + ": " + (probabilityMax*100).toFixed(2) + "%"
                labelContainer.innerHTML = classPrediction


            let descripcionElemento = document.getElementById("descripcionImagen");
            let descripcionTitle = document.getElementById("descripccion");


            let des_nombreEscaneo = document.getElementById("des_nombreEscaneo");
            let des_medidasDeManejo = document.getElementById("des_medidasDeManejo");
            let listaUl = document.getElementById('lista_manejo');
            let des_apl_titulo = document.getElementById("des_apl_titulo");
            let des_aplaplicar = document.getElementById("des_aplaplicar");
            let des_apldosis = document.getElementById("des_apldosis");
            let des_apltiempo = document.getElementById("des_apltiempo");
            let des_aplaplicacion = document.getElementById("des_aplaplicacion");
            descripcionTitle.innerHTML="";
            descripcionElemento.innerHTML="";

            des_nombreEscaneo.innerHTML = '';
            des_medidasDeManejo.innerHTML = '';
            listaUl.innerHTML = '';
            des_apl_titulo.innerHTML = '';
            des_aplaplicar.innerHTML = '';
            des_apldosis.innerHTML = '';
            des_apltiempo.innerHTML = '';
            des_aplaplicacion.innerHTML = '';
            
            
            // si deteta una imagen no identificaca por el modelo te sale el mensaje de error
            if (classMaster=="No identificado"){
                if (camara.hasChildNodes()){
                    // webcam.stop()
                    // camara.removeChild(camara.firstChild);
                    // stopLoop = true;
                    des_nombreEscaneo.innerHTML = "No se pudo identificar la imagen";
                    return
                }else{
                    btncompra.disabled = true; 
                    // descripcionTitle.innerHTML = "No se pudo identificar la imagen";
                    des_nombreEscaneo.innerHTML = "No se pudo identificar la imagen";
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Oops...",
                        text: "Imagen no identificada por el modelo",
                        showConfirmButton: false,
                        showCloseButton:true,
                        timer: 2000
                    });
                    return
                }
            }
            let id_estado;
            if (classMaster == "Fitoftora_fase_1_Colonización") {
                id_estado = 2;
            } else if (classMaster == "Fitoftora_fase_2_Reproducción") {
                id_estado = 3;
            }else if (classMaster == "Sano") {
                id_estado = 1;
            } else {
                return;
            }
            const datosdescription = await getDatosLote(classMaster,id_estado);
            console.log(datosdescription.data[0]);
            manejo=datosdescription.data[0].medida_manejo;
            // Separar el string en un array
            
            
                
                if (manejo){
                        let items = manejo.split(',');
                        items.forEach(item => {
                                let li = document.createElement('li');
                                li.textContent = `-${item}`;
                                listaUl.appendChild(li);
                        });
                }
                else{
                	listaUl.innerHTML = 'No hay Medidas de manejo'
                }
            // Recorrer el array y crear elementos li




            // descripcionElemento.innerHTML = datosdescription.data[0].aplicar;
            // classMax.innerHTML=datosdescription.data[0].nombre;
            des_nombreEscaneo.innerHTML=datosdescription.data[0].nombre;
            des_medidasDeManejo.innerHTML = 'Medidas de manejo'
            des_apl_titulo.innerHTML = 'Tratamiento de fungicidas para aplicar en los cultivos de cacao';
            des_aplaplicar.innerHTML = '<strong>Aplicar:</strong>'+datosdescription.data[0].aplicar;
            des_apldosis.innerHTML = '<strong>Dosis:</strong>'+datosdescription.data[0].dosis;
            des_apltiempo.innerHTML = '<strong>Tiempo:</strong>'+datosdescription.data[0].tiempo;
            des_aplaplicacion.innerHTML = '<strong>Aplicación:</strong>'+datosdescription.data[0].aplicacion;
            // descripcionTitle.appendChild(classMax)
            // des_nombreEscaneo.appendChild(classMax)
            btncompra.disabled = false; 
            
	}

	function enviar() {
       
    	btncompra.disabled = true;
		//console.log("a");
    	let fileInput = document.getElementById('file-upload');
    	var nombre = document.getElementById('nombreEscaneo').value;
    	let file = fileInput.files[0];
    	probabilityMax *= 100;
    
    	let formData = new FormData();
    	formData.append("fileToUpload", file); // Asegúrate de enviar el archivo de la imagen
    	formData.append('funcion', 'subir_imagen_seguimiento');
    	formData.append('estado', classMaster);
    	formData.append('porcentaje', probabilityMax);
    	formData.append('observacion', nombre);
    	formData.append('seguiminiento', id_escaneo);//id escaneo
        
    	$.ajax({
    	url: '../../controllers/usuario.php', // Reemplaza con la ruta correcta de tu script PHP
    	type: "POST",
    	data: formData,
    	processData: false, // Evita que jQuery procese los datos
    	contentType: false, // Evita que jQuery configure el tipo de contenido
    	cache: false, // Evita el almacenamiento en caché de la solicitud
    	success: function (data) {
        	// Mostrar mensaje de éxito
        	Swal.fire({
            	position: "center",
            	icon: "success",
            	title: "La imagen ha sido subida",
            	showConfirmButton: false,
            	timer: 1500
        	});

        	// Recargar la tabla
        	table.ajax.reload(null, false);
    	},
    	error: function (xhr, status, error) {
        	// Manejar errores
        	console.error("Error al subir la imagen:", error);
        	Swal.fire({
            	position: "center",
            	icon: "error",
            	title: "Error al subir la imagen",
            	showConfirmButton: true
        	});
    	}
		});

		}


            $('#enviarData').click(function() {
                enviar();
                
            });
             $('#cam').click(function() {
                init();
            });

});

});




