<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatasDetalle */

$this->title = $model->idAutoclave;
$this->params['breadcrumbs'][] = ['label' => 'Enfriamiento Latas Detalles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="enfriamiento-latas-detalle-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idAutoclave' => $model->idAutoclave, 'idEnfriamiento' => $model->idEnfriamiento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idAutoclave' => $model->idAutoclave, 'idEnfriamiento' => $model->idEnfriamiento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idEnfriamiento',
            'loteProduccion',
            'idAutoclave',
            'ordenProduccion',
            'ordenFabricacion',
            'producto',
            'pesoNeto',
            'marca',
            'codigoLata',
            'coche',
            'autoClave',
            'parada',
            'latas',
            'inicioEnfriamiento',
            'horasStdConfiguracion',
            'finEnfriamiento',
        ],
    ]) ?>

</div>
