<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatasDetalle */

$this->title = 'Update Enfriamiento Latas Detalle: ' . $model->idAutoclave;
$this->params['breadcrumbs'][] = ['label' => 'Enfriamiento Latas Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idAutoclave, 'url' => ['view', 'idAutoclave' => $model->idAutoclave, 'idEnfriamiento' => $model->idEnfriamiento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="enfriamiento-latas-detalle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
