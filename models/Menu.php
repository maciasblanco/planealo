<?php
// models/Menu.php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seguridad.menu".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent
 * @property string|null $route
 * @property int|null $order
 * @property string|null $data
 */
class Menu extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguridad.menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent', 'order'], 'integer'],
            [['name', 'route', 'data'], 'string', 'max' => 255],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'parent' => 'Padre',
            'route' => 'Ruta',
            'order' => 'Orden',
            'data' => 'Datos',
        ];
    }

    /**
     * Obtiene el menú padre
     */
    public function getParentMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'parent']);
    }

    /**
     * Obtiene los submenús
     */
    public function getChildren()
    {
        return $this->hasMany(Menu::class, ['parent' => 'id'])->orderBy(['order' => SORT_ASC]);
    }

    /**
     * Obtiene los iconos desde el campo data
     */
    public function getIcons()
    {
        if ($this->data) {
            $data = json_decode($this->data, true);
            return $data['faIcon'] ?? '';
        }
        return '';
    }
}