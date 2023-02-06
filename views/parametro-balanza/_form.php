<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\tblEtiquetadoras;
use app\models\ProgramaProduccionD;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\parametroBalanza */
/* @var $form yii\widgets\ActiveForm */
?>


<?php 
date_default_timezone_set("America/Guayaquil");
$time= date ("H:i:s");
$fecha= date("Y-m-d");?>



<div class="parametro-balanza-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
     
    ]); ?>

<?php 
    echo $form->field($model, 'fecha')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ingrese una fecha'],
        'readonly' => true,
        'pluginOptions' => [
            'autoclose'=>true
        ],
    ]);

?>

<?php 
    echo $form->field($model, 'op')->widget(Select2::classname(), [
        'data' => array(),
        'options' => ['placeholder' => 'Seleccione una OP ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
?>


<?php 
    echo $form->field($model, 'of')->widget(Select2::classname(), [
        'data' => array(),
        'options' => ['placeholder' => 'Seleccione una OF_PT ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
?>



<?php 
    $lineaCerradora = ArrayHelper::map(tblEtiquetadoras::find()->where(['cciTipo'=>'CE'])->andWhere(['bstEtiquetadora'=>1])->all(), 'cciEtiquetadora', 'cnoEtiquetadora');

    echo $form->field($model, 'linea')->widget(Select2::classname(), [
        'data' => $lineaCerradora,
        'options' => ['placeholder' => 'Seleccione una línea ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

?>

    <?= $form->field($model, 'item')->textInput(['maxlength' => true, 'readOnly' =>true]) ?>

    <?= $form->field($model, 'unidad')->textInput(['maxlength' => true, 'readOnly' =>true, 'value'=>'G']) ?>

    <?= $form->field($model, 'pesoNominal')->textInput(['readOnly' =>true]) ?>

    <?= $form->field($model, 'tara')->textInput() ?>

    <?= $form->field($model, 'maximo')->textInput() ?>

    <?= $form->field($model, 'minimo')->textInput() ?>

    <?= $form->field($model, 'valor1')->textInput() ?>

    <?= $form->field($model, 'valor2')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<<?php 

$script = <<< JS

$(document).ready(function() {

});

$('#parametrobalanza-fecha').change(function(){
    var dia = $(this).val();
    $('#parametrobalanza-op').empty();
    $('#parametrobalanza-op').append('<option value="" selected="selected"></option>');
    $('#parametrobalanza-of').empty();
    $('#parametrobalanza-of').append('<option value="" selected="selected"></option>');
    $('#parametrobalanza-item').attr("value","");
    $('#parametrobalanza-pesonominal').attr("value","");

    $.get('searchop',{ dia : dia }, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#parametrobalanza-op').append($("<option></option>").attr("value",value.nciOP).text(value.nciOP)); 
            });
        });
});


$('#parametrobalanza-op').change(function(){
    var op = $(this).val();
    if (op === "") {
        op = 0;
    }
    $('#parametrobalanza-of').empty();
    $('#parametrobalanza-of').append('<option value="" selected="selected"></option>');
    $('#parametrobalanza-item').attr("value","");
    $('#parametrobalanza-pesonominal').attr("value","");
    var dia = $('#parametrobalanza-fecha').val();
    $.get('searchof',{ dia : dia, op : op }, function(data){
            var result = $.parseJSON(data);
            $.each(result, function(key, value) {
                $('#parametrobalanza-of').append($("<option></option>").attr("value",value.ordenFabricacion_PT).text(value.ordenFabricacion_PT)); 
            });
        });
});

$('#parametrobalanza-of').change(function(){
    var ofseleccionada = $(this).val();
    if (ofseleccionada === "") {
        ofseleccionada = 0;
    }
    $('#parametrobalanza-item').attr("value","");
    $('#parametrobalanza-pesonominal').attr("value","");
     $.get('datosof',{ ofseleccionada : ofseleccionada }, function(data){
        var result = $.parseJSON(data);
         $.each(result, function(key, value) {
                $('#parametrobalanza-item').attr("value",value.Producto);
                $('#parametrobalanza-pesonominal').attr("value",value.PesoNeto);
        });
    });
});

JS;
$this->registerJs($script);

?>