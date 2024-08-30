<div class="modal modal-message" id="mdlcarga">
  <div class="modal-dialog d-flex align-items-center justify-content-center">
    <div class="fa-3x">
      <i class="fas fa-sync fa-spin text-white"></i>
    </div>
  </div>
</div>


<!-- MODAL CONFIRMAR-->
<div id="modal-confirmar" class="modal-propio">
  <div class="modal-content-propio">
  <span class="close">&times;</span>
  <h4 class="titulo-modal"></h1>
  <div class="stylo-alerta-confirmacion" id="exito" style='display:none;'>
    <span class="alert-exito"></span>
  </div>
  <div class="stylo-alerta-rechazo" id="rechazar" style='display:none;'>
    <span class="alert-error"></span>
  </div>
    <!-- form de cambiar contraseña -->
    <form id="form-confirmar" class="formulario">
        <!-- contraseña vieja input -->
              <div class="form">
                <input type="password" class="form-control" id="input-confirmar" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> INGRESAR CONTRASEÑA</span>
		            </label>
              </div>
              <!-- para darle id usuario -->
              <input type="hidden" id="id_user">
              <input type="hidden" id="funcion">
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">ACEPTAR</button>
        
      </div> 
       
     </form>
  </div>
</div>


<!-- modal de cambiar contraseña -->
<div id="modal-cambiar-contraseña" class="modal-propio">
  <div class="modal-content-propio">
  <span class="close">&times;</span>
    <h4 class="titulo-modal">CAMBIAR CONTRASEÑA</h1>
    <!-- alert de crear usuario -->
    <div class="stylo-alerta-confirmacion" id="update" style='display:none;'>
      <span><i class="fas fa-check"></i>Cambio de Contraseña</span>
    </div>
    <div class="stylo-alerta-rechazo" id="noupdate" style='display:none;'>
      
    </div>
    <!-- form de cambiar contraseña -->
    <form id="form-pass" class="formulario">
        
        <!-- contraseña vieja input -->
              <div class="form">
                <input id="oldpass" type="password" class="form-control" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-unlock-alt"></i> Ingresar contraseña actual</span>
		            </label>
              </div>

              <div class="form">
                <input id="newpass" type="password" class="form-control" required>
		            <label class="lbl">
		  	        <span class="text-span"><i class="fas fa-lock"></i> Ingresar contraseña nueva</span>
		            </label>
              </div>
      <div class="button-container">
       <!-- botones cerrar y guardar -->
        <button type="submit" class="inline-button">Guardar</button>
        
      </div>  
     </form>
    
    
  </div>
</div>