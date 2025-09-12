<?php
// widgets/HorizontalMenu.php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\components\MenuHelper;

class HorizontalMenu extends Widget
{
    public function run()
    {
        $menuItems = MenuHelper::getMenuItems();
        
        // Filtrar items según permisos de usuario
        $filteredItems = [];
        foreach ($menuItems as $item) {
            if ($this->hasAccess($item)) {
                $filteredItems[] = $item;
            }
        }

        return $this->render('horizontal-menu', [
            'menuItems' => $filteredItems,
        ]);
    }

    /**
     * Verifica acceso recursivamente para items y subitems
     */
    private function hasAccess($item)
    {
        $url = is_array($item['url']) ? $item['url'][0] : $item['url'];
        
        if (!MenuHelper::checkAccess($url)) {
            return false;
        }

        // Verificar subitems si existen
        if (isset($item['items'])) {
            $accessibleChildren = [];
            foreach ($item['items'] as $child) {
                if ($this->hasAccess($child)) {
                    $accessibleChildren[] = $child;
                }
            }
            $item['items'] = $accessibleChildren;
            
            // Si no tiene hijos accesibles y es un menú padre, no mostrarlo
            if (empty($accessibleChildren) && $url === '#') {
                return false;
            }
        }

        return true;
    }
}