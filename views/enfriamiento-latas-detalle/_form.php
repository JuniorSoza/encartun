<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatasDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="enfriamiento-latas-detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEnfriamiento')->textInput() ?>

    <?= $form->field($model, 'loteProduccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idAutoclave')->textInput() ?>

    <?= $form->field($model, 'ordenProduccion')->textInput() ?>

    <?= $form->field($model, 'ordenFabricacion')->textInput() ?>

    <?= $form->field($model, 'producto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pesoNeto')->textInput() ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigoLata')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coche')->textInput() ?>

    <?= $form->field($model, 'autoClave')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parada')->textInput() ?>

    <?= $form->field($model, 'latas')->textInput() ?>

    <?= $form->field($model, 'inicioEnfriamiento')->textInput() ?>

    <?= $form->field($model, 'horasStdConfiguracion')->textInput() ?>

    <?= $form->field($model, 'finEnfriamiento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
