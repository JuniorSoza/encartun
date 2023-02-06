<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProgramaProduccionC]].
 *
 * @see ProgramaProduccionC
 */
class ProgramaProduccionCQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionC[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionC|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
