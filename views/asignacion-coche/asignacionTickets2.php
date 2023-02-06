<?php
use yii\helpers\Html;
use yii\jui\DatePicker;


?>
<?php

if (isset($RespuestaAsignacion)) {        
?>
<div class="alert alert-info">
<?php 
    echo "Estado: ".@$RespuestaAsignacion[0]["estado"]."<br>";
    echo "Mensaje: ".@$RespuestaAsignacion[0]["mensaje"]."<br>";
    echo "Valor: ".@$RespuestaAsignacion[0]["valor"];
 ?>     
 </div>
<?php    
}
?>
<div class="row">
    <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
        <button type="button" id="GuardarCoches" class="btn btn-danger btn-block">Asignar Tickets</button>         
    </div>
</div>
<div class="allcoches-form" id="allcoches-form">
  <div class=" table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" class="form-check-input" id="checkAll" name="checkAll" onchange="getSeleccionAll()" checked="1"></th>
          <th scope="col">OP</th>
          <th scope="col">Ticket</th>
          <th scope="col">OF</th>
          <th scope="col">Producto</th>
          <th scope="col">Peso Neto</th>
          <th scope="col">Marca</th>
          <th scope="col">Cod. lata</th>
          <th scope="col">Latas</th>      
          <th scope="col">Máquina</th>
          <th scope="col">Lote Producción</th>
        </tr>
      </thead>
      <tbody>
    <?php

    foreach($result as $row)
        {
    ?>
          <td><input type="checkbox" class="form-check-input" id="<?php echo $row['ctkIngreCam']; ?>" name="checkboxAsignar" onchange="getSeleccion(this.id)" checked="1"></td> 
          <td><?php echo $row['OP']; ?></td>
          <td><?php echo $row['ctkIngreCam']; ?></td>
          <td><?php echo $row['OF_PT']; ?></td>            
          <td><?php echo $row['Producto']; ?></td>  
          <td><?php echo $row['PesoNeto']; ?></td>
          <td><?php echo $row['cnoMarca']; ?></td>
          <td><?php echo $row['CodigoLata']; ?></td>  
          <td><?php echo $row['nqnCantidadUnidades']; ?></td>
          <td><?php echo $row['maquina']; ?></td>   
          <td><?php echo $row['Lote']; ?></td>       
        </tr>
    <?php

        }
    ?>
      </tbody>
    </table>
  </div>
</div>

   <div class="form-group">
    <label for="CocheExcluidos">Ticket Excluidos</label>
      <input type="text" class="form-control" name="CocheExcluidos" id="CocheExcluidos" readonly>
  </div>

<?php
$script = <<< JS

$("#GuardarCoches" ).click(function() {

var r = confirm("Confirmar asignación?");
if (r == true) {
  
    var fechaProduccion = $('#fechaProduccion').val();
    var turnoProduccion = $('#turnoProduccion').val();
    var fechaEncartonado = $('#fechaEncartonado').val();
    var turnoEncartonado = $('#turnoEncartonado').val();
    var maquina = $('#maquina').val();
    var parada = $('#parada').val();
    var autoClave = $('#autoClave').val();
    var CocheExcluidos = $('#CocheExcluidos').val();
    var proceso = $('#proceso').val();
    var egreso = $('#egreso').val();
    var idMaquinaConf = $("#maquina>option:selected").attr("name");    


    var allTicketsDatos = {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'maquina':maquina,'idMaquinaConf':idMaquinaConf,'TicketsExcluidos':CocheExcluidos,'proceso':proceso,'egreso':egreso};

    $.ajax({
          url: 'asignarcoche', 
          type : 'POST',      
          datatype : 'json',
          data : allTicketsDatos,       
          success: function(data) {                       
              $("#CochesPorAsignar" ).html(data);
              }
          }); 


}

});


JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">
  
if (<?php echo count($result) ?> <= 0) {
  $("#CochesPorAsignar").hide();
}else{
  $("#CochesPorAsignar").show();
}
</script>