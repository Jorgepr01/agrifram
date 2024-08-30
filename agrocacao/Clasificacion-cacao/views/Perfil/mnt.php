<!-- modal de cambiar avatar -->
<div id="modal-cambiar-avatar" class="modal-propio">
  <div class="modal-content-propio">
  <span class="close">&times;</span>
    <h4 class="titulo-modal">CAMBIAR AVATAR</h1>
    <!-- alert de avatar -->
    <div class="stylo-alerta-confirmacion" id="edit" style='display:none;'>
      <span><i class="fas fa-check"></i>Se cambio Avatar</span>
    </div>
    <div class="stylo-alerta-rechazo" id="noedit" style='display:none;'>
      <span><i class="fas fa-times m-1"></i>Formato no soportado</span>
    </div>
    <!-- form de cambiar contraseña -->
    <form id="form-avatar" class="formulario">
      <br>
      <div class="image-upload">
        <label for="avatar" class="custom-file-upload"><i class="fas fa-cloud-upload-alt"></i> Seleccionar imagen:</label>
        <input type="file" name="avatar" id="avatar" accept="image/*" required>
      </div>
      <br>
      <p>Tamaño máximo: 2MB. Formatos permitidos: JPG, PNG, GIF.</p>

      <div class="vista-previa">
        
      </div>

      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">Guardar</button>
        <button type="button" class="inline-button-eliminar cerrar-cambiar-avatar" id="">Cerrar</button>
        
      </div>  
     </form>
    
    
  </div>
</div>