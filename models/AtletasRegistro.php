<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atletas.registro".
 *
 * @property int $id
 * @property int|null $id_club
 * @property int|null $id_escuela
 * @property int|null $id_representante
 * @property int|null $id_alergias
 * @property int|null $id_enfermedades
 * @property int|null $id_discapacidad
 * @property string|null $p_nombre
 * @property string|null $s_nombre
 * @property string|null $p_apellido
 * @property string|null $s_apellido
 * @property int|null $id_nac
 * @property string|null $identificacion
 * @property string|null $fn
 * @property int|null $sexo
 * @property float|null $estatura
 * @property float|null $peso
 * @property string|null $talla_franela
 * @property string|null $talla_short
 * @property string|null $cell
 * @property string|null $telf
 * @property bool|null $asma
 * @property string|null $d_creacion
 * @property int|null $u_creacion
 * @property string|null $d_update
 * @property int|null $u_update
 * @property bool|null $eliminado
 * @property string|null $dir_ip
 * @property string|null $nombreEscuelaClub
 * @property string|null $categoria
 * 
 * @property Escuela $escuela
 * @property Representante $representante
 */
class AtletasRegistro extends \yii\db\ActiveRecord
{
    public  $p_nombre_representante;
    public  $s_nombre_representante;
    public  $p_apellido_representante;
    public  $s_apellido_representante;
    public  $id_nac_representante;
    public  $identificacion_representante;
    public  $cell_representante;
    public  $telf_representante;
    public  $nombreEscuelaClub;
    public  $categoria;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atletas.registro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identificacion_representante','id_nac_representante','id_club', 'id_escuela', 'id_representante', 'id_alergias', 'id_enfermedades', 'id_discapacidad', 'id_nac', 'identificacion', 'sexo', 'u_creacion', 'u_update'], 'default'],
            [['identificacion_representante','id_nac_representante','id_club', 'id_escuela', 'id_representante', 'id_alergias', 'id_enfermedades', 'id_discapacidad', 'id_nac',  'sexo', 'u_creacion', 'u_update'], 'integer'],
            [['nombreEscuelaClub','telf_representante','cell_representante','s_apellido_representante','p_apellido_representante','p_nombre_representante','s_nombre_representante','p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'talla_franela', 'talla_short', 'cell', 'telf', 'dir_ip','identificacion'], 'string'],
            [['fn', 'd_creacion', 'd_update'], 'safe'],
            [['estatura', 'peso'], 'number'],
            [['asma', 'eliminado'], 'boolean'],
            [['identificacion_representante','id_nac_representante','id_nac', 'identificacion', 'sexo','nombreEscuelaClub','telf_representante','cell_representante','s_apellido_representante','p_apellido_representante','p_nombre_representante','s_nombre_representante','p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'talla_franela', 'talla_short', 'cell', 'telf', 'fn','estatura'], 'required'],
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
            'id_representante' => 'Id Representante',
            'id_alergias' => 'Id Alergias',
            'id_enfermedades' => 'Id Enfermedades',
            'id_discapacidad' => 'Id Discapacidad',
            'p_nombre' => 'P Nombre',
            's_nombre' => 'S Nombre',
            'p_apellido' => 'P Apellido',
            's_apellido' => 'S Apellido',
            'id_nac' => 'Id Nac',
            'identificacion' => 'Identificacion',
            'fn' => 'Fn',
            'sexo' => 'Sexo',
            'estatura' => 'Estatura',
            'peso' => 'Peso',
            'talla_franela' => 'Talla Franela',
            'talla_short' => 'Talla Short',
            'cell' => 'Cell',
            'telf' => 'Telf',
            'asma' => 'Asma',
            'd_creacion' => 'D Creacion',
            'u_creacion' => 'U Creacion',
            'd_update' => 'D Update',
            'u_update' => 'U Update',
            'eliminado' => 'Eliminado',
            'dir_ip' => 'Dir Ip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEscuela()
    {
        return $this->hasOne(Escuela::class, ['id' => 'id_escuela']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepresentante()
    {
        return $this->hasOne(RegistroRepresentantes::class, ['id' => 'id_representante']);
    }

    /**
     * Gets query for [[AportesSemanales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAportes()
    {
        return $this->hasMany(AportesSemanales::className(), ['atleta_id' => 'id']);
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
            'identificacion', 'talla_franela', 'talla_short',
            'cell', 'telf', 'dir_ip'
        ];

        foreach ($upperCaseFields as $field) {
            if (!empty($this->$field) && is_string($this->$field)) {
                $this->$field = mb_strtoupper(trim($this->$field), 'UTF-8');
            }
        }

        return true;
    }

    /**
     * Invalidar caché después de guardar
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (class_exists('app\components\AtletasCache')) {
            \app\components\AtletasCache::invalidateCache();
        }
    }

    /**
     * Invalidar caché después de eliminar
     */
    public function afterDelete()
    {
        parent::afterDelete();
        if (class_exists('app\components\AtletasCache')) {
            \app\components\AtletasCache::invalidateCache();
        }
    }
}