<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\parametroBalanzaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parametro Balanzas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametro-balanza-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Parametro Balanza', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fecha',
            'linea',
            'item',
            'unidad',
            //'pesoNominal',
            //'tara',
            //'maximo',
            //'minimo',
            //'valor1',
            //'valor2',
            //'of',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
