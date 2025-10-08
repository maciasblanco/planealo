<?php
use yii\db\Migration;

/**
 * Class m251007_152626_create_aportes_semanales_table
 */
class m251007_152626_create_aportes_semanales_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('aportes_semanales', [
            'id' => $this->primaryKey(),
            'atleta_id' => $this->integer()->notNull(),
            'escuela_id' => $this->integer()->notNull(),
            'fecha_viernes' => $this->date()->notNull(),
            'numero_semana' => $this->integer()->notNull(),
            'monto' => $this->decimal(10,2)->defaultValue(2.00),
            'fecha_pago' => $this->date(),
            'estado' => $this->string(20)->defaultValue('pendiente'),
            'metodo_pago' => $this->string(50),
            'comentarios' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // SOLO ÍNDICES - SIN FOREIGN KEYS
        $this->createIndex('idx-aportes-fecha_viernes', 'aportes_semanales', 'fecha_viernes');
        $this->createIndex('idx-aportes-estado', 'aportes_semanales', 'estado');
        $this->createIndex('idx-aportes-escuela', 'aportes_semanales', 'escuela_id');
        $this->createIndex('idx-aportes-atleta', 'aportes_semanales', 'atleta_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('aportes_semanales');
    }
}