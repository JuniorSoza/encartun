<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatas */

$this->title = 'Cambiar Fecha Inicio de Enfriamiento';

?>
<div class="enfriamiento-latas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formadd', [
        'model' => $model,
    ]) ?>

</div>
