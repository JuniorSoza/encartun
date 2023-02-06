<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametroBalanza".
 *
 * @property int $id
 * @property string $fecha
 * @property string|null $linea
 * @property string|null $item
 * @property string|null $unidad
 * @property float|null $pesoNominal
 * @property float|null $tara
 * @property float|null $maximo
 * @property float|null $minimo
 * @property float|null $valor1
 * @property float|null $valor2
 * @property int|null $of
 */
class parametroBalanza extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parametroBalanza';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha','of'], 'safe'],
            [['pesoNominal', 'tara', 'maximo', 'minimo', 'valor1', 'valor2', 'of'], 'number'],
            [['of'], 'integer'],
            [['linea'], 'string', 'max' => 50],
            [['item'], 'string', 'max' => 250],
            [['unidad'], 'string', 'max' => 2],
            [['of'], 'integer', 'min' => 1],
             [['fecha', 'linea', 'op', 'of','item','pesoNominal','valor2','valor1','maximo','minimo'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'linea' => 'Linea',
            'item' => 'Item',
            'unidad' => 'Unidad',
            'pesoNominal' => 'Peso Nominal',
            'tara' => 'Tara',
            'maximo' => 'Maximo',
            'minimo' => 'Minimo',
            'valor1' => 'Valor1',
            'valor2' => 'Valor2',
            'of' => 'Of',
        ];
    }

    /**
     * {@inheritdoc}
     * @return parametroBalanzaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new parametroBalanzaQuery(get_called_class());
    }
}
