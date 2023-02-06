<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblEtiquetadoras".
 *
 * @property string $cciEtiquetadora
 * @property string $cnoEtiquetadora
 * @property int $bstEtiquetadora
 * @property string $cciTipo
 */
class tblEtiquetadoras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tblEtiquetadoras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cciEtiquetadora', 'cnoEtiquetadora', 'bstEtiquetadora'], 'required'],
            [['bstEtiquetadora'], 'integer'],
            [['cciEtiquetadora'], 'string', 'max' => 6],
            [['cnoEtiquetadora'], 'string', 'max' => 30],
            [['cciTipo'], 'string', 'max' => 2],
            [['cciEtiquetadora'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cciEtiquetadora' => 'Cci Etiquetadora',
            'cnoEtiquetadora' => 'Cno Etiquetadora',
            'bstEtiquetadora' => 'Bst Etiquetadora',
            'cciTipo' => 'Cci Tipo',
        ];
    }
}