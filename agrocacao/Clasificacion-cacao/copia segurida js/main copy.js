//modelo :) tm
const URL = 'https://teachablemachine.withgoogle.com/models/A3dOiWWUw/';
let model, webcam, labelContainer, maxPredictions,img,previewImg;
//description html
const descrition = {
    "pod_borer": "Esta es la descripción de la primera imagen. pod_borer",
    "healthy": "Esta es la descripción de la segunda imagen. healthy",
    "black_pod_rot": "Esta es la descripción de la tercera imagen. black_pod_rot"
}

document.getElementById('avatar').addEventListener('change',ModelFile) //leer el file

// Caundo presiono el abri web can en html boton me hace que funcione esta funcion
async function init() {
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";

    // load the model and metadata
    // Refer to tmImage.loadFromFiles() in the API to support files from a file picker
    // or files from your local hard drive
    // Note: the pose library adds "tmImage" object to your window (window.tmImage)
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();

    // Convenience function to setup a webcam
    const flip = true; // whether to flip the webcam
    webcam = new tmImage.Webcam(200, 200, flip); // width, height, flip
    await webcam.setup(); // request access to the webcam
    await webcam.play();
    window.requestAnimationFrame(loop);

    // append elements to the DOM
    document.getElementById("webcam-container").appendChild(webcam.canvas);
    labelContainer = document.getElementById("label-container");
    for (let i = 0; i < maxPredictions; i++) { // and class labels
        labelContainer.appendChild(document.createElement("div"));
    }
}

//actualiza el la webcam por siempre
async function loop() {
    webcam.update(); // update the webcam frame
    await predict(webcam.canvas);
    window.requestAnimationFrame(loop);
}



async function ModelFile(){
    imagennn=document.getElementById('preview-image')
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(event) {
          imagennn.setAttribute('src', event.target.result);
          imagennn.style.display = "block";
          
        };
        reader.readAsDataURL(file);
      } else {
        document.getElementById('preview-image').setAttribute('src', '#');
      }
    const modelURL = URL + "model.json";
    const metadataURL = URL + "metadata.json";
    model = await tmImage.load(modelURL, metadataURL);
    maxPredictions = model.getTotalClasses();
    labelContainer = document.getElementById("label-container");
    for (let i = 0; i < maxPredictions; i++) { // and class labels
        labelContainer.appendChild(document.createElement("div"));
    }
    await predict(imagennn);
}

// async function handleFileSelect(event) {
//     console.log("a")
//     const file = event.target.files[0];
//     const img = await loadImage(file);
//     const resizedImg = resizeImage(img, 200, 300);
//     const imgTensor = tf.browser.fromPixels(resizedImg).toFloat().expandDims();
//     const imgNormalized = imgTensor.div(255.0);

//     const prediction = await model.predict(imgNormalized);

//     console.log(prediction);
    // const modelURL = URL + "model.json";
    // const metadataURL = URL + "metadata.json";
    // model = await tmImage.load(modelURL, metadataURL);
    // maxPredictions = model.getTotalClasses();

    // reader.onload = async function(e) {
    //     console.log("a")
    //     const imgData = new Image();
    //     imgData.src = e.target.result;
    //     // const prediction = await model.predict(imgData);
    //     // console.log(prediction);
    // }

    // reader.onload = function(e) {
    //   previewImg.src = e.target.result;
    //   previewImg.style.display = 'block'; // Mostrar la imagen
    //   reader.readAsDataURL(event.target.files[0]); // Leer el archivo seleccionado como una URL de datos

    //   img = loadImage(URL.createObjectURL(event.target.files[0]), function() {
    //     });
    // };
    // console.log(img)
// }

// function loadImage(file) {
//     return new Promise((resolve, reject) => {
//         const reader = new FileReader();

//         reader.onload = function(e) {
//             const img = new Image();
//             img.onload = function() {
//                 resolve(img);
//             };
//             img.src = e.target.result;
//         };

//         reader.readAsDataURL(file);
//     });
// }

// run the webcam image through the image model
async function predict(imgagess) {

   // predict can take in an image, video or canvas html element
    const prediction = await model.predict(imgagess);
    let classMaster = null
    let probabilityMax =0
    for (let i = 0; i < maxPredictions; i++) {
        clase=prediction[i].className
        probabilidad = prediction[i].probability
        if (probabilidad>=probabilityMax){

            probabilityMax=probabilidad
            classMaster=clase
        }
        const classPrediction = clase + ": " + probabilidad.toFixed(2);
        labelContainer.childNodes[i].innerHTML = classPrediction;
    }
    
    var descripcionElemento = document.getElementById("descripcionImagen");
    descripcionElemento.innerHTML = descrition[classMaster];
}

