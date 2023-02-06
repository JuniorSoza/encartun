<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatasDetalle */

$this->title = 'Create Enfriamiento Latas Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Enfriamiento Latas Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="enfriamiento-latas-detalle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
