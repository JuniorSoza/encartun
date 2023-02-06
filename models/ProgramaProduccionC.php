<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ProgramaProduccionC".
 *
 * @property int $nciProgramacion
 * @property string $dfeProgramacion
 * @property int $nciTurno
 * @property int $nqnKilosMP
 * @property string $cobProgramacion
 * @property string $cstProgramacion
 * @property string $proceso
 * @property int $nciRequisicion
 * @property int $idCompromiso_MP_AM
 * @property int $idCompromiso_MP_EU
 * @property int $idCompromiso_PT_AM
 * @property int $idCompromiso_PT_EU
 * @property string $cciUsuarioCrea
 * @property string $dfeCreacion
 * @property string|null $cciUsuarioModi
 * @property string|null $dfeModifica
 */
class ProgramaProduccionC extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProgramaProduccionC';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nciProgramacion', 'dfeProgramacion', 'nciTurno', 'nqnKilosMP', 'cstProgramacion', 'proceso', 'idCompromiso_MP_AM', 'idCompromiso_MP_EU', 'idCompromiso_PT_AM', 'idCompromiso_PT_EU'], 'required'],
            [['nciProgramacion', 'nciTurno', 'nqnKilosMP', 'nciRequisicion', 'idCompromiso_MP_AM', 'idCompromiso_MP_EU', 'idCompromiso_PT_AM', 'idCompromiso_PT_EU'], 'integer'],
            [['dfeProgramacion', 'dfeCreacion', 'dfeModifica'], 'safe'],
            [['cobProgramacion'], 'string', 'max' => 255],
            [['cstProgramacion'], 'string', 'max' => 1],
            [['proceso'], 'string', 'max' => 2],
            [['cciUsuarioCrea', 'cciUsuarioModi'], 'string', 'max' => 25],
            [['nciProgramacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nciProgramacion' => 'Nci Programacion',
            'dfeProgramacion' => 'Dfe Programacion',
            'nciTurno' => 'Nci Turno',
            'nqnKilosMP' => 'Nqn Kilos Mp',
            'cobProgramacion' => 'Cob Programacion',
            'cstProgramacion' => 'Cst Programacion',
            'proceso' => 'Proceso',
            'nciRequisicion' => 'Nci Requisicion',
            'idCompromiso_MP_AM' => 'Id Compromiso Mp Am',
            'idCompromiso_MP_EU' => 'Id Compromiso Mp Eu',
            'idCompromiso_PT_AM' => 'Id Compromiso Pt Am',
            'idCompromiso_PT_EU' => 'Id Compromiso Pt Eu',
            'cciUsuarioCrea' => 'Cci Usuario Crea',
            'dfeCreacion' => 'Dfe Creacion',
            'cciUsuarioModi' => 'Cci Usuario Modi',
            'dfeModifica' => 'Dfe Modifica',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionCQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProgramaProduccionCQuery(get_called_class());
    }
}
