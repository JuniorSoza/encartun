<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\parametroBalanzaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parametro-balanza-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'linea') ?>

    <?= $form->field($model, 'item') ?>

    <?= $form->field($model, 'unidad') ?>

    <?php // echo $form->field($model, 'pesoNominal') ?>

    <?php // echo $form->field($model, 'tara') ?>

    <?php // echo $form->field($model, 'maximo') ?>

    <?php // echo $form->field($model, 'minimo') ?>

    <?php // echo $form->field($model, 'valor1') ?>

    <?php // echo $form->field($model, 'valor2') ?>

    <?php // echo $form->field($model, 'of') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
