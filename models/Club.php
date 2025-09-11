<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atletas.club".
 *
 * @property int $id
 * @property int|null $id_escuela
 * @property int|null $id_estado
 * @property int|null $id_municipio
 * @property int|null $id_parroquia
 * @property string|null $direccion_administrativa
 * @property string|null $direccion_practicas
 * @property float|null $lat
 * @property float|null $lng
 * @property string $nombre
 * @property string|null $d_creacion
 * @property int|null $u_creacion
 * @property string|null $d_update
 * @property int|null $u_update
 * @property bool|null $eliminado
 * @property string|null $dir_ip
 */
class Club extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atletas.club';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_escuela', 'id_estado', 'id_municipio', 'id_parroquia', 'u_creacion', 'u_update'], 'default', 'value' => null],
            [['id_escuela', 'id_estado', 'id_municipio', 'id_parroquia', 'u_creacion', 'u_update'], 'integer'],
            [['direccion_administrativa', 'direccion_practicas', 'nombre', 'dir_ip'], 'string'],
            [['lat', 'lng'], 'number'],
            [['nombre'], 'required'],
            [['d_creacion', 'd_update'], 'safe'],
            [['eliminado'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_escuela' => 'Id Escuela',
            'id_estado' => 'Id Estado',
            'id_municipio' => 'Id Municipio',
            'id_parroquia' => 'Id Parroquia',
            'direccion_administrativa' => 'Direccion Administrativa',
            'direccion_practicas' => 'Direccion Practicas',
            'lat' => 'Lat',
            'lng' => 'Lng',
            'nombre' => 'Nombre',
            'd_creacion' => 'D Creacion',
            'u_creacion' => 'U Creacion',
            'd_update' => 'D Update',
            'u_update' => 'U Update',
            'eliminado' => 'Eliminado',
            'dir_ip' => 'Dir Ip',
        ];
    }
}
