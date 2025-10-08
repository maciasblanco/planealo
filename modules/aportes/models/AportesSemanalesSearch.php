<?php

namespace app\modules\aportes\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\aportes\models\AportesSemanales;

/**
 * AportesSemanalesSearch represents the model behind the search form of `app\modules\aportes\models\AportesSemanales`.
 */
class AportesSemanalesSearch extends AportesSemanales
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'atleta_id', 'escuela_id', 'numero_semana'], 'integer'],
            [['fecha_viernes', 'fecha_pago', 'estado', 'metodo_pago', 'comentarios', 'created_at'], 'safe'],
            [['monto'], 'number'],
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
        $query = AportesSemanales::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['fecha_viernes' => SORT_DESC]]
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
            'atleta_id' => $this->atleta_id,
            'escuela_id' => $this->escuela_id,
            'fecha_viernes' => $this->fecha_viernes,
            'numero_semana' => $this->numero_semana,
            'monto' => $this->monto,
            'fecha_pago' => $this->fecha_pago,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'metodo_pago', $this->metodo_pago])
            ->andFilterWhere(['like', 'comentarios', $this->comentarios]);

        return $dataProvider;
    }
}