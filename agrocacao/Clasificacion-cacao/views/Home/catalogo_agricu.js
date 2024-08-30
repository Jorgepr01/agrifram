$(document).ready(function () {
    kpi_agricu();
        
    function kpi_agricu() {
            console.log("ss")
        $.ajax({
            type: 'POST',
            url: '../../controllers/usuario.php',
            data: {
                funcion: 'kpi_agricu'
            },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                    console.log("sss")
                // Aquí puedes procesar los datos recibidos y actualizar tu vista
                actualizarVista(response);
            }
          
        });
    }

    function actualizarVista(data) {
        // Supongamos que tienes elementos HTML donde quieres mostrar los datos
        $('#total-img').text(data.total_img);
        $('#cacao-sano-val').text(data.cacao_sano_val);
        $('#cacao-fito-val').text(data.cacao_fito_val);
    }
});
