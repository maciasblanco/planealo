<?php
namespace app\models;

use Yii;
use app\AtletasRegistro;  // Namespace correcto
use app\Escuela;   // Namespace correcto
use app\Club;   // Namespace correcto
class AportesSemanales extends \yii\db\ActiveRecord
{
    const MONTO_SEMANAL = 2.00;
    
    public static function tableName()
    {
        return 'contabilidad.aportes_semanales';  // Esquema correcto
    }

    public function rules()
    {
        return [
            [['atleta_id', 'escuela_id', 'fecha_viernes', 'numero_semana'], 'required'],
            [['atleta_id', 'escuela_id', 'numero_semana'], 'integer'],
            [['monto'], 'number'],
            [['monto'], 'default', 'value' => self::MONTO_SEMANAL],
            [['fecha_viernes', 'fecha_pago'], 'safe'],
            [['estado', 'metodo_pago', 'comentarios'], 'string'],
            [['estado'], 'default', 'value' => 'pendiente'],
            [['atleta_id'], 'exist', 'skipOnError' => true, 
             'targetClass' => Registro::class, 'targetAttribute' => ['atleta_id' => 'id']],
            [['escuela_id'], 'exist', 'skipOnError' => true, 
             'targetClass' => Escuela::class, 'targetAttribute' => ['escuela_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'atleta_id' => 'Atleta',
            'escuela_id' => 'Escuela',
            'fecha_viernes' => 'Viernes de la Semana',
            'numero_semana' => 'Número de Semana',
            'monto' => 'Monto ($)',
            'fecha_pago' => 'Fecha de Pago Real',
            'estado' => 'Estado',
            'metodo_pago' => 'Método de Pago',
            'comentarios' => 'Comentarios',
            'created_at' => 'Fecha Registro',
        ];
    }

    /**
     * Gets query for [[Atleta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtleta()
    {
        return $this->hasOne(AtletasRegistro::className(), ['id' => 'atleta_id']);
    }

    /**
     * Gets query for [[Escuela]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEscuela()
    {
        return $this->hasOne(Escuela::className(), ['id' => 'escuela_id']);
    }

    /**
     * Calcula la deuda total de un atleta
     */
    public static function getDeudaAtleta($atleta_id)
    {
        return self::find()
            ->where(['atleta_id' => $atleta_id, 'estado' => 'pendiente'])
            ->sum('monto') ?? 0;
    }

    /**
     * Obtiene el viernes de la semana actual
     */
    public static function getViernesActual()
    {
        $hoy = date('Y-m-d');
        $diaSemana = date('N', strtotime($hoy));
        
        // Si hoy es viernes (5), devolver hoy, sino calcular el viernes anterior
        if ($diaSemana == 5) {
            return $hoy;
        } else {
            return date('Y-m-d', strtotime('last friday', strtotime($hoy)));
        }
    }

    /**
     * Obtiene el número de semana del año
     */
    public static function getNumeroSemana($fecha)
    {
        return date('W', strtotime($fecha));
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
                // Si no se especifica monto, usar el monto fijo
                if (!$this->monto) {
                    $this->monto = self::MONTO_SEMANAL;
                }
            }
            return true;
        }
        return false;
    }
}