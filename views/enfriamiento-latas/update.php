<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatas */

$this->title = 'Update Enfriamiento Latas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Enfriamiento Latas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="enfriamiento-latas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
