<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Crear Lote</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="myModalForm">
          <input type="hidden" id="id_lote" name="id_lote"> <!-- Campo oculto para almacenar el ID -->
          <input type="hidden" id="accion" name="accion" value="crear_lote">
          
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
            <input type="text" id="nombre" name="nombre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            
          </div>
		  <div id="nombre-error"class="stylo-alerta-rechazo" style='display:none;'></div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Descripción</span>
            <textarea id="des" name="descripcion" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
            
          </div>
                
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Latitud</span>
            <input type="text" id="latitud" name="latitud" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"> 
            
          </div>
                
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Longitud</span>
            <input type="text" id="longitud" name="longitud" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"> 
            
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="guardarCambiosBtn">Guardar</button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>