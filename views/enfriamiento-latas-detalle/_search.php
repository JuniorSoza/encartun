<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatasDetalleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="enfriamiento-latas-detalle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idEnfriamiento') ?>

    <?= $form->field($model, 'loteProduccion') ?>

    <?= $form->field($model, 'idAutoclave') ?>

    <?= $form->field($model, 'ordenProduccion') ?>

    <?= $form->field($model, 'ordenFabricacion') ?>

    <?php // echo $form->field($model, 'producto') ?>

    <?php // echo $form->field($model, 'pesoNeto') ?>

    <?php // echo $form->field($model, 'marca') ?>

    <?php // echo $form->field($model, 'codigoLata') ?>

    <?php // echo $form->field($model, 'coche') ?>

    <?php // echo $form->field($model, 'autoClave') ?>

    <?php // echo $form->field($model, 'parada') ?>

    <?php // echo $form->field($model, 'latas') ?>

    <?php // echo $form->field($model, 'inicioEnfriamiento') ?>

    <?php // echo $form->field($model, 'horasStdConfiguracion') ?>

    <?php // echo $form->field($model, 'finEnfriamiento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
