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
                                'options' => ['class' => 'form-control','id' => 'fechaEncartonado'],
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
                array('class'=>'form-control','id' => 'turnoEncartonado')); ?>
        </div>
          <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>
              <label>Proceso</label>
               <?php echo Html::dropDownList('proceso', 'proceso_id', array(
                        'PRODUCCIÓN'=>'PRODUCCIÓN',
                        'SEMIELABORADO'=>'SEMIELABORADO',),
                      array('class'=>'form-control control-encartonado','id' => 'proceso')); ?>
          </div>         
      </div>
<br>

<div class="row">
  <div class='col-sm-12' >
    <div id="CochesAsignados"></div>
  </div>
</div>
<p>

<?php
$script = <<< JS

$("#fechaEncartonado,#turnoEncartonado,#proceso" ).change(function() {
  
  var fechaEncartonado = $("#fechaEncartonado" ).val();
  var turnoEncartonado = $("#turnoEncartonado" ).val();
  var proceso = $("#proceso" ).val();
  
    $.ajax({
        url: 'allcoches', 
        type : 'POST',
        datatype : 'json',       
        data : {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'proceso':proceso},       
        success: function(data) {                        
            $("#CochesAsignados" ).html(data); 
            }
        });      
});

JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">
  function allCoches(parada,autoclave)
  { 
        var fechaEncartonado = $("#fechaEncartonado" ).val();
        var turnoEncartonado = $("#turnoEncartonado" ).val();

        //console.log(fechaEncartonado +'--'+turnoEncartonado+'--'+parada+'--'+autoclave);
        $.ajax({
        url: 'coches', 
        type : 'POST',
        datatype : 'json',       
        data : {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'parada':parada,'autoClave':autoclave},       
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


