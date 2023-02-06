<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EnfriamientoLatasDetalle;

/**
 * EnfriamientoLatasDetalleSearch represents the model behind the search form of `app\models\EnfriamientoLatasDetalle`.
 */
class EnfriamientoLatasDetalleSearch extends EnfriamientoLatasDetalle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEnfriamiento', 'ordenProduccion', 'ordenFabricacion', 'pesoNeto', 'coche', 'parada', 'latas', 'horasStdConfiguracion'], 'integer'],
            [['loteProduccion', 'producto', 'marca', 'codigoLata', 'autoClave', 'inicioEnfriamiento', 'finEnfriamiento'], 'safe'],
            [['idAutoclave'], 'number'],
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
        $query = EnfriamientoLatasDetalle::find();

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
            'idEnfriamiento' => $this->idEnfriamiento,
            'idAutoclave' => $this->idAutoclave,
            'ordenProduccion' => $this->ordenProduccion,
            'nombreProducto' => $this->nombreProducto,
            'ordenFabricacion' => $this->ordenFabricacion,
            'pesoNeto' => $this->pesoNeto,
            'coche' => $this->coche,
            'parada' => $this->parada,
            'latas' => $this->latas,
            'inicioEnfriamiento' => $this->inicioEnfriamiento,
            'horasStdConfiguracion' => $this->horasStdConfiguracion,
            'finEnfriamiento' => $this->finEnfriamiento,
        ]);

        $query->andFilterWhere(['like', 'loteProduccion', $this->loteProduccion])
            ->andFilterWhere(['like', 'producto', $this->producto])
            ->andFilterWhere(['like', 'nombreProducto', $this->nombreProducto])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'codigoLata', $this->codigoLata])
            ->andFilterWhere(['like', 'autoClave', $this->autoClave])
            ->andFilterWhere(['=', 'asignado', 0]);

        return $dataProvider;
    }
}
