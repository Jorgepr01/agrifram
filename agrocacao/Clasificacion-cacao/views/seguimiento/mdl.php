<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Seguimiento de Cacao</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="flex flex-col gap-2 md:gap-4 xl:gap-6" id="Presentation">
          <div class="grid md:grid-cols-2 items-start gap-4 xl:gap-8" id="ContDeteccion">
            <div id="webcam-container" class="w-75 object-cover rounded-lg overflow-hidden border dark:border-gray-800" style="max-width: 100%;
            height: auto; margin:auto; object-fit: cover; display:none" ></div>
            <img
              alt="Image"
              class="w-70 object-cover rounded-lg overflow-hidden border dark:border-gray-800"
              height="700"
              src="./DefaulFinal.png"
              width="1050"
              style="aspect-ratio: 1050 / 700; object-fit: cover;"
              id="preview-image"
            />
            <div id="detalleseleccion" name="detalleseleccion" class="este">
        
        
        
        
        
        <!-- caja par subir el eviar y la camara :) -->
            <div class="grid gap-2">
              <h1 class="text-4xl font-bold text-gray-900 " id="descripccion"><b>Detección</b></h1>
        
              <!-- Texto de la descripccion -->
              <div id="descripcionImagen"></div>
              
                    

                    <h2 id="des_nombreEscaneo" class ="text-2xl font-semibold mb-2"></h2>
                    <h3 class="text-2xl font-semibold mb-2" id="des_medidasDeManejo"></h3>
                    <ul id="lista_manejo"></ul>
                    <div class="bg-white p-4" id="des_apl">
                            <h3 class="text-xl font-semibold mb-2" id="des_apl_titulo"></h3>
                            <p id = "des_aplaplicar"></p>
                            <p id = "des_apldosis"></p>
                            <p id = "des_apltiempo"></p>
                            <p id = "des_aplaplicacion"></p>
       </div>
        <div id="label-container"></div>
        <br/>
              <!-- Camara y File -->
              <div class="flex items-center justify-center">
                
              <!-- Subir un file -->
        
                <label
                  for="file-upload"
                  class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:hover:text-gray-950"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="mr-2 h-5 w-5"
                  >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" x2="12" y1="3" y2="15"></line>
                  </svg>
                  Subir Imagen
                </label>
                <input id="file-upload" class="sr-only" accept="image/*" type="file" />
        
                <!-- camara -->
                <button
                  type="button"
              id="cam"
                  class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="mr-2 h-5 w-5"
                  >
                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                    <circle cx="12" cy="13" r="3"></circle>
                  </svg>
                  Cámara
                </button>
              </div>
                    
                    
                <div class="input-group mb-3">
                  <span class="input-group-text" id="inputGroup-sizing-default">Observación</span>
                  <input type="text" id="nombreEscaneo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>


              </div>
        
            </div>
        
            </div>
          </div>
        </div>
        <!-- loading -->
        <div class="loading-overlay" id="overlay">
          <div class="loader lds-facebook lds-dual-ring" id="loading"></div>
        
        </div>
         <button type="button" class="btn btn-primary" id="enviarData">Enviar</button>

      </div>
      
    </div>
  </div>




<!-- Modal Editar-->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Editar Ingreso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				
        
        
        
     

      </div>
      
    </div>
  </div>
        