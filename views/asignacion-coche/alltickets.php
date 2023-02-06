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
<div class="collapse" id="collapseAllCoches">
  <div class="card card-body">
    <form action="POST"> 
      <div class="row">
          <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
              <button type="button" id="GuardarTickets" class="btn btn-danger btn-block">Asignar Ticket</button>         
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
  <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#collapseAllCoches" aria-expanded="false" aria-controls="collapseAllCoches" onclick="allTickets(<?php echo "'".$row['ctkIngreCam']."'" ?>)">
	 Ticket: <?php echo "".$row['ctkIngreCam']?>
  </button>
<?php

    }
?>

<?php
$script = <<< JS

$("#GuardarTickets" ).click(function() {
	
var r = confirm("Confirmar asignación?");
if (r == true) {

    var fechaProduccion = $('#fechaProduccion').val();
    var turnoProduccion = $('#turnoProduccion').val();
    var fechaEncartonado = $('#fechaEncartonado').val();
    var turnoEncartonado = $('#turnoEncartonado').val();
    var maquina = $('#maquina').val();
    var CocheExcluidos = $('#CocheExcluidos').val();
    var egreso = $('#egreso').val();
    var proceso = $('#proceso').val();


    var allCochesDatos = {'fechaProduccion':fechaProduccion,'turnoProduccion':turnoProduccion,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'maquina':maquina,'CocheExcluidos':CocheExcluidos,'egreso':egreso,'proceso':proceso};
    console.log(allCochesDatos);
    $.ajax({
          url: 'asignarcoche', 
          type : 'POST',      
          datatype : 'json',
          data : allCochesDatos,       
          success: function(data) {                       
              $("#CochesPorAsignar" ).html(data);
              }
          }); 

}  

});


JS;
$this->REGISTERJS($script);
?>