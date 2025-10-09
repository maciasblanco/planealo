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
        // QUERY ORIGINAL - Vamos a mantener la estructura original pero optimizada
        $query = AtletasRegistro::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // PRECARGAR RELACIONES para evitar consultas N+1
        $query->with(['escuela']);

        // grid filtering conditions - MANTENER condiciones originales pero optimizadas
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
            'eliminado' => $this->eliminado, // Mantener el filtro original
        ]);

        // Optimizar filtros de texto - solo aplicar si tienen valor
        if (!empty($this->p_nombre)) {
            $query->andFilterWhere(['ilike', 'p_nombre', $this->p_nombre]);
        }
        
        if (!empty($this->s_nombre)) {
            $query->andFilterWhere(['ilike', 's_nombre', $this->s_nombre]);
        }

        if (!empty($this->p_apellido)) {
            $query->andFilterWhere(['ilike', 'p_apellido', $this->p_apellido]);
        }

        if (!empty($this->s_apellido)) {
            $query->andFilterWhere(['ilike', 's_apellido', $this->s_apellido]);
        }

        if (!empty($this->talla_franela)) {
            $query->andFilterWhere(['ilike', 'talla_franela', $this->talla_franela]);
        }

        if (!empty($this->talla_short)) {
            $query->andFilterWhere(['ilike', 'talla_short', $this->talla_short]);
        }

        if (!empty($this->cell)) {
            $query->andFilterWhere(['ilike', 'cell', $this->cell]);
        }

        if (!empty($this->telf)) {
            $query->andFilterWhere(['ilike', 'telf', $this->telf]);
        }

        if (!empty($this->dir_ip)) {
            $query->andFilterWhere(['ilike', 'dir_ip', $this->dir_ip]);
        }

        return $dataProvider;
    }
}