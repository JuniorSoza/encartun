<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tblEtiquetadoras;

/**
 * tblEtiquetadorasSearch represents the model behind the search form of `app\models\tblEtiquetadoras`.
 */
class tblEtiquetadorasSearch extends tblEtiquetadoras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cciEtiquetadora', 'cnoEtiquetadora', 'cciTipo'], 'safe'],
            [['bstEtiquetadora'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = tblEtiquetadoras::find()->where(['cciTipo' => 'CE']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'bstEtiquetadora' => $this->bstEtiquetadora,
        ]);

        $query->andFilterWhere(['like', 'cciEtiquetadora', $this->cciEtiquetadora])
            ->andFilterWhere(['like', 'cnoEtiquetadora', $this->cnoEtiquetadora])
            ->andFilterWhere(['like', 'cciTipo', $this->cciTipo]);

        return $dataProvider;
    }
}
