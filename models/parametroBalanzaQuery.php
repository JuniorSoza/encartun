<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[parametroBalanza]].
 *
 * @see parametroBalanza
 */
class parametroBalanzaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return parametroBalanza[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return parametroBalanza|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
