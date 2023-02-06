<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TblProducto".
 *
 * @property string $cciProducto
 * @property string $cciProceso
 * @property string|null $cciPresentacion
 * @property string|null $cciRegimen
 * @property string|null $cciEspecie
 * @property string|null $cciEstadoProducto
 * @property string|null $cciAlmacenamiento
 * @property string|null $cciMarca
 * @property string|null $cciClasificacion
 * @property string $cciEmbalaje
 * @property string $cciUmedida
 * @property string $cciSClase
 * @property string $cciClase
 * @property string $cciTipo
 * @property string|null $cciTipoLimpieza
 * @property string|null $cnoProductoEsp
 * @property string|null $cnoProductoPrd
 * @property string|null $cnoProductoExp
 * @property string|null $cnoProductoCorto
 * @property string|null $cnoProductoGuia
 * @property float $nqnOrden
 * @property float|null $nqnRetractil
 * @property int $btpProdEsp
 * @property int $bstProducto
 * @property int|null $bstValorizar
 * @property string|null $dfeIngreso
 * @property string|null $cciTalla
 * @property string|null $cciFill
 * @property string|null $cciCobertura
 * @property string|null $cciTipoProducto
 * @property int $bstEtiqueta
 * @property int $bstCarton_Base
 * @property int $bstEstuche
 * @property int $bstTerEncogido
 * @property int $bstTapaAdicional
 * @property string $fechaCreacion
 * @property string|null $ctpLTM
 * @property string|null $nombreProducto
 * @property int|null $prospecto
 * @property float|null $PesoNeto
 * @property int|null $idEnvase
 * @property string|null $idTipoProducto
 * @property string|null $usuarioIngreso
 * @property string|null $fechaIngreso
 * @property string|null $usuarioModifica
 * @property string|null $fechaModifica
 * @property string|null $nombreProductoFT
 *
 * @property ConsignacionD[] $consignacionDs
 * @property EnfriamientoLatasDetalle[] $enfriamientoLatasDetalles
 * @property PlanProduccion[] $planProduccions
 * @property ProductoPrecio $productoPrecio
 * @property ProductosProspecto $productosProspecto
 * @property TblPreLiquidaEmbalado[] $tblPreLiquidaEmbalados
 * @property TblTalla $cciTalla0
 * @property TblStockAtun[] $tblStockAtuns
 * @property TblStockConsignacion[] $tblStockConsignacions
 * @property VentasConsumidorFinalD[] $ventasConsumidorFinalDs
 */
class TblProducto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TblProducto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cciProducto', 'cciProceso', 'cciEmbalaje', 'cciUmedida', 'cciSClase', 'cciClase', 'cciTipo', 'nqnOrden', 'btpProdEsp', 'bstProducto'], 'required'],
            [['nqnOrden', 'nqnRetractil', 'PesoNeto'], 'number'],
            [['btpProdEsp', 'bstProducto', 'bstValorizar', 'bstEtiqueta', 'bstCarton_Base', 'bstEstuche', 'bstTerEncogido', 'bstTapaAdicional', 'prospecto', 'idEnvase'], 'integer'],
            [['dfeIngreso', 'fechaCreacion', 'fechaIngreso', 'fechaModifica'], 'safe'],
            [['cciProducto', 'cciProceso', 'cciPresentacion', 'cciRegimen', 'cciEspecie', 'cciEstadoProducto', 'cciAlmacenamiento', 'cciMarca', 'cciClasificacion', 'cciEmbalaje', 'cciUmedida', 'cciSClase', 'cciClase', 'cciTipo', 'cciTipoLimpieza', 'ctpLTM', 'idTipoProducto'], 'string', 'max' => 6],
            [['cnoProductoEsp', 'cnoProductoPrd', 'cnoProductoExp', 'cnoProductoCorto', 'cnoProductoGuia'], 'string', 'max' => 200],
            [['cciTalla'], 'string', 'max' => 10],
            [['cciFill', 'cciCobertura', 'cciTipoProducto'], 'string', 'max' => 3],
            [['nombreProducto', 'nombreProductoFT'], 'string', 'max' => 250],
            [['usuarioIngreso', 'usuarioModifica'], 'string', 'max' => 20],
            [['cciProducto'], 'unique'],
            [['cciTalla'], 'exist', 'skipOnError' => true, 'targetClass' => TblTalla::className(), 'targetAttribute' => ['cciTalla' => 'cciTalla']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cciProducto' => 'Cci Producto',
            'cciProceso' => 'Cci Proceso',
            'cciPresentacion' => 'Cci Presentacion',
            'cciRegimen' => 'Cci Regimen',
            'cciEspecie' => 'Cci Especie',
            'cciEstadoProducto' => 'Cci Estado Producto',
            'cciAlmacenamiento' => 'Cci Almacenamiento',
            'cciMarca' => 'Cci Marca',
            'cciClasificacion' => 'Cci Clasificacion',
            'cciEmbalaje' => 'Cci Embalaje',
            'cciUmedida' => 'Cci Umedida',
            'cciSClase' => 'Cci S Clase',
            'cciClase' => 'Cci Clase',
            'cciTipo' => 'Cci Tipo',
            'cciTipoLimpieza' => 'Cci Tipo Limpieza',
            'cnoProductoEsp' => 'Cno Producto Esp',
            'cnoProductoPrd' => 'Cno Producto Prd',
            'cnoProductoExp' => 'Cno Producto Exp',
            'cnoProductoCorto' => 'Cno Producto Corto',
            'cnoProductoGuia' => 'Cno Producto Guia',
            'nqnOrden' => 'Nqn Orden',
            'nqnRetractil' => 'Nqn Retractil',
            'btpProdEsp' => 'Btp Prod Esp',
            'bstProducto' => 'Bst Producto',
            'bstValorizar' => 'Bst Valorizar',
            'dfeIngreso' => 'Dfe Ingreso',
            'cciTalla' => 'Cci Talla',
            'cciFill' => 'Cci Fill',
            'cciCobertura' => 'Cci Cobertura',
            'cciTipoProducto' => 'Cci Tipo Producto',
            'bstEtiqueta' => 'Bst Etiqueta',
            'bstCarton_Base' => 'Bst Carton Base',
            'bstEstuche' => 'Bst Estuche',
            'bstTerEncogido' => 'Bst Ter Encogido',
            'bstTapaAdicional' => 'Bst Tapa Adicional',
            'fechaCreacion' => 'Fecha Creacion',
            'ctpLTM' => 'Ctp Ltm',
            'nombreProducto' => 'Nombre Producto',
            'prospecto' => 'Prospecto',
            'PesoNeto' => 'Peso Neto',
            'idEnvase' => 'Id Envase',
            'idTipoProducto' => 'Id Tipo Producto',
            'usuarioIngreso' => 'Usuario Ingreso',
            'fechaIngreso' => 'Fecha Ingreso',
            'usuarioModifica' => 'Usuario Modifica',
            'fechaModifica' => 'Fecha Modifica',
            'nombreProductoFT' => 'Nombre Producto Ft',
        ];
    }

    /**
     * Gets query for [[ConsignacionDs]].
     *
     * @return \yii\db\ActiveQuery|ConsignacionDQuery
     */
    public function getConsignacionDs()
    {
        return $this->hasMany(ConsignacionD::className(), ['ProductoId' => 'cciProducto']);
    }

    /**
     * Gets query for [[EnfriamientoLatasDetalles]].
     *
     * @return \yii\db\ActiveQuery|EnfriamientoLatasDetalleQuery
     */
    public function getEnfriamientoLatasDetalles()
    {
        return $this->hasMany(EnfriamientoLatasDetalle::className(), ['producto' => 'cciProducto']);
    }

    /**
     * Gets query for [[PlanProduccions]].
     *
     * @return \yii\db\ActiveQuery|PlanProduccionQuery
     */
    public function getPlanProduccions()
    {
        return $this->hasMany(PlanProduccion::className(), ['IdProducto' => 'cciProducto']);
    }

    /**
     * Gets query for [[ProductoPrecio]].
     *
     * @return \yii\db\ActiveQuery|ProductoPrecioQuery
     */
    public function getProductoPrecio()
    {
        return $this->hasOne(ProductoPrecio::className(), ['IdProducto' => 'cciProducto']);
    }

    /**
     * Gets query for [[ProductosProspecto]].
     *
     * @return \yii\db\ActiveQuery|ProductosProspectoQuery
     */
    public function getProductosProspecto()
    {
        return $this->hasOne(ProductosProspecto::className(), ['idProducto' => 'cciProducto']);
    }

    /**
     * Gets query for [[TblPreLiquidaEmbalados]].
     *
     * @return \yii\db\ActiveQuery|TblPreLiquidaEmbaladoQuery
     */
    public function getTblPreLiquidaEmbalados()
    {
        return $this->hasMany(TblPreLiquidaEmbalado::className(), ['Especie' => 'cciProducto']);
    }

    /**
     * Gets query for [[CciTalla0]].
     *
     * @return \yii\db\ActiveQuery|TblTallaQuery
     */
    public function getCciTalla0()
    {
        return $this->hasOne(TblTalla::className(), ['cciTalla' => 'cciTalla']);
    }

    /**
     * Gets query for [[TblStockAtuns]].
     *
     * @return \yii\db\ActiveQuery|TblStockAtunQuery
     */
    public function getTblStockAtuns()
    {
        return $this->hasMany(TblStockAtun::className(), ['cciProducto' => 'cciProducto']);
    }

    /**
     * Gets query for [[TblStockConsignacions]].
     *
     * @return \yii\db\ActiveQuery|TblStockConsignacionQuery
     */
    public function getTblStockConsignacions()
    {
        return $this->hasMany(TblStockConsignacion::className(), ['cciProducto' => 'cciProducto']);
    }

    /**
     * Gets query for [[VentasConsumidorFinalDs]].
     *
     * @return \yii\db\ActiveQuery|VentasConsumidorFinalDQuery
     */
    public function getVentasConsumidorFinalDs()
    {
        return $this->hasMany(VentasConsumidorFinalD::className(), ['cciProductoSPA' => 'cciProducto']);
    }

    /**
     * {@inheritdoc}
     * @return TblProductoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TblProductoQuery(get_called_class());
    }
}
