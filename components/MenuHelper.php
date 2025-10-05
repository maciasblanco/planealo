<?php
// components/MenuHelper.php

namespace app\components;

use Yii;
use app\models\Menu;

class MenuHelper
{
    /**
     * Obtiene los elementos del menú principal
     */
    public static function getMenuItems()
    {
        $menuItems = [];
        
        // Obtener menús principales (sin parent)
        $mainMenus = Menu::find()
            ->where(['parent' => null])
            ->orderBy(['order' => SORT_ASC])
            ->all();

        foreach ($mainMenus as $mainMenu) {
            $menuItems[] = static::buildMenuItem($mainMenu);
        }

        return $menuItems;
    }

    /**
     * Construye un item de menú con sus submenús
     */
    private static function buildMenuItem($menu)
    {
        $item = [
            'label' => $menu->name,
            'url' => $menu->route ? [$menu->route] : '#',
        ];

        // Agregar icono si existe
        $icon = $menu->getIcons();
        if ($icon) {
            $item['label'] = '<i class="' . $icon . '"></i> ' . $menu->name;
            $item['encode'] = false;
        }

        // Verificar si tiene submenús
        $children = $menu->getChildren()->all();
        if (!empty($children)) {
            $item['items'] = [];
            foreach ($children as $child) {
                $item['items'][] = static::buildMenuItem($child);
            }
        }

        return $item;
    }

    /**
     * Verifica si un usuario tiene acceso a una ruta
     */
    public static function checkAccess($route)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if ($route === '#') {
            return true;
        }

        // Separar ruta y parámetros
        $routeParts = explode('?', $route);
        $route = $routeParts[0];

        // Verificar permisos (ajusta según tu sistema de permisos)
        return Yii::$app->user->can($route) || Yii::$app->user->can('/' . $route);
    }
}