<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnfriamientoLatasDetalle".
 *
 * @property int $idEnfriamiento
 * @property string $loteProduccion
 * @property float $idAutoclave
 * @property int $ordenProduccion
 * @property int $ordenFabricacion
 * @property string $producto
 * @property string $nombreProducto
 * @property int $pesoNeto
 * @property string $marca
 * @property string $nombreMarca
 * @property string $codigoLata
 * @property int $coche
 * @property string $autoClave
 * @property int $parada
 * @property int $latas
 * @property string $cajasLatas
 * @property string $inicioEnfriamiento
 * @property int $horasStdConfiguracion
 * @property string $finEnfriamiento
 * @property int $asignado
 *
 * @property TblProducto $producto0
 * @property EnfriamientoLatas $idEnfriamiento0
 */
class EnfriamientoLatasDetalle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EnfriamientoLatasDetalle';
    }

    public static function getDb()
    {
        return Yii::$app->get('db1');
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEnfriamiento', 'loteProduccion', 'idAutoclave', 'ordenProduccion', 'ordenFabricacion', 'producto', 'nombreProducto', 'pesoNeto', 'marca', 'nombreMarca', 'codigoLata', 'coche', 'autoClave', 'parada', 'latas', 'cajasLatas', 'inicioEnfriamiento', 'horasStdConfiguracion', 'finEnfriamiento', 'asignado'], 'required'],
            [['idEnfriamiento', 'ordenProduccion', 'ordenFabricacion', 'pesoNeto', 'coche', 'parada', 'latas', 'horasStdConfiguracion', 'asignado'], 'integer'],
            [['idAutoclave'], 'number'],
            [['inicioEnfriamiento', 'finEnfriamiento'], 'safe'],
            [['loteProduccion', 'codigoLata'], 'string', 'max' => 50],
            [['producto', 'marca'], 'string', 'max' => 6],
            [['nombreProducto', 'nombreMarca', 'cajasLatas'], 'string', 'max' => 200],
            [['autoClave'], 'string', 'max' => 10],
            [['idAutoclave', 'idEnfriamiento'], 'unique', 'targetAttribute' => ['idAutoclave', 'idEnfriamiento']],
            [['producto'], 'exist', 'skipOnError' => true, 'targetClass' => TblProducto::className(), 'targetAttribute' => ['producto' => 'cciProducto']],
            [['idEnfriamiento'], 'exist', 'skipOnError' => true, 'targetClass' => EnfriamientoLatas::className(), 'targetAttribute' => ['idEnfriamiento' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEnfriamiento' => 'Id Enfriamiento',
            'loteProduccion' => 'Lote Produccion',
            'idAutoclave' => 'Id Autoclave',
            'ordenProduccion' => 'Orden Produccion',
            'ordenFabricacion' => 'Orden Fabricacion',
            'producto' => 'Producto',
            'nombreProducto' => 'Nombre Producto',
            'pesoNeto' => 'Peso Neto',
            'marca' => 'Marca',
            'nombreMarca' => 'Nombre Marca',
            'codigoLata' => 'Codigo Lata',
            'coche' => 'Coche',
            'autoClave' => 'Auto Clave',
            'parada' => 'Parada',
            'latas' => 'Latas',
            'cajasLatas' => 'Cajas Latas',
            'inicioEnfriamiento' => 'Inicio Enfriamiento',
            'horasStdConfiguracion' => 'Horas Std Configuracion',
            'finEnfriamiento' => 'Fin Enfriamiento',
            'asignado' => 'Asignado',
        ];
    }

    /**
     * Gets query for [[Producto0]].
     *
     * @return \yii\db\ActiveQuery|TblProductoQuery
     */
    public function getProducto0()
    {
        return $this->hasOne(TblProducto::className(), ['cciProducto' => 'producto']);
    }

    /**
     * Gets query for [[IdEnfriamiento0]].
     *
     * @return \yii\db\ActiveQuery|EnfriamientoLatasQuery
     */
    public function getIdEnfriamiento0()
    {
        return $this->hasOne(EnfriamientoLatas::className(), ['id' => 'idEnfriamiento']);
    }

    /**
     * {@inheritdoc}
     * @return EnfriamientoLatasDetalleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EnfriamientoLatasDetalleQuery(get_called_class());
    }
}
