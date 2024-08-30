// Asegúrate de que jQuery esté cargado
$(document).ready(function() {
        
       
        
        
    selc_ini();
    cargar_tablat();    
   	deteccionLote();
    avanceEnfermedad();
    
        
        
    function selc_ini(){
    	$.ajax({
        	url: '../../controllers/reporte.php',
        	type: 'POST',
        	data: {
            	funcion: 'datos_lote'
        	},
        	dataType: 'json',
        	success: function(response) {
            	const selectLote = $('#loteSelect');
            	selectLote.empty(); // Limpiar opciones anteriores
            	// Agregar opción predeterminada
        		const defaultOption = $('<option></option>')
            	.val('')
            	.text('Seleccione Lote');
        		selectLote.append(defaultOption);
            
            	response.data.forEach(function(lote) {
                	const option = $('<option></option>')
                    .val(lote.id_lote)
                    .text(lote.nombre);
                	selectLote.append(option);
            	});
        	},
        	error: function(xhr, status, error) {
            	console.error('Error:', error);
        	}
    	}); 
    }
        
        
    function cargar_tablat(lote_id = "", nombre = "") {
    	const funcion = "cargar_tabla";
    	$.post('../../controllers/reporte.php', {funcion, lote_id, nombre}, (response) => {
        	try {
            	const tabla_cargar = JSON.parse(response);
            	//console.log(tabla_cargar);

            	// Destruir instancia existente de DataTable si existe
            	if ($.fn.DataTable.isDataTable('#tabladata')) {
                	$('#tabladata').DataTable().clear().destroy();
            	}

            	// Inicializar nueva instancia de DataTable
            	$('#tabladata').DataTable({
                	data: tabla_cargar,
                	columns: [
                    	{data: 'nombre_lote', title: 'Lote'},
                    	{data: 'escaneo', title: 'Nombre'},
                    	{data: 'fecha_escaneo', title: 'Fecha Inicial'},
                    	{
                        	data: 'estado_cacao_escaneo',
                        	orderable: false,
                        	render: function(data, type, row) {
                            	if (data == "cacao_sano" || data == 1) {
                                	return '<label>Sano</label>';
                            	} else if (data == 2 || data == 3) {
                                	return '<label style="color:red;">Infectado</label>';
                            	} else {
                                	return '<label>Desconocido</label>';
                            	}
                        },
                        	title: 'Estado'
                    	},
                    	{data: 'porcentaje_escaneo', title: 'Porcentaje Actual'},
                    	{data: 'observacion', title: 'Observación de Seguimiento'},
                    	{data: 'fecha_trazabilidad', title: 'Fecha de seguimiento'},
                    	{
                        	data: 'estado_cacao_trazabilidad',
                        	orderable: false,
                        	render: function(data, type, row) {
                            if (data == 1) {
                                return '<label>Sano</label>';
                            } else if (data == 2 || data == 3) {
                                return '<label style="color:red;">Infectado</label>';
                            } else {
                                return '<label></label>';
                            }
                        },
                        	title: 'Estado de actual'
                    	},
                    	{data: 'porcentaje_trazabilidad', title: 'Porcentaje actual'}
                ],
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sInfoPostFix: "",
                    sSearch: "Buscar:",
                    sUrl: "",
                    sInfoThousands: ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior"
                    },
                    oAria: {
                        sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                },
                searching: true,
                paging: true,
                scrollY: 150,
                ordering: false,
                select: {
                    style: 'multi',
                    items: 'row'
                },
                responsive: true,
                pageLength: 10,
                dom: 'Bfrtilp',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        titleAttr: 'Exportar a Excel',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: 'Imprimir',
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i>',
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger'
                    }
                ]
            });
        } catch (e) {
            console.error("Error al parsear el JSON:", e);
            console.error("Respuesta del servidor:", response);
        }
    });
	}

    
     
    //chartjs    
    let myChart; // Declarar myChart en el ámbito superior
    let colorIndex = 0; // Índice para la selección de colores
    const colorPalette = generateColorPalette(); // Paleta de colores predefinida
    // Función para obtener los datos desde el backend
    function deteccionLote() {
        console.log("entro");
        $.ajax({
            url: '../../controllers/reporte.php',
            method: 'POST',
            data: { 
                funcion: 'loteEstados'
            }, // Ajusta los datos que necesitas enviar
            success: function(response) {
                // Parsear la respuesta JSON
                const data = JSON.parse(response);
                
                // Procesar los datos para Chart.js
                const labels = data.map(item => item.nombre); // Ajusta 'label' según tus datos
                const values = data.map(item => item.cantidad); // Ajusta 'value' según tus datos
                
                // Crear o actualizar el gráfico
                if (myChart) {
                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = values;
                    myChart.data.datasets[0].backgroundColor = generateColors(labels.length);
                    myChart.data.datasets[0].borderColor = generateColors(labels.length, true);
                    myChart.update();
                } else {
                    createChart(labels, values);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    }

    // Función para crear el gráfico
    function createChart(labels, values) {
        const ctx = $('#myChart')[0].getContext('2d');
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Detecciones por Lotes',
                    data: values,
                    backgroundColor: generateColors(labels.length),
                    borderColor: generateColors(labels.length, true),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function generateColors(count, border = false) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(colorPalette[colorIndex % colorPalette.length]);
            colorIndex++; // Incrementar el índice para el próximo color
        }
        return colors;
    }

    function generateColorPalette() {
        // Paleta de colores predefinida
        return [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)',
            'rgba(83, 102, 255, 0.2)',
            'rgba(122, 255, 98, 0.2)',
            'rgba(255, 82, 82, 0.2)'
        ];
    }
        
    let myChartAvanceEnfermedad = null; // Variable global para almacenar la referencia al gráfico
	
        
    function avanceEnfermedad(selectedEscaneo = "") {
    $.ajax({
        url: '../../controllers/reporte.php',
        method: 'POST',
        data: { 
            funcion: 'avanceEnfermedad',
            selectedEscaneo: selectedEscaneo,
        },
        success: function(response) {
            try {
                const data = JSON.parse(response);

                // Verifica si hay datos
                if (!Array.isArray(data) || data.length === 0) {
                    console.error('No se encontraron datos o la respuesta no es un array.');
                    return;
                }

                // Crear un conjunto de todas las fechas únicas
                const allDatesSet = new Set();
                data.forEach(item => allDatesSet.add(item.fecha));
                const allDatesArray = Array.from(allDatesSet).sort();

                // Agrupar datos por `id_escaneo`
                const escaneos = {};
                data.forEach(item => {
                    const escaneoId = item.id_escaneo;
                    if (!escaneos[escaneoId]) {
                        escaneos[escaneoId] = {
                            fechas: new Array(allDatesArray.length).fill(null),
                            porcentajes: new Array(allDatesArray.length).fill(null),
                            nombre_estado: new Array(allDatesArray.length).fill(null)
                        };
                    }
                    const dateIndex = allDatesArray.indexOf(item.fecha);
                    escaneos[escaneoId].fechas[dateIndex] = item.fecha;
                    escaneos[escaneoId].porcentajes[dateIndex] = item.porcentaje;
                    escaneos[escaneoId].nombre_estado[dateIndex] = item.nombre_estado;
                });
                    
                console.log(escaneos)

                const ctx = $('#myChartAvanceEnfermedad')[0].getContext('2d');

                // Si ya existe un gráfico, destruirlo antes de crear uno nuevo
                if (myChartAvanceEnfermedad) {
                    myChartAvanceEnfermedad.destroy();
                }

                const datasets = Object.keys(escaneos).map(escaneoId => ({
                    label: `Escaneo ID ${escaneoId}`,
                    data: escaneos[escaneoId].porcentajes,
                    borderColor: getRandomColor(),
                    borderWidth: 2, // Grosor de la línea
                    fill: false,
                    tension: 0.1, // Suavizar las líneas (0 para líneas rectas)
                    pointBackgroundColor: getRandomColor(), // Color del fondo de los puntos
                    pointBorderColor: getRandomColor(), // Color del borde de los puntos
                    pointRadius: 5, // Tamaño de los puntos
                    pointHoverRadius: 7, // Tamaño de los puntos al hacer hover
                    datalabels: {
                        align: 'center', // Posición de la etiqueta
                        anchor: 'center', // Ancla de la etiqueta
                        formatter: (value, context) => {
                            const index = context.dataIndex;
                            return escaneos[escaneoId].nombre_estado[index];
                        },
                        font: {
        					size: 10 // Reduce el tamaño de la fuente
    					}
                    }
                }));

               myChartAvanceEnfermedad = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: allDatesArray,
                        datasets: datasets
                    },
                    options: {
    layout: {
        padding: {
            top: 20,
            bottom: 20,
            left: 20,
            right: 20
        }
    },
    plugins: {
        datalabels: {
            align: 'top',
            anchor: 'end',
            formatter: (value, context) => {
                const index = context.dataIndex;
                return escaneos[escaneoId].nombre_estado[index];
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Porcentaje de Enfermedad'
            }
        },
        x: {
            title: {
                display: true,
                text: 'Fecha de Seguimiento'
            }
        }
    }
},

                    plugins: [ChartDataLabels] // Asegúrate de incluir el plugin
                });
            } catch (error) {
                console.error('Error al procesar la respuesta o al crear el gráfico:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', status, error);
        }
    });
}

// Función para generar un color aleatorio en formato RGB
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}




        
        
        
    $('#loteSelect').on('change', function() {
        const selectedLoteId = $(this).val(); // Obtiene el ID del lote seleccionado
		cargar_tablat(selectedLoteId);
        //grafico(selectedLoteId)  
           
        // Asegurarse de que el elemento select para escaneos existe
        const $selectEscaneo = $('#escaneoSelect');
        if ($selectEscaneo.length) {
          $.ajax({
             url: '../../controllers/reporte.php',
             type: 'POST',
             data: {
                   funcion: 'dt_escaneo_lote',
                   lote_id: selectedLoteId
                },
               	dataType: 'json',
                success: function(data) {
                    //console.log(data)
                    var select = $('#escaneoSelect');
                    select.empty(); // Limpiar el select primero
                    select.append('<option value="">Seleccione Escaneo</option>');

                    if (data.length > 0) {
                       $.each(data, function(index, item) {
                            select.append('<option value="' + item.id_escaneo + '">' + item.escaneo + '</option>');
                       });
                    }
                },
                error: function(error) {
                    console.error('Error en la nueva solicitud:', error);
                }
            });
        } else {
            console.error('Elemento con id="escaneoSelect" no encontrado.');
        }
    
    });
        
    $("#escaneoSelect").on('change', function(){
    	//console.log("ss")
        var lote_id = $('#loteSelect').val();
    	const selectedEscaneo = $(this).val(); // Obtiene el id
		avanceEnfermedad(selectedEscaneo);
        
        
        console.log(lote_id +"--"+ selectedEscaneo)    
        cargar_tablat(lote_id, selectedEscaneo);
    
    
    })
        
     // Función para crear el gráfico
    function createChart(labels, values) {
        const ctx = $('#myChart')[0].getContext('2d');
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Detecciones por Lotes',
                    data: values,
                    backgroundColor: generateColors(labels.length),
                    borderColor: generateColors(labels.length, true),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function generateColors(count, border = false) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(colorPalette[colorIndex % colorPalette.length]);
            colorIndex++; // Incrementar el índice para el próximo color
        }
        return colors;
    }

    function generateColorPalette() {
        // Paleta de colores predefinida
        return [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)',
            'rgba(83, 102, 255, 0.2)',
            'rgba(122, 255, 98, 0.2)',
            'rgba(255, 82, 82, 0.2)'
        ];
    }
    
        
    
});



		

	

