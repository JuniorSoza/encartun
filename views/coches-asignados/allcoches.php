<?php
use yii\helpers\Html;
use yii\jui\DatePicker;

?>

<?php

if (isset($RespuestaAsignacion)) {        
?>
<div class="alert alert-info">
<?php 
    echo "Estado: ".$RespuestaAsignacion[0]["estado"]."<br>";
    echo "Mensaje: ".$RespuestaAsignacion[0]["mensaje"]."<br>";
    echo "Valor: ".$RespuestaAsignacion[0]["valor"];
 ?>     
 </div>
<?php    
}
?>
<div class="collapse" id="collapseAllCoches">
  <div class="card card-body">
    <form action="POST">

    <input type="hidden" name="fechaEncartonado" value="<?php echo $fechaEncartonado; ?>"> 
    <input type="hidden" name="turnoEncartonado" value="<?php echo $turnoEncartonado; ?>"> 

<br>
<div class="row">
    <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
        <button type="button" id="GuardarCoches" class="btn btn-danger btn-block">Regresar Parada</button>         
    </div>
</div>

    <div id="AsignacionCochesAll"></div> 

    </form>
  </div>
</div>
<?php
foreach($result as $row)
    {
?>
	
</p>
  <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#collapseAllCoches" aria-expanded="false" aria-controls="collapseAllCoches" onclick="allCoches(<?php echo "'".$row['parada']."'" ?>,<?php echo "'".$row['autoClave']."'" ?>)">
    Autoclave:<?php echo "".$row['autoClave']?> - Parada:<?php echo $row['parada']."" ?>
  </button>
<?php

    }
?>

<?php
$script = <<< JS

$("#GuardarCoches" ).click(function() {


  var fechaEncartonado = $('#fechaEncartonado').val();
  var turnoEncartonado = $('#turnoEncartonado').val();
  var parada = $('#parada').val();
  var autoClave = $('#autoClave').val();
  var CocheExcluidos = $('#CocheExcluidos').val();
  var idMaquina = $('#idMaquina').val();
  var proceso = $('#proceso').val();


  var allCochesDatos = {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'parada':parada,'autoClave':autoClave,'CocheExcluidos':CocheExcluidos,'idMaquina':idMaquina,'proceso':proceso};

var r = confirm("Desear regresar los coches, para volver a asignar?");
if (r == true) {

$.ajax({
        url: 'regresarcoche', 
        type : 'POST',      
        datatype : 'json',
        data : allCochesDatos,       
        success: function(data) {                       
            $("#CochesAsignados" ).html(data);
            }
        });  
}

});


JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">
  
if (<?php echo count($result) ?> <= 0) {
  $("#CochesAsignados").hide();
}else{
  $("#CochesAsignados").show();
}
</script>