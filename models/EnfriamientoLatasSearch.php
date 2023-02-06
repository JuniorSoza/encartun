<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EnfriamientoLatas;

/**
 * EnfriamientoLatasSearch represents the model behind the search form of `app\models\EnfriamientoLatas`.
 */
class EnfriamientoLatasSearch extends EnfriamientoLatas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parada'], 'integer'],
            [['fechaProduccion', 'autoClave'], 'safe'],
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
        $query = EnfriamientoLatas::find();

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
            'id' => $this->id,
            'fechaProduccion' => $this->fechaProduccion,
            'parada' => $this->parada,
        ]);

        $query->andFilterWhere(['like', 'autoClave', $this->autoClave]);

        return $dataProvider;
    }
}
