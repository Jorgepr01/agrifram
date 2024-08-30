$(document).ready(function() {
    // Manejar el evento de envío del formulario
    $("#login").submit((e) => {
        e.preventDefault();

        let usu = $("#usuario").val();
        let contra = $("#password").val();

       

        // Llamar a la función de inicio de sesión
        login(usu, contra);
    });

    async function login(usu, contra) {
        let funcion = "login";

        try {
            let data = await fetch('./controllers/login.php', {
                method: 'post',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `funcion=${funcion}&usu=${usu}&contra=${contra}`
            });

            let response = await data.json(); // Parseamos la respuesta como JSON

            if (response.redirect) {
                // Redirige al usuario a la página correspondiente en caso de éxito
                window.location.href = response.redirect;
            } else if (response.error) {
                // Muestra un mensaje de error en caso de fallo
                alertaError(response.error);
            } else {
                // Manejar cualquier otro tipo de respuesta inesperada
                alertaError("Respuesta inesperada del servidor.");
            }
            
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un problema al intentar iniciar sesión. Por favor, inténtelo de nuevo.');
        }
    }

    function alertaError(mensaje) {
        swal({
            title: 'Error',
            text: mensaje,
            icon: 'error',
            button: {
                text: 'Entendido',
                className: 'btn btn-primary'
            }
        });
    }
});
