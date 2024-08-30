$(document).ready(function () {
    kpi();

    function kpi() {
        $.ajax({
            type: 'POST',
            url: '../../controllers/usuario.php',
            data: { funcion: 'kpi' },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                // Aquí puedes procesar los datos recibidos y actualizar tu vista
                actualizarVista(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
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
