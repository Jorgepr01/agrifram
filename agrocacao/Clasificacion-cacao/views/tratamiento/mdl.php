<!-- Modal Editar-->
<div class="modal fade" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-full max-w-4xl mx-auto bg-white rounded-lg shadow-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Editar Tratamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <input type="hidden" id="id_st" name="id_st"> <!-- Campo oculto para almacenar el ID -->
		<form>
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
            <input type="text" id="nombre" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Aplicar</span>
            <textarea id="aplicar" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
          </div>

          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Dosis</span>
            <textarea id="dosis" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
          </div>
                
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Tiempo</span>
            <textarea id="tiempo" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
          </div>
                
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Aplicacion</span>
            <textarea id="aplicacion" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
          </div>
                
          <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Medida de Manejo</span>
            <textarea id="med_mane" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"></textarea>
          </div>
                
                
                
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarCambiosBtn">Guardar</button>
      </div>
      
    </div>
  </div>