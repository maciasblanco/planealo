<?php

namespace app\modules\atletas\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AtletasRegistro;

/**
 * AtletasRegistroSearch represents the model behind the search form of `app\models\AtletasRegistro`.
 */
class AtletasRegistroSearch extends AtletasRegistro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_club', 'id_escuela', 'id_representante', 'id_alergias', 'id_enfermedades', 'id_discapacidad', 'id_nac', 'identificacion', 'sexo', 'u_creacion', 'u_update'], 'integer'],
            [['p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'fn', 'talla_franela', 'talla_short', 'cell', 'telf', 'd_creacion', 'd_update', 'dir_ip'], 'safe'],
            [['estatura', 'peso'], 'number'],
            [['asma', 'eliminado'], 'boolean'],
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
        $query = AtletasRegistro::find();

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
        // Filtrar por escuela_id si está definido
            if ($this->id_escuela !== null) {
                $query->andWhere(['id_escuela' => $this->id_escuela]);
            }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_club' => $this->id_club,
            'id_escuela' => $this->id_escuela,
            'id_representante' => $this->id_representante,
            'id_alergias' => $this->id_alergias,
            'id_enfermedades' => $this->id_enfermedades,
            'id_discapacidad' => $this->id_discapacidad,
            'id_nac' => $this->id_nac,
            'identificacion' => $this->identificacion,
            'fn' => $this->fn,
            'sexo' => $this->sexo,
            'estatura' => $this->estatura,
            'peso' => $this->peso,
            'asma' => $this->asma,
            'd_creacion' => $this->d_creacion,
            'u_creacion' => $this->u_creacion,
            'd_update' => $this->d_update,
            'u_update' => $this->u_update,
            'eliminado' => $this->eliminado,
        ]);

        $query->andFilterWhere(['ilike', 'p_nombre', $this->p_nombre])
            ->andFilterWhere(['ilike', 's_nombre', $this->s_nombre])
            ->andFilterWhere(['ilike', 'p_apellido', $this->p_apellido])
            ->andFilterWhere(['ilike', 's_apellido', $this->s_apellido])
            ->andFilterWhere(['ilike', 'talla_franela', $this->talla_franela])
            ->andFilterWhere(['ilike', 'talla_short', $this->talla_short])
            ->andFilterWhere(['ilike', 'cell', $this->cell])
            ->andFilterWhere(['ilike', 'telf', $this->telf])
            ->andFilterWhere(['ilike', 'dir_ip', $this->dir_ip]);

        return $dataProvider;
    }
}
