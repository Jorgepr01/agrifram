$(document).ready(function(){
    var funcion = "";
    var template =  '';

    function cargar_nav_perfil(){
        funcion = 'dato_usuario';
        $.post('../../controllers/usuario.php', {funcion }, (response) => {
            console.log(response);
            template='';
            var datos = JSON.parse(response);
            // console.log(datos);
            const usuario = datos[0];
            console.log(usuario);
            template +=`
            <li class="nav-profile" >
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src='../../uploads/avatar/${usuario.avatar}' alt="">
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        ${usuario.nombres} ${usuario.apellidos}
                        <small>${usuario.nombre_tipo}</small>
                    </div>
                </a>
            </li>
            <li>
				<ul class="nav nav-profile">
					<li><a href="../Perfil/index.php"><i class="fa fa-cog"></i> Perfil</a></li>
					<!-- <li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Enviar Comentarios</a></li>
					<li><a href="javascript:;"><i class="fa fa-question-circle"></i> Ayuda</a></li> -->
				</ul>
			</li>
            `;
            // Actualiza el contenido de #nav-perfil dentro de la función de retorno del $.post
            $("#nav-perfil").html(template);
            template = "";
            template +=`
            <img src='../../uploads/avatar/${usuario.avatar}' alt=""> 
			<span class="d-none d-md-inline">${usuario.nombres} ${usuario.apellidos}</span> <b class="caret"></b>
            `;
            $("#navbar-user").html(template);
        });
        
    }

    // Llama a la función cargar_nav_perfil
    cargar_nav_perfil();
});
