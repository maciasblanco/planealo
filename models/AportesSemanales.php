<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "contabilidad.aportes_semanales".
 *
 * @property int $id
 * @property int $atleta_id
 * @property int $escuela_id
 * @property string $fecha_viernes
 * @property int $numero_semana
 * @property string $monto
 * @property string|null $fecha_pago
 * @property string $estado
 * @property string|null $metodo_pago
 * @property string|null $comentarios
 * @property string $created_at
 *
 * @property AtletasRegistro $atleta
 * @property Escuela $escuela
 */
class AportesSemanales extends \yii\db\ActiveRecord
{
    const MONTO_SEMANAL = 2.00;
    
    // Estados
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_CANCELADO = 'cancelado';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contabilidad.aportes_semanales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atleta_id', 'escuela_id', 'fecha_viernes', 'numero_semana'], 'required'],
            [['atleta_id', 'escuela_id', 'numero_semana'], 'integer'],
            [['fecha_viernes', 'fecha_pago', 'created_at'], 'safe'],
            [['monto'], 'number'],
            [['comentarios'], 'string'],
            [['estado', 'metodo_pago'], 'string', 'max' => 255],
            [['monto'], 'default', 'value' => self::MONTO_SEMANAL],
            [['estado'], 'default', 'value' => self::ESTADO_PENDIENTE],
            [['estado'], 'in', 'range' => [self::ESTADO_PENDIENTE, self::ESTADO_PAGADO, self::ESTADO_CANCELADO]],
            [['atleta_id'], 'exist', 'skipOnError' => true, 'targetClass' => AtletasRegistro::class, 'targetAttribute' => ['atleta_id' => 'id']],
            [['escuela_id'], 'exist', 'skipOnError' => true, 'targetClass' => Escuela::class, 'targetAttribute' => ['escuela_id' => 'id']],
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
        return $this->hasOne(AtletasRegistro::class, ['id' => 'atleta_id']);
    }

    /**
     * Gets query for [[Escuela]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEscuela()
    {
        return $this->hasOne(Escuela::class, ['id' => 'escuela_id']);
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
        $hoy = new \DateTime();
        $diaSemana = (int)$hoy->format('N'); // 1=lunes, 7=domingo
        
        // Si hoy es viernes (5), devolver hoy, sino calcular el último viernes
        if ($diaSemana === 5) {
            return $hoy->format('Y-m-d');
        } else {
            // Restar días para llegar al último viernes
            $diasRestar = $diaSemana < 5 ? $diaSemana + 2 : $diaSemana - 5;
            $hoy->modify("-$diasRestar days");
            return $hoy->format('Y-m-d');
        }
    }

    /**
     * Obtiene el número de semana del año
     */
    public static function getNumeroSemana($fecha)
    {
        $fechaObj = new \DateTime($fecha);
        return (int)$fechaObj->format('W');
    }

    /**
     * Before save: set created_at y monto fijo
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            // Siempre asegurar que el monto sea 2.00
            $this->monto = self::MONTO_SEMANAL;
            return true;
        }
        return false;
    }
    
    /**
     * Get estados disponibles
     */
    public static function getEstados()
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_PAGADO => 'Pagado',
            self::ESTADO_CANCELADO => 'Cancelado',
        ];
    }
}