<?php

namespace app\modules\ged\controllers;

use yii\web\Controller;
use app\models\Escuela;

/**
 * Default controller for the `ged` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id, $nombre)
    {
        
        //$this ->layout='main'; 
    
        $datosEscuelas=Escuela::find()->orderby('id')->all();
        switch ((int)$id){
            case 0: 
                $this ->layout='main';     
                $index="index";
                break;
            default:
                $this ->layout='escuelas';
                $index="index".$id;
                break;
        };
        return 
            $this->render($index,
            ['datosEscuelas'=>$datosEscuelas]
        );
    }
}
