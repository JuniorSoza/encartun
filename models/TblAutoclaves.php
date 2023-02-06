<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TblAutoclaves".
 *
 * @property string $cciAutoclave
 * @property string $cnoAutoclave
 * @property int $bstAutoclave
 */
class TblAutoclaves extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TblAutoclaves';
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
            [['cciAutoclave', 'cnoAutoclave', 'bstAutoclave'], 'required'],
            [['bstAutoclave'], 'integer'],
            [['cciAutoclave'], 'string', 'max' => 6],
            [['cnoAutoclave'], 'string', 'max' => 50],
            [['cciAutoclave'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cciAutoclave' => 'Cci Autoclave',
            'cnoAutoclave' => 'Cno Autoclave',
            'bstAutoclave' => 'Bst Autoclave',
        ];
    }
}
