<div class="modal modal-message fade" id="mdlmnt">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mdltitulo"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="mnt_form" method="POST">
                <input type="hidden" id="accion" name="accion" value="guardar">
                <!-- alert-->
                <div class="stylo-alerta-confirmacion" id="exito" style="display:none">
                    <span id="alert-exito"></span>
                </div>
                <div class="stylo-alerta-rechazo" id="noexito" style="display:none">
                    <span id="alert-error"></span>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <div class="form-group">
                            <label for="nombre-usu">
                                <span>*<i class="fas fa-user"></i> NOMBRES</span>
                            </label>
                            <input id="nombre-usu" type="text" class="form-control" name="nombre-usu" placeholder="Ingrese Nombres" required>
                        </div>
                        <div class="stylo-alerta-rechazo" id="nombre" style='display:none;'>
                            
                        </div>

                        <div class="form-group">
                            <label for="apellido-usu">
                                <span>*<i class="fas fa-user"></i> APELLIDOS</span>
                            </label>
                            <input id="apellido-usu" type="text" class="form-control" name="apellido-usu" placeholder="Ingrese Apellidos" required>

                        </div>
                        <div class="stylo-alerta-rechazo" id="apellido" style='display:none;'>
                            
                        </div> 

                        
                        <div class="form-group">
                            <label for="fecha-nacimiento">
                                <span>*<i class="fas fa-calendar-alt"></i> FECHA DE NACIMIENTO</span>
                            </label>
                            <input id="fecha-nacimiento" type="Date" class="form-control" name="fecha-nacimiento" pattern="\d{2}/\d{2}/\d{4}" required>
                        </div>
                        <div class="stylo-alerta-rechazo" id="fecha-naci" style='display:none;'>
              
                        </div>
                        
                        <div class="form-group">
                            <label for="ci">
                                <span>*<i class="fas fa-lg fa-id-card"></i> C.I</span>
                            </label>
                            <input id="ci" type="number" class="form-control" name="ci" placeholder="Ingrese Numero de Cedula" required>
                        </div>

                        <div class="stylo-alerta-rechazo" id="cedu" style='display:none;'>
                            
                        </div>
                        
                        <div class="form-group">
                            <label for="telefono">
                                <span><i class="fas fa-phone"></i> TELÉFONO</span>
                            </label>
                            <input id="telefono" type="number" class="form-control" name="telefono" placeholder="Ingrese Numero de Telefono" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="correo">
                                <span>*<i class="fas fa-at"></i> CORREO</span>
                            </label>
                            <input id="correo" type="email" name="correo" class="form-control" placeholder="Ingresar Correo" required>
                        </div>
                            <div class="stylo-alerta-rechazo" id="error-correo" style='display:none;'></div>
                         
                        <div class="form-group">
                            <label for="contrasena">
                                <span>*<i class="fas fa-lock"></i> CONTRASEÑA</span>
                            </label>
                            <input id="contrasena" data-toggle="password" data-placement="after" class="form-control" type="password" placeholder="Ingresar Contraseña">
                        </div>
                        <div class="stylo-alerta-rechazo" id="password" style='display:none;'>
                            
                        </div>
                        
                        <select class="form-control" id="select-tipo">  
                            <option value="" selected="">Tipo de Usuario</option>
                            <option value="1">Administrador</option>
                            <option value="2">Agricultor</option>
                        </select> 
                        <div class="stylo-alerta-rechazo" id="tipo-usuario" style='display:none;'>
                            <span><i class="fas fa-times m-1"></i>Seleccione Tipo de usuario</span>
                        </div>

                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" value="add" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>