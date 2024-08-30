$(document).ready(function () {
    // TODO: cambiar contraseña
    //  modal
    var modal_cambiar_contrasena = $("#modal-cambiar-contraseña");
    var modal_recuperacion = $("#modal-recuperacion");
    var modal_recup_confir = $("#modal-recup-confir");
    // Obtén el botón que abre el modal
    var btn_cambiar_contrasena = $(".cambiar-contrasena");

    // Cuando el usuario hace clic en el botón, abre el modal
    btn_cambiar_contrasena.click(function () {
        modal_cambiar_contrasena.css("display", "block");
    });


    $('.recu-contra').click(function () {
        modal_recuperacion.css("display", "block")
        
    })


    $('#form-pass').submit(e => {
        let oldpass = $('#oldpass').val();
        let newpass = $('#newpass').val();
        funcion = 'cambiar_contra';
        $.post('../../controllers/usuario.php', {
            funcion,
            oldpass,
            newpass
        }, (response) => {
            console.log(response)
            response = response.trim();
            if (response == 'update') {
                $('#update').hide('slow').show(1000).delay(2000).hide(1000);
                $('#form-pass').trigger('reset');
            }else if(response == "repetida"){
                $('#noupdate').hide('slow').show(1000).delay(2000).hide(1000);
                $("#noupdate").html('<span><i class="fas fa-times m-1"></i>La nueva contraseña es igual a la contraseña actual.</span>');
                $('#form-pass').trigger('reset');
            }else if(response == "vaciopass"){
                $('#noupdate').hide('slow').show(1000).delay(2000).hide(1000);
                $("#noupdate").html('<span><i class="fas fa-times m-1"></i>Contraseña Incorrecta Vacio</span>');
                $('#form-pass').trigger('reset');
            } else {
                $('#noupdate').hide('slow').show(1000).delay(2000).hide(1000);
                $("#noupdate").html('<span><i class="fas fa-times m-1"></i>Contraseña Incorrecta</span>');
                $('#form-pass').trigger('reset');

            }


        })
        e.preventDefault();

    })


    $("#form-recuperacion").submit(e=>{
        e.preventDefault();
        var correo = $("#username-recupe").val();
        funcion = 'recuperar';
        $.post('./controllers/email.php', {
            funcion,
            correo
            
        }, (response) => {
            console.log(response);
            response = response.trim();
            if (response == 'enviarcorreo') {
                 // Mostrar mensaje de éxito y resetear el formulario
                $('#enviado').hide().show(1000).delay(5000).hide(500);
                $('#form-recuperacion').trigger('reset');
                $("#modal-recuperacion").hide(1000);
                $("#modal-recup-confir").show();
                $("#correo-usu").val(correo);

            } else {
                $('#noenviado').hide('slow');
                $('#noenviado').show(1000);
                $('#noenviado').hide(5000);
                // $('#form-recuperacion').trigger('reset');

            }


        })

    })


    $("#form-recup-confir").submit(e => {
        e.preventDefault();
        // Get form values
        var correo = $("#correo-usu").val();
        var cod_recup = $("#cod-recup").val();
        var nuevo_pass = $("#pass-nu").val();
        funcion = "recuperar_contra"
        // Post the data to the server
        $.post('./controllers/email.php', {
            funcion: funcion,
            correo: correo,
            cod_recup: cod_recup,
            nuevo_pass: nuevo_pass
        })
        .done(response => {
            // Handle successful response
            // console.log("Success:", response);
            response = response.trim();
            if (response == 'codvalido') {
                 // Mostrar mensaje de éxito y resetear el formulario
                $('#update').hide().show(1000).delay(5000).hide(500);
                $('#form-recup-confir').trigger('reset');

            } else {
                $('#noupdate').hide().show(1000).delay(5000).hide(500);
                
                
            }
        })
        .fail((xhr, status, error) => {
            // Handle errors
            // console.error("Error:", status, error);
            // You can add code to show an error message to the user here
        });
    });
    


    $('#toggle-password').click(function() {
        var passwordInput = $('#pass-nu');
        var toggleIcon = $(this);

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        } else {
            passwordInput.attr('type', 'password');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        }
    });





    var cerrar = $(".close");
    cerrar.click(function () {
        // cerrar modal de usuario <span> (x)
        if (modal_cambiar_contrasena.length) {
            modal_cambiar_contrasena.css("display", "none");
        }
        if(modal_recuperacion.length){
            modal_recuperacion.css("display", "none");
        }
        if(modal_recup_confir.length){
            modal_recup_confir.css("display", "none");
        }
        

    })


    $(window).click(function (event) {

        if (event.target === modal_cambiar_contrasena[0]) {
            modal_cambiar_contrasena.css("display", "none");
        }
    })

    
})