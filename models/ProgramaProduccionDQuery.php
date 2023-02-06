<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProgramaProduccionD]].
 *
 * @see ProgramaProduccionD
 */
class ProgramaProduccionDQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionD[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionD|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function buscarOFxDia($fechaProgramacion, $turnoProgramacion)
    {
        $fechaProgramacion = '31-01-2020';
        $ofPT = parent::joinWith(['fKProgramaProduccionC A'], true, 'INNER JOIN')->select('ProgramaProduccionD.ordenFabricacion_PT, ProgramaProduccionD.ordenFabricacion_PT')->where(['IN', 'A.proceso', ['LT']])
        ->andWhere(['A.dfeProgramacion' => $fechaProgramacion])
        ->andWhere(['A.nciTurno' => $turnoProgramacion])->all();

        //->where(['A.dfeProgramacion' => $fechaProgramacion], ['A.nciTurno' => $turnoProgramacion],['IN', 'A.proceso', 'PO'])->all();
        return $ofPT;
    }
}
