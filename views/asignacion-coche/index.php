<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;


?>
      <div class="row">        
          <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '> 
              <label>Fecha de Encartonado</label>         
              <?= DatePicker::widget(['name' => 'fechaEncartonado',
                                      'options' => ['class' => 'form-control control-encartonado','id' => 'fechaEncartonado'],
                                      'attribute' => 'from_date',                                
                                      'language' => 'es',
                                      'dateFormat' => 'yyyy-MM-dd',
                                      'value' => date('Y-m-d'),])?>
          </div>
          <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>
              <label>Turno Encartonado</label>
               <?php echo Html::dropDownList('turnoEncartonado', 'turnoEncartonado_id', array(
                        '1'=>'Turno 1',
                        '2'=>'Turno 2',),
                      array('class'=>'form-control control-encartonado','id' => 'turnoEncartonado')); ?>
          </div>
          <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>
              <label>Proceso</label>
               <?php echo Html::dropDownList('proceso', 'proceso_id', array(
                        'PRODUCCIÓN'=>'PRODUCCIÓN',
                        'SEMIELABORADO'=>'SEMIELABORADO',),
                      array('class'=>'form-control control-encartonado','id' => 'proceso')); ?>
          </div>     
      </div>       
      <div class="row" id="text-semielaborados" style="display: none">
        <div class=' col-xs-12 col-sm-4 col-ls-4 col-md-4'> 
          <label>Egreso</label>
            <input type="text" name="egreso" id="egreso" class="form-control">
        </div>
      </div>
      <br>      
      <div class="row" id="text-produccion">
        <div class='col-sm-7 col-ls-7 col-md-7 col-xs-12'>  
        <label>Fecha de Producción</label>         
        <?= DatePicker::widget(['name' => 'fechaProduccion',
                                'options' => ['class' => 'form-control','id' => 'fechaProduccion'],
                                'attribute' => 'from_date',                                
                                'language' => 'es',
                                'dateFormat' => 'yyyy-MM-dd',
                                'value' => date('Y-m-d'),])?>
        </div>
        <div class='col-sm-5 col-ls-5 col-md-5 col-xs-12'>
        <label>Turno Producción</label>
         <?php echo Html::dropDownList('turnoProduccion', 'turnoProduccion_id', array(
                  '1'=>'Turno 1',
                  '2'=>'Turno 2',),
                array('class'=>'form-control','id' => 'turnoProduccion')); ?>
        </div>
      </div>
<br>
<div class="row">
  <div class="col-xs-12">
    <div class="form-group">
      <label>Máquinas encartonado</label>
      <select id="maquina"  class="form-control control-maquina">
      </select>
     </div>
  </div>
</div>
<div class="row">
  <div class='col-sm-12' >
    <span id="span-cargando-data" style="display: none"> Buscando información...</span>
    <div id="CochesPorAsignar"></div>
  </div>
</div>
<p>

<?php
$script = <<< JS

$( document ).ready(function() {
    allMaquinas();
});

//validacion para ver que tipo de proceso se esta consultado
$(".control-encartonado" ).change(function(){

    if($("#proceso" ).val() == 'SEMIELABORADO'){
      $('#text-produccion').hide();
      $('#text-semielaborados').show();
      $('#CochesPorAsignar').html('');
    }else{
      $('#text-produccion').show();
      $('#text-semielaborados').hide();
      $('#CochesPorAsignar').html('');
    }

    allMaquinas();

});

  $(".control-maquina").change(function(){

    if($("#proceso" ).val() == 'SEMIELABORADO'){
      $('#text-produccion').hide();
      $('#text-semielaborados').show();
      $('#CochesPorAsignar').html('');
      $('#egreso').val('');
    }else{
      allParadasOtickets();
    }

  });

  $("#fechaProduccion,#turnoProduccion" ).change(function() {
    allParadasOtickets();

  });

  $( "#egreso" ).keyup(function(event) {
    allParadasOtickets();
  });

JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">

  function allParadasOtickets()
  {

    var fechaProduccion = $("#fechaProduccion" ).val();
    var turnoProduccion = $("#turnoProduccion" ).val();

    var fechaEncartonado = $("#fechaEncartonado" ).val();
    var turnoEncartonado = $("#turnoEncartonado" ).val();
    var egreso = $("#egreso" ).val();
    var idMaquina = $("#maquina" ).val();
    var idMaquinaConf = $("#maquina>option:selected").attr("name");
    var proceso = $("#proceso" ).val();

      $.ajax({
          url: 'allcoches', 
          type : 'POST',
          datatype : 'json',       
          data : {'fechaProduccion':fechaProduccion,'turnoProduccion':turnoProduccion,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'proceso':proceso,'egreso':egreso,'idMaquina':idMaquina,'idMaquinaConf':idMaquinaConf},
          beforeSend: function() {   
              $("#span-cargando-data").show();
          },                
          success: function(data) {   
              $("#span-cargando-data").hide();              
              $("#CochesPorAsignar" ).html(data); 
          },error:function(){
              $("#span-cargando-data").hide();
              $("#CochesPorAsignar" ).html("");
          }
          }); 
  }

  function allCoches(parada,autoclave)
  { 
        var fechaProduccion = $("#fechaProduccion" ).val();
        var turnoProduccion = $("#turnoProduccion" ).val();
        
        //console.log(fechaProduccion +'--'+turnoProduccion+'--'+parada+'--'+autoclave);
        $.ajax({
        url: 'coches', 
        type : 'POST',
        datatype : 'json',       
        data : {'fechaProduccion':fechaProduccion,'turnoProduccion':turnoProduccion,'parada':parada,'autoClave':autoclave}, 
        success: function(data) {                       
            $('#AsignacionCochesAll').html(data);
            }
        }); 
  }

  function allTickets(ticket)
  {

        $.ajax({
        url: 'tickets', 
        type : 'POST',
        datatype : 'json',       
        data : {'ticket':ticket},       
        success: function(data) {                       
            $('#AsignacionCochesAll').html(data);
            }
        });     
  }

  function getSeleccion(e)
  {
        
    var cocheExcluidos = $("#CocheExcluidos").val();

    if (cocheExcluidos != "") {

          var textoseparado = cocheExcluidos.split("|");
          //busco en el array si existe el valor
          var i = textoseparado.indexOf(e);

          if ( i !== -1 ) {
              textoseparado.splice( i, 1 );
                var arrayNuevo = ""
              $.each(textoseparado, function (ind, elem) {
                if (elem != "") {
                  arrayNuevo =arrayNuevo +elem+'|';
                }                                             
                }); 
              $("#CocheExcluidos").val(arrayNuevo);     
          }else{
                $("#CocheExcluidos").val(cocheExcluidos+e+"|");
          }
    }else{
      $("#CocheExcluidos").val(e+"|");
    }              
  }

  function allMaquinas()
  {
    var proceso = $("#proceso" ).val();
          $.ajax({
          url: 'obtenermaquinas', 
          type : 'POST',
          datatype : 'json',       
          data : {'proceso':proceso},       
          success: function(data) {  
              var obj = jQuery.parseJSON(data);
                  $('#maquina').find('option').remove(); 
              $.each(obj, function(i, item) {                 
                  $('#maquina').append("<option value='"+item.idMaquina+"' name='"+item.idMaquinaConf+"'>"+item.NombreMaquina+"</option>");
              });
          },error: function(){
            $('#maquina').find('option').remove(); 
          }
          });
  }

  function getSeleccionAll()
  {
    
    var arr = $('[name="checkboxAsignar"]').map(function(){
      return this.id;
    }).get();
    
    var str = arr.join('|');
    
    if ($('#checkAll').prop('checked'))
    {
      $("#CocheExcluidos").val("");
      $("[name='checkboxAsignar']").prop("checked", true);
    }else{
      $("#CocheExcluidos").val(str+"|");
      $("[name='checkboxAsignar']").prop("checked", false);
    }

  }  
</script>