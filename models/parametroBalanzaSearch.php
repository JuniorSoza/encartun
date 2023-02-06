<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\parametroBalanza;

/**
 * parametroBalanzaSearch represents the model behind the search form of `app\models\parametroBalanza`.
 */
class parametroBalanzaSearch extends parametroBalanza
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'of'], 'integer'],
            [['fecha', 'linea', 'item', 'unidad'], 'safe'],
            [['pesoNominal', 'tara', 'maximo', 'minimo', 'valor1', 'valor2'], 'number'],
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
        $query = parametroBalanza::find();

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
            'fecha' => $this->fecha,
            'pesoNominal' => $this->pesoNominal,
            'tara' => $this->tara,
            'maximo' => $this->maximo,
            'minimo' => $this->minimo,
            'valor1' => $this->valor1,
            'valor2' => $this->valor2,
            'of' => $this->of,
            'op' => $this->op,
        ]);

        $query->andFilterWhere(['like', 'linea', $this->linea])
            ->andFilterWhere(['like', 'item', $this->item])
            ->andFilterWhere(['like', 'unidad', $this->unidad]);

        return $dataProvider;
    }
}
