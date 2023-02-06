<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\TblAutoclaves;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatas */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
date_default_timezone_set("America/Guayaquil");
$time= date ("H:i:s");
$fecha= date("Y-m-d");?>


<div class="enfriamiento-latas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    echo $form->field($model, 'fechaProduccion')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese una fecha'],
        'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true
        ],
    ]);?>

    <?php 
    echo $form->field($model, 'turno')->widget(Select2::classname(), [
        'data' => array(),
        'options' => ['placeholder' => 'Seleccione un turno ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
   

    <?php $autoclaves = ArrayHelper::map(TblAutoclaves::find()->where(['bstAutoclave'=>'1'])->all(), 'cciAutoclave', 'cnoAutoclave');
    echo $form->field($model, 'autoClave')->widget(Select2::classname(),
    	[
        'data' => $autoclaves,
        'options' => ['placeholder' => 'Seleccione una autoclave...'],
        'pluginOptions' => [
            'allowClear' => true
        ],]);
    ?>
   


    <?php 
    echo $form->field($model, 'parada')->widget(Select2::classname(), [
        'data' => array(),
        'options' => ['placeholder' => 'Seleccione una parada ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <?= $form->field($model, 'cochesNoIncluir')->textInput(['readonly'=>true])->label('Omitir Coches Nueva Fecha',['class'=>'label-class']) ?>

    <!-- <input id="idCabeceraTxt" type="text" readonly="true"> -->

    <div class="">
              <label>Fecha Inicio de Enfriamiento Nueva</label>         
              <?= DateTimePicker::widget([
                    'name' => 'fechaEnfriamientoNew',
                    'options' => ['class' => 'form-control control-encartonado','id' => 'fechaEnfriamientoNew'],
                    'value' => date('Y-m-d H:i:s'),
                    'readonly' => true,
                    'pluginOptions' => [
                      'autoclose' => true,
                      'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                  ]);
              ?>
    </div>
    <br>

    <div class="form-group">
        <div class="col-md-3">
            <button class="btn btn-success btn-block" type="button" onclick="confirmarNuevaFechaEnfriamiento()" id="btnGuardarValid" >
                Confirmar Cambio
            </button>
          </div>

        <a href="#">Total Coches:<span id="totalCochesTmp" class="badge">0</span></a>
        <a href="#">Total Latas:<span id="totalLatasTmp" class="badge">0</span></a>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    .tg  {
        border-collapse:collapse;border-spacing:0;border-color:#93a1a1;
    }
    .tg td {
        font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#93a1a1;color:#002b36;background-color:#fdf6e3;
    }
    .tg th {
        font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#93a1a1;color:#fdf6e3;background-color:#657b83;
    }
    .tg .tg-s268{text-align:left}
</style>
<br>
<div class="table-responsive">
    <table id="tablaSearch" class="tg">
        <tr>
            <th><input id="selectAll" checked='1' type="checkbox" onchange='getSelected()'></th>
            <th class="tg-s268">LoteProduccion</th>
            <th class="tg-s268">OrdenProducción</th>
            <th class="tg-s268">OrdenFabricación</th>
            <th class="tg-s268">Producto</th>
            <th class="tg-s268">PesoNeto</th>
            <th class="tg-s268">Marca</th>
            <th class="tg-s268">CodigoLata</th>
            <th class="tg-s268">#Coche</th>
            <th class="tg-s268">Latas</th>
            <th class="tg-s268">Cjs/Latas</th>
            <th class="tg-s268">Inicio de Enfriamiento</th>
            <th class="tg-s268">Fin de Enfriamiento</th>
            <th class="tg-s268">ID</th>
        </tr>
    </table>
</div>



<?php 

$script = <<< JS

$(document).ready(function() {

});

$('#enfriamientolatas-fechaproduccion').change(function(){
    var fechaPrd = $('#enfriamientolatas-fechaproduccion').val();
    var turnoPrd = $('#enfriamientolatas-turno').val();
    var autoclavePrd = $('#enfriamientolatas-autoclave').val();
    var paradaPrd = $('#enfriamientolatas-parada').val();
    buscarDetalle(fechaPrd, autoclavePrd, paradaPrd, turnoPrd);

    $('#enfriamientolatas-turno').empty();
    $('#enfriamientolatas-turno').append('<option value="" selected="selected"></option>');
    $.get('searchturno',{ fechaproduccion : fechaPrd}, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#enfriamientolatas-turno').append($("<option></option>").attr("value",value.turno).text(value.turno)); 
        });
    });


    $('#enfriamientolatas-parada').empty();
    $('#enfriamientolatas-parada').append('<option value="" selected="selected"></option>');
    $.get('searchautoclave',{ fechaproduccion : fechaPrd, autoclave : autoclavePrd, turno : turnoPrd}, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#enfriamientolatas-parada').append($("<option></option>").attr("value",value.parada).text(value.parada)); 
        });
    });
});

$('#enfriamientolatas-turno').change(function(){
    var fechaPrd = $('#enfriamientolatas-fechaproduccion').val();
    var turnoPrd = $('#enfriamientolatas-turno').val();
    var autoclavePrd = $('#enfriamientolatas-autoclave').val();
    var paradaPrd = $('#enfriamientolatas-parada').val();
    buscarDetalle(fechaPrd, autoclavePrd, paradaPrd, turnoPrd);

    $('#enfriamientolatas-parada').empty();
    $('#enfriamientolatas-parada').append('<option value="" selected="selected"></option>');
    $.get('searchautoclave',{ fechaproduccion : fechaPrd, autoclave : autoclavePrd, turno : turnoPrd}, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#enfriamientolatas-parada').append($("<option></option>").attr("value",value.parada).text(value.parada)); 
        });
    });
});

$('#enfriamientolatas-autoclave').change(function(){
    var fechaPrd = $('#enfriamientolatas-fechaproduccion').val();
    var turnoPrd = $('#enfriamientolatas-turno').val();
    var autoclavePrd = $('#enfriamientolatas-autoclave').val();
    var paradaPrd = $('#enfriamientolatas-parada').val();
    buscarDetalle(fechaPrd, autoclavePrd, paradaPrd, turnoPrd);

    $('#enfriamientolatas-parada').empty();
    $('#enfriamientolatas-parada').append('<option value="" selected="selected"></option>');
    $.get('searchautoclave',{ fechaproduccion : fechaPrd, autoclave : autoclavePrd, turno : turnoPrd}, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#enfriamientolatas-parada').append($("<option></option>").attr("value",value.parada).text(value.parada)); 
        });
    });
});

$('#enfriamientolatas-parada').change(function(){
    var fechaPrd = $('#enfriamientolatas-fechaproduccion').val();
    var turnoPrd = $('#enfriamientolatas-turno').val();
    var autoclavePrd = $('#enfriamientolatas-autoclave').val();
    var paradaPrd = $('#enfriamientolatas-parada').val();
    buscarDetalle(fechaPrd, autoclavePrd, paradaPrd, turnoPrd);
});

$('#selectAll').click(function(e){
var table= $(e.target).closest('table');
$('td input:checkbox',table).prop('checked',this.checked);
});

JS;
$this->registerJs($script);

?>

<script type="text/javascript">
    
    function buscarDetalle(fechaProduccion, autoclaveProduccion, paradaProduccion, turnoProduccion) {
        $.get('buscarrecibido',{ fechaproduccion : fechaProduccion, autoclave : autoclaveProduccion, parada : paradaProduccion, turno : turnoProduccion}, function(data){
            var result = $.parseJSON(data);
            if (result.length == 0)
            {
                document.getElementById("btnGuardarValid").disabled = true;
            }
            else
            {
                document.getElementById("btnGuardarValid").disabled = false;   
            }
            $('#tablaSearch tr > td').remove();
            var totalCochesTmp = 0;
            var totalLatasTmp = 0;
            $.each(result, function(key, value) {
                $('#tablaSearch').append($(
                    "<tr>" +
                    "<td> <input type='checkbox' id='"+ value.coche+ "' checked='1' onchange='getSelected()' /></td>"+
                    "<td>" + value.cnqLotePrd + "</td>"+
                    "<td>" + value.orden_prod + "</td>"+
                    "<td>" + value.ordenFabricacion_PT + "</td>"+
                    "<td>" + value.producto + "</td>"+
                    "<td>" + value.peso_neto + "</td>"+
                    "<td>" + value.marca + "</td>"+
                    "<td>" + value.codigo_lata + "</td>"+
                    "<td>" + value.coche + "</td>"+
                    "<td>" + value.latas + "</td>"+
                    "<td>" + value.cjsLatas + "</td>"+
                    "<td>" + value.inicioEnfriamiento + "</td>"+
                    "<td>" + value.finEnfriamiento + "</td>"+
                    "<td>" + value.idEnfriamiento + "</td>"+
                    "</tr>")); 
                totalCochesTmp += 1;
                totalLatasTmp += parseInt(value.latas);
            });
            $("#totalCochesTmp").text(totalCochesTmp);
            $("#totalLatasTmp").text(totalLatasTmp);
        });
    }

    function getSelected() {
        var table = document.getElementById("tablaSearch");
        var checkBoxes = table.getElementsByTagName("input");
        var message = "";

        for (var i = 1; i < checkBoxes.length; i++) {
            if (!checkBoxes[i].checked) {
                var row = checkBoxes[i].parentNode.parentNode;
                message += row.cells[8].innerHTML;
                message += "|";
            }
        }
        var text = document.getElementById("enfriamientolatas-cochesnoincluir");
        text.value = message;
    }

    function confirmarNuevaFechaEnfriamiento(){        
        var r = confirm("Desea confirmar la la nueva fecha de enfriamiento?");

        if (r == true) {
            var fechaPrdJs = $("#enfriamientolatas-fechaproduccion").val();
            var turnoPrdJs = $("#enfriamientolatas-turno").val();
            var autoclaveJs = $("#enfriamientolatas-autoclave").val();
            var paradaJs = $("#enfriamientolatas-parada").val();
            //var idCabeceraJs = $("").val();
            var fechaEnfriamientoNewJs = $("#fechaEnfriamientoNew").val();
            var cochesNoIncluirJs = $("#enfriamientolatas-cochesnoincluir").val();
            //alert(cochesNoIncluirJs);
            var valores = {'fechaPrd':fechaPrdJs, 'turnoPrd':turnoPrdJs, 'autoclave':autoclaveJs, 'parada':paradaJs, 'fechaEnfriamientoNew':fechaEnfriamientoNewJs, 'cochesNoIncluir':cochesNoIncluirJs};
            $.ajax({
                url: 'settimequery', 
                type : 'POST',
                datatype : 'json',       
                data : valores,     
                success: function(data) { 
                    
                }
            });         
        }
    }
</script>