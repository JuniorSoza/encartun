<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EnfriamientoLatas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Enfriamiento Latas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="enfriamiento-latas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Iniciar Enfriamiento', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Ver Todos', ['/enfriamiento-latas-detalle'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fechaProduccion',
            'turno',
            'autoClave',
            'parada',
            'cochesNoIncluir'
        ],
    ]) ?>

</div>


<style type="text/css">
    .tg  {
        border-collapse:collapse;border-spacing:0;border-color:#93a1a1;
    }
    .tg td {
        font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#93a1a1;color:#002b36;background-color:#fdf6e3;
    }
    .tg th {
        font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#93a1a1;color:#fdf6e3;background-color:#657b83;
    }
    .tg .tg-s268{text-align:left}
</style>


<div class="col-md-12">
    <div class="table-responsive">
    
    <table id="tablaSearch" class="table tg">
        <tr>
            <th class="tg-s268">LoteProduccion</th>
            <th class="tg-s268">OrdenProducción</th>
            <th class="tg-s268">OrdenFabricación</th>
            <th class="tg-s268">Producto</th>
            <th class="tg-s268">PesoNeto</th>
            <th class="tg-s268">Marca</th>
            <th class="tg-s268">CodigoLata</th>
            <th class="tg-s268">#Coche</th>
            <th class="tg-s268">Latas</th>
            <th class="tg-s268">Cajas/Latas</th>
            <th class="tg-s268">Inicio Enfriamiento</th>
            <th class="tg-s268">Horas Enfriamiento</th>
            <th class="tg-s268">Fin Enfriamiento</th>
        </tr>
        <?php 
            $detalle = $model->getEnfriamientoLatasDetalles()->all();
            foreach ($detalle as $key) {
                 echo "<tr><td>".$key->loteProduccion."</td>";
                 echo "<td>".$key->ordenProduccion."</td>";
                 echo "<td>".$key->ordenFabricacion."</td>";
                 echo "<td>".$key->nombreProducto."</td>";
                 echo "<td>".$key->pesoNeto."</td>";
                 echo "<td>".$key->nombreMarca."</td>";
                 echo "<td>".$key->codigoLata."</td>";
                 echo "<td>".$key->coche."</td>";
                 echo "<td>".$key->latas."</td>";
                 echo "<td>".$key->cajasLatas."</td>";
                 echo "<td>".$key->inicioEnfriamiento."</td>";
                 echo "<td>".$key->horasStdConfiguracion."</td>";
                 echo "<td>".$key->finEnfriamiento."</td></tr>";
            }
        ?>
    </table>
</div>
</div>