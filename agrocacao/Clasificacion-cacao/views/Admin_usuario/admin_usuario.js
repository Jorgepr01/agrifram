$(document).ready(function(){
  cargar_usuario();
  var funcion;
  function cargar_usuario(consulta) {
    funcion = 'buscar_usuarios';
    $.post('../../controllers/usuario.php', {
     consulta,
     funcion
    }, (response) => {
      // console.log(response);
    const usuarios = JSON.parse(response);
    let template = '';
    usuarios.forEach(usuario => {
      template += `
        <div class="card" usuarioId="${usuario.id_us}">
          <div class="card-body">
            <h1 style="background-color: #1783db; color: white; font-size: 15px; display: inline-block; border-radius: 5px;">${usuario.nombre_tipo}</h1>
            <img src="../../uploads/avatar/${usuario.avatar}">
            <h2 style="color: #0b7300; font-size: 20px; display: block; width: 100%; padding: 10px 0; text-align: center; overflow-wrap: break-word;">${usuario.nombres} ${usuario.apellidos}</b></h2>
              <ul style="text-decoration: none; list-style-type: none; display: block; width: 100%; padding: 10px 0; text-align: center; overflow-wrap: break-word;">
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-id-card" style="color: #6c757d;"></i></span> C.I: ${usuario.ci}</li>
                <li style="margin-top: 10px;"><span><i class="fas fa-lg fa-at" style="color: #6c757d;"></i></span> Correo: ${usuario.correo}</li>
                <li style="margin-top: 10px;"><span><i class="fas fa-phone" style="color: #6c757d;"></i></span> Celular: ${usuario.telefono}</li>
                
              </ul>
            </div>
            `
      if (usuario.tipo_us_id != 1) {
        template += `
            <div class="card-footer">
              <!--<button type="button" class="inline-button">
                <i class=""></i> EDITAR
              </button>-->
            `
        if (usuario.nombre_estado_us == "Habilitado") {
          template += `
                <button type="button" class="inline-button-eliminar deshabilitar-usu">
                  <i  class="fas fa-ban"></i> Deshabilitar
                </button>
                `
        }
        if (usuario.nombre_estado_us == "Deshabilitado") {
          template += `
                <button type="button" class="inline-button habilitar-usu">
                  <i class="fas fa-check-circle"></i> Habilitar
                </button>
                `
        }
        
        template += `
                <button type="button" class="inline-button-eliminar confirmar-eliminar">
                  <i class="fas fa-window-close mr-1"></i> Eliminar
                </button>
        
                `
      }


      template += `
            </div>
        </div>
            `
    });

    $('.usuarios-card').html(template);

   });
  }
        
        
   
  //TODO: BOTON DEL PANEL ACTUALIZAR
  $('#reloadButton').click(function() {
    let consulta = $("#buscar").val();
    // Llama a la función cargarContenido
    cargar_usuario(consulta);
  });

  // TODO: BTN CREAR USUARIO
  $('#btnnuevo').click(function () {
    $('#mnt_form')[0].reset();
    $('#mdltitulo').html('CREAR USUARIO');
    $("#accion").val("crear_usuario");
    $("#inst_cod").prop("readonly", false);
    $('#nombre').hide(); 
    $('#apellido').hide();
	$('#fecha-naci').hide(); 
	$('#cedu').hide();
	$('#error-correo').hide();
	$('#password').hide();
	$('#tipo-usuario').hide();
    $('#mdlmnt').modal('show');
  });


  //TODO: INSERTAR USUARIO
  $('#mnt_form').submit(function(e) {
    e.preventDefault();
    let nombre_usuario = $('#nombre-usu').val();
    let apellido_usuario = $('#apellido-usu').val();
    let fecha_nacimiento = $('#fecha-nacimiento').val();
    let ci = $('#ci').val();
    let telefono = $("#telefono").val();
    let correo = $('#correo').val();
    let contrasena = $('#contrasena').val();
    // obtener value option
    let select_tipo = $('#select-tipo').val()

    var accion = $("#accion").val()
    funcion = accion;
  
    let data = {
      funcion: funcion,
      nombre_usuario: nombre_usuario,
      apellido_usuario: apellido_usuario,
      fecha_nacimiento: fecha_nacimiento,
      ci: ci,
      telefono: telefono,
      correo: correo,
      contrasena: contrasena,
      select_tipo: select_tipo
    };
    $.post('../../controllers/usuario.php', data, function(response) {
      // console.log(response);
      response = response.trim();
      if (response.trim() === "add") {
        // Cambiar el contenido de texto dentro del span con el id "alert-exito"
        $("#alert-exito").html("<i class='fas fa-check'></i> El usuario ha sido creado con éxito.");
        // Mostrar el elemento #noexito
        $('#exito').hide().show(1000).delay(2000).hide(1000);
        $('#mnt_form').trigger('reset');
        let mensaje = "El usuario ha sido creado con éxito."
        alertaCorrecto(mensaje);
        cargar_usuario();
      } else if (response == "noadd") {
        // Cambiar el contenido de texto dentro del span con el id "alert-error"
        $("#alert-error").html("<i class='fas fa-times m-1'></i> Usuario ya Ingresado");
        // Mostrar el elemento #noexito
        $('#noexito').hide().show(1000).delay(2000).hide(1000);
      }else {
        const errores = JSON.parse(response);
        for (const clave in errores){
          const valor = errores[clave];
          // console.log(`La clave es ${clave} y el valor es ${valor}`);
          $('#'+clave).hide('slow').show(1000).delay(2000).hide(1000);
          $('#'+clave).html('<span><i class="fas fa-times m-1"></i>'+valor+'</span>');
        }
      
      }
    
    });
  });


  // cuando se tecle se ejecuta una funcion de calban
  $(document).on('keyup','#buscar',function(){
    // cojo el valor id
    let valor = $(this).val();
    if(valor != ""){
      // console.log(valor);
      cargar_usuario(valor)

    }else{
      cargar_usuario();

    }
  })

  // abrir el modal habiliar
  $(document).on("click", ".habilitar-usu", function() {
     // Obtener el div padre más cercano con la clase "card"
     var cardPadre = $(this).closest('.card');
     // Obtener el valor del atributo "usuarioId"
     var id = cardPadre.attr('usuarioId');
    //  console.log(id);
    $('#id_user').val(id);
    $("#funcion").val("habilitar-usu");
    $(".titulo-modal").html("HABILITAR USUARIO")
    $("#modal-confirmar").css("display", "block");
  });


  // abrir el modal deshabiliar
  $(document).on("click", ".deshabilitar-usu", function() {
    // Obtener el div padre más cercano con la clase "card"
    var cardPadre = $(this).closest('.card');
    // Obtener el valor del atributo "usuarioId"
    var id = cardPadre.attr('usuarioId');
    // console.log(id);
   $('#id_user').val(id);
   $("#funcion").val("deshabilitar-usu");
   $(".titulo-modal").html("DESHABILITAR USUARIO")
   $("#modal-confirmar").css("display", "block");
 });


 // abrir el modal deshabiliar
 $(document).on("click", ".confirmar-eliminar", function() {
    // Obtener el div padre más cercano con la clase "card"
    var cardPadre = $(this).closest('.card');
    // Obtener el valor del atributo "usuarioId"
    var id = cardPadre.attr('usuarioId');
  $('#id_user').val(id);
  $("#funcion").val("borrar-usuario");
  $(".titulo-modal").html("ELIMINAR USUARIO")
  $("#modal-confirmar").css("display", "block");
  });


  // confirmar
  $('#form-confirmar').submit(e => {
    let pass = $('#input-confirmar').val();
    let id_usuario = $('#id_user').val();
    funcion = $('#funcion').val();
    // console.log(pass,id_usuario,funcion)
    $.post('../../controllers/usuario.php', { pass, id_usuario, funcion }, (response) => {
        response = response.trim();
        console.log(response);
        if (response == 'habilitado') {
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Habilitado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        } else if(response == 'deshabilitado'){
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Deshabilitado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        }else if(response == 'borrado'){
              // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-exito").html("<i class='fas fa-check'></i> Eliminado con Exito");
            // Mostrar el elemento #exit
            $('.stylo-alerta-confirmacion').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
            cargar_usuario();
        }else {
            // Cambiar el contenido de texto dentro del span con el id "alert-exito"
            $(".alert-error").html("<i class='fas fa-times m-1'></i>Contraseña Incorrecta");
            // Mostrar el elemento #exit
            $('.stylo-alerta-rechazo').hide().show(1000).delay(2000).hide(1000);
            $('#form-confirmar').trigger('reset');
        }
        

    });
    e.preventDefault();
  })    


  



  //TODO: VALIDACIONES 
  //CEDULA
  $("#ci").on("input", function(e) {
    var inputValue = e.target.value;
    // Eliminar caracteres no numéricos con exprecion regulares
    inputValue = inputValue.replace(/[^\d]/g, '');
    // Validar cedula con 10 caracteres
    if (inputValue.length > 10) {
     inputValue = inputValue.slice(0, 10);
    }
    // Asignar el valor modificado de vuelta al campo de entrada
    e.target.value = inputValue;
  });

 // VALIDACION NOMBRE   
  function validacion_nombres(id) {
    $(id).on("input", function(e) {
        e.preventDefault();

        var inputValue = e.target.value;
        // Mantener solo letras, espacios, ñ y tildes en el valor del campo
        inputValue = inputValue.replace(/[^A-Za-zñÑáéíóúÁÉÍÓÚ\s]/g, '');

        // Dividir el valor en palabras
        var palabras = inputValue.split(' ');

        // Capitalizar solo la primera letra de la primera palabra
        if (palabras.length > 0) {
            palabras[0] = palabras[0].charAt(0).toUpperCase() + palabras[0].slice(1).toLowerCase();
        }

        // Capitalizar la primera letra de cada palabra (excepto la primera)
        for (var i = 1; i < palabras.length; i++) {
            palabras[i] = palabras[i].toLowerCase(); // Convertir la palabra completa a minúsculas
            palabras[i] = palabras[i].charAt(0).toUpperCase() + palabras[i].slice(1);
        }

        // Unir las palabras de nuevo con espacios
        var resultado = palabras.join(' ');

        // Asignar el valor modificado de vuelta al campo de entrada
        $(this).val(resultado);
    });
  }

  // nombre
  validacion_nombres("#nombre-usu");
  // apellido
  validacion_nombres("#apellido-usu");


  //TODO: funcionamiento de modal 
  var cerrar = $(".close");
  var modal_confirmar = $("#modal-confirmar")
  cerrar.click(function() {
    // cerrar modal de usuario <span> (x)
    if (modal_confirmar.length) {
      modal_confirmar.css("display", "none");
    }
  });

  $(window).click(function(event) {
    if (modal_confirmar.length) {
      if (event.target == modal_confirmar[0]) {
        modal_confirmar.css("display", "none");
      }
    }
  });



  //TODO:  alert 
  function alertaCorrecto(mensaje) {
    swal({
      title: 'Éxito',
      text: mensaje,
      icon: 'success',
      button: {
        text: 'Entendido',
        className: 'btn btn-primary'
      }
    });
  }
        
   //eventos de error de form
	
   //blur Event: Se dispara cuando el campo pierde el foco
   $("#nombre-usu").on('blur', function() {
       let currentValue = $(this).val();
        if (currentValue === '') {
            $('#nombre').show();
            $('#nombre').html('<span><i class="fas fa-times m-1"></i> Ingrese Nombre</span>');
              	
        }else{
            $('#nombre').hide();     
        }      
            
   })
        
   $("#apellido-usu").on('blur', function() {
       let currentValue = $(this).val();
        if (currentValue === '') {
            $('#apellido').show();
            $('#apellido').html('<span><i class="fas fa-times m-1"></i> Ingrese Apellido</span>');
              	
        }else{
            $('#apellido').hide();     
        }      
            
   })
        
   $("#fecha-nacimiento").on('blur', function() {
       let currentValue = $(this).val();
        if (currentValue === '') {
            $('#fecha-naci').show();
            $('#fecha-naci').html('<span><i class="fas fa-times m-1"></i> Ingrese Fecha de Nacimiento</span>');
              	
        }else{
            $('#fecha-naci').hide();     
        }      
            
   }) 
        
   $("#ci").on('blur', function() {
       let currentValue = $(this).val();
        if (!validarCedulaEcuatoriana(currentValue)) {
            $('#cedu').show();
            $('#cedu').html('<span><i class="fas fa-times m-1"></i> Ingrese Cedula Correcta</span>');
              	
        }else{
            $('#cedu').hide();     
        }      
            
   }) 
        
        
  function validarCedulaEcuatoriana(cedula) {
    // Verificar que la cédula tenga 10 dígitos
    if (cedula.length !== 10) {
        return false;
    }

    // Verificar que los dos primeros dígitos correspondan a una provincia válida
    var provincia = parseInt(cedula.substring(0, 2), 10);
    if (provincia < 1 || provincia > 24) {
        return false;
    }

    // Convertir la cédula en un array de caracteres (dígitos)
    var digitos = cedula.split('').map(Number);
    var suma = 0;

    // Aplicar el algoritmo de verificación
    for (var i = 0; i < 9; i++) {
        var digito = digitos[i];
        // Posiciones pares (0-indexadas) multiplicar por 2 y restar 9 si es >= 10
        if (i % 2 === 0) {
            digito *= 2;
            if (digito >= 10) {
                digito -= 9;
            }
        }
        suma += digito;
    }

    // Obtener el dígito verificador
    var verificador = digitos[9];

    // Calcular el valor que debería tener el dígito verificador
    var residuo = suma % 10;
    var digitoVerificadorCalculado = residuo === 0 ? 0 : 10 - residuo;

    // Comparar con el dígito verificador proporcionado
    return digitoVerificadorCalculado === verificador;
	}
        
        
   $("#correo").on('blur', function() {
    
    // Obtiene el valor actual del campo de entrada (el texto que el usuario ha escrito).
    let email = $(this).val();
    
    // Define una expresión regular para validar correos electrónicos.
    // La expresión regular verifica que el formato del correo sea algo@algo.dominio.
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Verifica si el campo está vacío.
    if (email === '') {
        // Si el campo está vacío, muestra un mensaje de error.
        // El mensaje es "Ingrese Correo Electrónico".
        $('#error-correo').show();
        $('#error-correo').html('<span><i class="fas fa-times m-1"></i> Ingrese Correo Electrónico</span>');
        
    // Verifica si el correo no cumple con el formato válido según la expresión regular.
    } else if (!emailRegex.test(email)) {
        // Si el correo no es válido, muestra un mensaje de error.
        // El mensaje es "Correo Electrónico Inválido".
        $('#error-correo').show();
        $('#error-correo').html('<span><i class="fas fa-times m-1"></i> Correo Electrónico Inválido</span>');
        
    } else {
        // Si el correo es válido (no está vacío y cumple con el formato),
        // oculta el mensaje de error, en caso de que esté visible.
        $('#error-correo').hide();
    }
	});
	
        
    $("#contrasena").on('blur', function() {
       let currentValue = $(this).val();
        if (currentValue === '') {
            $('#password').show();
            $('#password').html('<span><i class="fas fa-times m-1"></i> Ingrese Contraseña</span>');
              	
        }else{
            $('#password').hide();     
        }      
            
   })
   $("#select-tipo").on('change', function() {
       let currentValue = $(this).val();
        if (currentValue === '') {
            $('#tipo-usuario').show();
           
              	
        }else{
            $('#tipo-usuario').hide();     
        }      
            
   })
        
        
 

});