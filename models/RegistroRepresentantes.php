<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atletas.registro_reprentantes".
 *
 * @property int $id
 * @property int|null $id_club
 * @property int|null $id_escuela
 * @property string|null $p_nombre
 * @property string|null $s_nombre
 * @property string|null $p_apellido
 * @property string|null $s_apellido
 * @property int|null $id_nac
 * @property int|null $identificacion
 * @property string|null $cell
 * @property string|null $telf
 * @property string|null $d_creacion
 * @property int|null $u_creacion
 * @property string|null $d_update
 * @property int|null $u_update
 * @property bool|null $eliminado
 * @property string|null $dir_ip
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
            [['id_club', 'id_escuela', 'id_nac', 'identificacion', 'u_creacion', 'u_update'], 'default', 'value' => null],
            [['id_club', 'id_escuela', 'id_nac', 'identificacion', 'u_creacion', 'u_update'], 'integer'],
            [['p_nombre', 's_nombre', 'p_apellido', 's_apellido', 'cell', 'telf', 'dir_ip'], 'string'],
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
}
