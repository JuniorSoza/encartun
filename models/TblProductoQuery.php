<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TblProducto]].
 *
 * @see TblProducto
 */
class TblProductoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TblProducto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TblProducto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
