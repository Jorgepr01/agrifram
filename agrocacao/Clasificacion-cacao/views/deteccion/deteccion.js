        //modelo :) tm
        const URL = 'https://teachablemachine.withgoogle.com/models/60UzVx4Sm/';
        let model, webcam, labelContainer, maxPredictions,img,previewImg,stopLoop,imagennn,camara;
        let classMaster = null
        const btncompra = document.getElementById('enviarData');
        btncompra.disabled = true; 
        const load = document.getElementById("loading")
        const overlay = document.getElementById("overlay")
        load.style.visibility  = "hidden"
        overlay.style.visibility  = "hidden"
        let selectedLoteId = null;
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://agrocacao.medianewsonline.com/agrocacao/Clasificacion-cacao/controllers/lote.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'funcion=datos_lote_select' // Ajusta los parámetros según sea necesario
            })
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('loteSelect');
                data.data.forEach(lote => {
                    const option = document.createElement('option');
                    option.value = lote.id_lote;
                    option.textContent = lote.nombre;
                    select.appendChild(option);
                });

                // Añadir evento de cambio al select
                select.addEventListener('change', function() {
                    const selectedOption = select.options[select.selectedIndex];
                    selectedLoteId = selectedOption.value; // Almacena el ID del lote seleccionado
                    console.log('Lote seleccionado: ' + selectedOption.textContent + ' (ID: ' + selectedLoteId + ')');
                });
            })
            .catch(error => console.error('Error:', error));
        });
        camara=document.getElementById("webcam-container")

        // document.getElementById('avatar').addEventListener('change',ModelFile) //leer el file
        const inputImg=document.getElementById("file-upload");

        inputImg.addEventListener('change',ModelFile) //leer el file

        // Caundo presiono el abri web can en html boton me hace que funcione esta funcion
        async function init() {
            // document.getElementById("ContDeteccion").style.display = "flex";
            img=document.getElementById("preview-image")
            if (!camara.hasChildNodes()){
                stopLoop = false;
                const modelURL = URL + "model.json";
                const metadataURL = URL + "metadata.json";
                model = await tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();
                
                // Convenience function to setup a webcam
                const flip = true; // whether to flip the webcam
                webcam = new tmImage.Webcam(520, 450, flip); // width, height, flip
                await webcam.setup(); // request access to the webcam
                await webcam.play();
                window.requestAnimationFrame(loop);
                // append elements to the DOM
                camara.appendChild(webcam.canvas);
                img=document.getElementById("preview-image")
                img.style.display = "none";
                camara.style.display = "flex";
                labelContainer = document.getElementById("label-container");
                for (let i = 0; i < maxPredictions; i++) { // and class labels
                    labelContainer.appendChild(document.createElement("div"));
                }
            }else{ 
                document.getElementById("preview-image").style.display = "flex";
                while (camara.firstChild) {
                    img.src = "./DefaulFinal.png"
                    camara.removeChild(camara.firstChild);
                    camara.style.display = "none";
                    webcam.stop()
                }
            }


        }
        //actualiza el la webcam por siempre
        async function loop() {
            webcam.update(); // update the webcam frame
            await predict(webcam.canvas);
            if (!stopLoop){
                window.requestAnimationFrame(loop);
            }
        }
        async function ModelFile(){
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


        let probabilityMax
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
                //const classPrediction = clase + ": " + probabilidad.toFixed(2)*100 + "%";
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




        function enviar(){
            if (selectedLoteId == null || selectedLoteId == undefined || selectedLoteId == ""){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Oops...",
                    text: "Tienes que seleccionar un lote",
                    showConfirmButton: false,
                    showCloseButton:true,
                    timer: 2000
                });
                return
            }
            console.log(selectedLoteId)
            btncompra.disabled = true; 
            let fileInput = document.getElementById('file-upload');
            var escaneo = document.getElementById('nombreEscaneo').value;
            file=fileInput.files[0];
            probabilityMax*=100
            // var formDataI = new FormData();
            // formDataI.append("imagen", imagennn);
            // Crea un objeto FormData con el elemento de la imagen
            let formData = new FormData();
            formData.append("fileToUpload", file); // Asegúrate de enviar el archivo de la imagen
            formData.append('funcion', 'subir_imagen_analisis');
            formData.append('estado', classMaster);
            formData.append('porcentaje',probabilityMax );
            formData.append('escaneo',escaneo );//escaneo 
            formData.append('lote_id',selectedLoteId );//escaneo 

            $.ajax({
                url: '../../controllers/usuario.php', // Reemplaza con la ruta correcta de tu script PHP
                type: "POST",
                data: formData,
                processData: false, // Evita que jQuery procese los datos
                contentType: false, // Evita que jQuery configure el tipo de contenido
                cache: false, // Evita el almacenamiento en caché de la solicitud
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "La imagen a sido subida",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(data) {
                    btncompra.disabled = true;
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Oops...",
                        text: "Hubo un error al subir la imagen",
                        showConfirmButton: false,
                        showCloseButton:true,
                        timer: 2000
                    });
                }
            });

            
        }





