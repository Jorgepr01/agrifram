<!-- modal de cambiar contraseña -->
<div id="modal-recuperacion" class="modal-propio">
    <div class="modal-content-propio">
        <span class="close">&times;</span>
        <h4 class="titulo-modal">RECUPERAR CONTRASEÑA</h1>
            <!-- alert de crear usuario -->
            <div class="stylo-alerta-confirmacion" id="enviado" style='display:none;'>
                <span><i class="fas fa-check"></i>Se ha enviado un código a tu correo electrónico</span>
            </div>
            <div class="stylo-alerta-rechazo" id="noenviado" style='display:none;'>
                <span><i class="fas fa-times m-1"></i>Usuario no encontrado o información incorrecta</span>
            </div>
            <!-- form de cambiar contraseña -->
            <form id="form-recuperacion">
                <!-- user name -->
                <div class="form-group-propio">
                    <label for="username-recupe" class="lbl-recu"><i class="fa-solid fa-user"></i> Usuario</label>
                    <input type="text" class="txt-recupe" placeholder="Ingresar usuario" id="username-recupe" name="usuario" required>
                </div>
                

                <div class="button-container">
                    <!-- botones cerrar y guardar -->
                    <button type="submit" class="btn-recupe">Enviar</button>

                </div>
            </form>


    </div>
</div>


<div id="modal-recup-confir" class="modal-propio">
    <div class="modal-content-propio">
        <span class="close">&times;</span>
        <input type="hidden" id="correo-usu">
        <h4 class="titulo-modal">RECUPERAR CONTRASEÑA</h1>
            <!-- alert de crear usuario -->
            <div class="stylo-alerta-confirmacion" id="update" style='display:none;'>
                <span><i class="fas fa-check"></i>Cambio de Contraseña</span>
            </div>
            <div class="stylo-alerta-rechazo" id="noupdate" style='display:none;'>
                <span><i class="fas fa-times m-1"></i>Código inválido</span>
            </div>
            <!-- form de cambiar contraseña -->
            <form id="form-recup-confir">
                <!-- codigo -->
                <div class="form-group-propio">
                    <label for="cod-recup" class="lbl-recu"><i class="fa-solid fa-user"></i>Código de verificación</label>
                    <input type="text" class="txt-recupe" placeholder="Ingresar Codigo" id="cod-recup" name="cod-recup" required>
                </div>

                <div class="form-group-contra-propio">
                    <label for="pass-nu" class="lbl-contra"><i class="fas fa-lock"></i>Contraseña nueva</label>
                    <input type="password" class="txt-contra" placeholder="Ingresar Contraseña Nueva" id="pass-nu" name="pass-nu" required>
                    <i class="toggle-icon-contra fas fa-eye-slash" id="toggle-password"></i>
                </div>
                

                <div class="button-container">
                    <!-- botones cerrar y guardar -->
                    <button type="submit" class="btn-recupe">Guardar</button>

                </div>
            </form>


    </div>
</div>