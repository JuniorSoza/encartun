<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnfriamientoLatasDetalleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Enfriamiento Recibidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div >
        <div class="enfriamiento-latas-detalle-index">

    <h1><?= Html::encode($this->title) ?></h1>

      <p>
        <?= Html::a('Empezar Enfriamiento', ['enfriamiento-latas/create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'table-responsive',
        ],
        'rowOptions'=>function($model, $index, $widget, $grid)  {
                $time = new \DateTime('now');
                $today = $time->format('Y-m-d H:i:s');
                if  (strtotime($model->finEnfriamiento) > strtotime($today))
                {
                     return ['class' => 'danger'];
                }
                else
                {
                    return ['class' => 'success'];
                }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'autoClave',
            'parada',
            'loteProduccion',
            'ordenProduccion',
            'ordenFabricacion',
            'nombreProducto',
            'pesoNeto',
            'nombreMarca',
            //'marca',
            //'codigoLata',
            'coche',
            'latas',
            'cajasLatas',
            'inicioEnfriamiento',
            'horasStdConfiguracion',
            'finEnfriamiento',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


        </div>
    </div>    
</div>