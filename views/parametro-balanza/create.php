<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\parametroBalanza */

$this->title = 'Create Parametro Balanza';
$this->params['breadcrumbs'][] = ['label' => 'Parametro Balanzas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametro-balanza-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
