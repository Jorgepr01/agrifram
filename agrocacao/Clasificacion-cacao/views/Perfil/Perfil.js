$(document).ready(function () {
  var funcion = "";
  var template = '';
  dato_usuario();

  // Función para obtener y mostrar los datos del usuario
  function dato_usuario() {
    const funcion = 'dato_usuario';
    $.post('../../controllers/usuario.php', {
      funcion
    }, (response) => {
      let template = '';
      const datos = JSON.parse(response);
      const usuario = datos[0];
      template += `
      <h1 class="titulo">DATOS PERSONALES</h1>
      <div class="display-perfil">
        <div class="personal-info">
          <h2>DATOS</h2>
          <div class="image">
            <img src="../../uploads/avatar/${usuario.avatar}">
          </div>
          <ul>
            <li><b style="color:#0b7300">NOMBRES:</b> <a id="nombre"></a> ${usuario.nombres}</li>
            <li><b style="color:#0b7300">APELLIDOS:</b> <a id="apellido"></a> ${usuario.apellidos}</li>
            <li><b style="color:#0b7300">EDAD:</b> <a id="edad"></a> ${usuario.edad}</li>
            <li><b style="color:#0b7300">C.I: </b> <a id="ci"></a>${usuario.ci}</li>
            <li><b style="color:#0b7300">TELÉFONO: </b> <a id="telefono"></a>${usuario.telefono}</li>
            <li>
              <b style="color:#0b7300">TIPO DE USUARIO:</b>
              <span id="us_tipo">${usuario.nombre_tipo}</span>
            </li>
            <li><button class="inline-button btn-avatar">CAMBIAR AVATAR</button></li>
          </ul>
        </div>
        <div class="Formulario">
          <form id="act_perfil">
            <div>
              <label for="nombres">
                <span><i class="fas fa-user"></i> NOMBRES</span>
              </label>
              <input type="text" id="nombres" name="nombres" class='input-_update' value="${usuario.nombres}" required><br>
            </div>
            <div class="stylo-alerta-rechazo" id="nombre-error" style='display:none;'>
              
            </div>
            <div>
              <label for="apellidos">
                <span><i class="fas fa-user"></i> APELLIDOS</span>
              </label>
              <input type="text" id="apellidos" class='input-_update' name="apellidos" value="${usuario.apellidos}" required><br>
            </div>
            <div class="stylo-alerta-rechazo" id="apellido-arror" style='display:none;'>
              
            </div> 

            <div>
              <label for="fecha-nacimiento">
                <span><i class="fas fa-calendar-alt"></i> FECHA DE NACIMIENTO</span>
              </label>
              <input type="date" id="fecha-nacimiento" class='input-_update' name="fecha-nacimiento" value="${usuario.fecha_nacimiento}" required><br>
            </div>
            <div class="stylo-alerta-rechazo" id="fecha-naci" style='display:none;'>
              
            </div>

            <div>
              <label for="cedula">
                <span><i class="fas fa-lg fa-id-card"></i> C.I</span>
              </label>
              <input type="number" id="cedula" class='input-_update' name="cedula" value="${usuario.ci}" required><br>
            </div>
            <div class="stylo-alerta-rechazo" id="cedu" style='display:none;'>
              
            </div>

            <div>
              <label for="telefono">
                <span><i class="fas fa-phone"></i> TELÉFONO</span>
              </label>
              <input type="number" id="telefonos" class='input-_update' name="telefono" value="${usuario.telefono}" required><br>
            </div>

            <br>
            <button type="submit" class="inline-button-editar">Guardar</button>
          </form>
        </div>
      </div>
      `;
      $('#datos_personales').html(template);
            
	  
      //blur Event: Se dispara cuando el campo pierde el foco
      $("#nombres").on('blur', function() {
        let currentValue = $(this).val();
        if (currentValue === '') {
            //$("#nombre-error").css("display: block");
            $('#nombre-error').show();
            $('#nombre-error').html('<span><i class="fas fa-times m-1"></i> Error Nombre</span>');
              	
         }else{
            $('#nombre-error').hide();     
         }        
            
       }); 
            
            
       $("#apellidos").on('blur', function() {
        let currentValue = $(this).val();
        if (currentValue === '') {
            $('#apellido-arror').show();
            $('#apellido-arror').html('<span><i class="fas fa-times m-1"></i> Error Apellido</span>');
              	
         }else{
            $('#apellido-arror').hide();     
         }        
            
       }); 
            
       $("#fecha-nacimiento").on('blur', function() {
        let currentValue = $(this).val();
        if (currentValue === '') {
            $('#fecha-naci').show();
            $('#fecha-naci').html('<span><i class="fas fa-times m-1"></i> Error Fecha</span>');
              	
         }else{
            $('#fecha-naci').hide();     
         }        
            
       });
            
       $("#cedula").on('blur', function() {
        let currentValue = $(this).val();
        if (currentValue === '') {
            $('#cedu').show();
            $('#cedu').html('<span><i class="fas fa-times m-1"></i> Error Cedula</span>');
              	
         }else{
            $('#cedu').hide();     
         }        
            
       });
      

      // Añadir el evento de submit al formulario después de cargar los datos
      $("#act_perfil").on('submit', function (e) {
        e.preventDefault(); // Previene el comportamiento por defecto del submit
        // Aquí puedes agregar el código para enviar los datos del formulario mediante AJAX
        const nombres = $('#nombres').val();
        const apellidos = $('#apellidos').val();
        const fecha_nacimiento = $("#fecha-nacimiento").val();
        const cedula = $("#cedula").val();
        const telefono = $('#telefonos').val();

        let funcion = "act_perfil";
        $.post('../../controllers/usuario.php', {
          funcion,
          nombres,
          apellidos,
          fecha_nacimiento,
          cedula,
          telefono
        }, (response) => {
          console.log(response);
          if (response.trim() == "edit") {
            let mensaje = "!Los datos del Usuario Fueron editado Correctamente¡"
            alertaCorrecto(mensaje);
            dato_usuario();
          }else{
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


       //TODO: VALIDACIONES 
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
      validacion_nombres("#nombres");
      // apellido
      validacion_nombres("#apellidos");
      //CEDULA
      $("#cedula").on("input", function(e) {
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


    });
  }




  //TODO: BOTON DEL PANEL ACTUALIZAR
  $('#reloadButton').click(function () {
    dato_usuario();
  });


  //TODO: Modal de cambiar avatar
  var modal_cambiar_avatar = $("#modal-cambiar-avatar");
  $('#datos_personales').on('click', '.btn-avatar', function () {
    funcion = 'buscar_avatar_usuario';
    $.post('../../controllers/usuario.php', {
      funcion
    }, (response) => {
      console.log(response);
      template = '';
      template += `
          <img src="../../uploads/avatar/${response}">
        `;

      $('.vista-previa').html(template)

    })
    modal_cambiar_avatar.css("display", "block");
  });


  //TODO: SUBIR AVATAR
  $('#form-avatar').submit(e => {
    // e.preventDefault();
    let formData = new FormData($('#form-avatar')[0]);
    formData.append('funcion', 'cambiar_avatar');
    // Verificar si se seleccionó un archivo
    $.ajax({
      url: '../../controllers/usuario.php',
      type: 'POST',
      data: formData,
      processData: false, // Evita que jQuery procese los datos
      contentType: false, // Evita que jQuery configure el tipo de contenido
      cache: false, // Evita el almacenamiento en caché de la solicitud
    }).done(function (response) {
      const json = JSON.parse(response);
      if (json.alert == 'edit') {
        $('#edit').hide('slow');
        $('#edit').show(1000);
        $('#edit').hide(2000);
        $('#form-avatar').trigger('reset');
        dato_usuario();
      } else {
        $('#noedit').hide('slow');
        $('#noedit').show(1000);
        $('#noedit').hide(2000);
        $('#form-photo').trigger('reset');

      }

    });


  })

  // mostrar img
  var input_avatar = $('#avatar');
  input_avatar.change(mostrarImagen);

  function mostrarImagen() {
    var input_avatar = $('#avatar')[0]; // Accede al elemento HTML subyacente
    var vista_previa = $('.vista-previa');

    // Verificar si se seleccionó un archivo
    if (input_avatar.files.length > 0) {
      var imagen_seleccionada = input_avatar.files[0];

      // Verificar si el archivo es una imagen
      if (imagen_seleccionada.type.startsWith('image/')) {
        var imagen = new Image();
        imagen.src = URL.createObjectURL(imagen_seleccionada);
        imagen.style.maxWidth = '100%';
        vista_previa.empty(); // Limpiar vista previa anterior
        vista_previa.append(imagen);
      } else {
        alert('El archivo seleccionado no es una imagen.');
        input_avatar.value = ''; // Limpiar la selección
      }
    } else {
      vista_previa.empty(); // Limpiar vista previa si no se selecciona ningún archivo
    }
  }

  //TODO: funcionamiento de modal 
  var cerrar = $(".close");
  cerrar.click(function () {
    // cerrar modal de usuario <span> (x)
    if (modal_cambiar_avatar.length) {
      modal_cambiar_avatar.css("display", "none");
    }
  });

  var btn_cer_cam_av = $('.cerrar-cambiar-avatar');
  btn_cer_cam_av.click(function () {

    let input_avatar = $('#avatar');

    // Restablece el campo de entrada de archivo a un estado vacío
    input_avatar.val(''); // Esto establecerá el valor del campo a una cadena vacía
    modal_cambiar_avatar.css("display", "none");

  })

  $(window).click(function (event) {
    if (modal_cambiar_avatar.length) {
      if (event.target == modal_cambiar_avatar[0]) {
        modal_cambiar_avatar.css("display", "none");
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

});


