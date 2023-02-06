<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnfriamientoLatas".
 *
 * @property int $id
 * @property string $fechaProduccion
 * @property int $turno 
 * @property string $autoClave
 * @property int $parada
 * @property string|null $cochesNoIncluir 
 *
 * @property EnfriamientoLatasDetalle[] $enfriamientoLatasDetalles
 */
class EnfriamientoLatas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EnfriamientoLatas';
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
            [['fechaProduccion', 'turno', 'autoClave', 'parada'], 'required'],
            [['fechaProduccion'], 'safe'],
            [['turno', 'parada'], 'integer'],
            [['autoClave'], 'string', 'max' => 10],
            [['cochesNoIncluir'], 'string', 'max' => 500],
          /*  [['fechaProduccion', 'turno', 'autoClave', 'parada'], 'unique', 'targetAttribute' => ['fechaProduccion', 'turno', 'autoClave', 'parada']]*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fechaProduccion' => 'Fecha Produccion',
            'turno' => 'Turno',
            'autoClave' => 'Auto Clave',
            'parada' => 'Parada',
            'cochesNoIncluir' => 'Coches No Recibidos'
        ];
    }

    /**
     * Gets query for [[EnfriamientoLatasDetalles]].
     *
     * @return \yii\db\ActiveQuery|EnfriamientoLatasDetalleQuery
     */
    public function getEnfriamientoLatasDetalles()
    {
        return $this->hasMany(EnfriamientoLatasDetalle::className(), ['idEnfriamiento' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EnfriamientoLatasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EnfriamientoLatasQuery(get_called_class());
    }
}
