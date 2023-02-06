<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnfriamientoLatasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Enfriamiento Recibidos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enfriamiento-latas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Empezar Enfriamiento', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fechaProduccion',
            'autoClave',
            'parada',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?php

     ?>

</div>
