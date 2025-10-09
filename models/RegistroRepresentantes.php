<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atletas.registro_reprentantes".
 */
class RegistroRepresentantes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atletas.registro_reprentantes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_club', 'id_escuela', 'id_nac', 'identificacion', 'u_creacion', 'u_update'], 'integer'],
            [['p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'cell', 'telf', 'dir_ip'], 'string'],
            [['d_creacion', 'd_update'], 'safe'],
            [['eliminado'], 'boolean'],
            [['d_creacion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_club' => 'Id Club',
            'id_escuela' => 'Id Escuela',
            'p_nombre' => 'P Nombre',
            's_nombre' => 'S Nombre',
            'p_apellido' => 'P Apellido',
            's_apellido' => 'S Apellido',
            'id_nac' => 'Id Nac',
            'identificacion' => 'Identificacion',
            'cell' => 'Cell',
            'telf' => 'Telf',
            'd_creacion' => 'D Creacion',
            'u_creacion' => 'U Creacion',
            'd_update' => 'D Update',
            'u_update' => 'U Update',
            'eliminado' => 'Eliminado',
            'dir_ip' => 'Dir Ip',
        ];
    }

    /**
     * Convertir a mayúsculas antes de guardar
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Lista de campos que deben convertirse a mayúsculas
        $upperCaseFields = [
            'p_nombre', 's_nombre', 'p_apellido', 's_apellido',
            'cell', 'telf', 'dir_ip'
        ];

        foreach ($upperCaseFields as $field) {
            if (!empty($this->$field) && is_string($this->$field)) {
                $this->$field = mb_strtoupper(trim($this->$field), 'UTF-8');
            }
        }

        // Convertir identificación a string y luego a mayúsculas si es necesario
        if (!empty($this->identificacion)) {
            $this->identificacion = (string)$this->identificacion;
        }

        return true;
    }
}