<?php

namespace app\modules\atletas\controllers;

use app\models\AtletasRegistro;
use app\models\RegistroRepresentantes;
use app\modules\atletas\models\AtletasRegistroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * AtletasRegistroController implements the CRUD actions for AtletasRegistro model.
 */
class AtletasRegistroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all AtletasRegistro models.
     *
     * @return string
     */
    public function actionIndex($id=null, $nombre=null)
    {
        $registro_atletas = AtletasRegistro::find()->exists();
        
        if (!$registro_atletas) {
            // No hay registros de atletas en absoluto
            Yii::$app->session->setFlash('info', 'No hay atletas registrados en el sistema.');
        }
    
        $searchModel = new AtletasRegistroSearch();
        
        // Pasar el id de la escuela al searchModel para filtrar
        $searchModel->id_escuela = $id;
        
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        $this->layout = 'escuelas'; 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id, 
            'nombre' => $nombre,
        ]);
    }

    /**
     * Displays a single AtletasRegistro model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AtletasRegistro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id, $nombre)
    {
        $model = new AtletasRegistro();
        /*Selecciono el main a usar*/
        //die(var_dump($id.",".$nombre));
        $this ->layout='escuelas';
        //die(var_dump(["p_nombre_representante"])); 
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                 
                $representantesRegistrosModel=new RegistroRepresentantes();
                /*verifico cedula resgistradas*/

                $encontraCIRepresentante = RegistroRepresentantes::find()->where(["identificacion"=>$model["identificacion_representante"]])->one();
                if ($encontraCIRepresentante==NULL) {
                    $representantesRegistrosModel->p_nombre = $model["p_nombre_representante"];
                    $representantesRegistrosModel->s_nombre= $model["s_nombre_representante"];
                    $representantesRegistrosModel->p_apellido= $model["p_apellido_representante"];
                    $representantesRegistrosModel->s_apellido= $model["s_apellido_representante"];
                    $representantesRegistrosModel->id_nac= $model["id_nac_representante"];
                    $representantesRegistrosModel->identificacion= $model["identificacion_representante"];
                    $representantesRegistrosModel->cell= $model["cell_representante"];
                    $representantesRegistrosModel->telf= $model["telf_representante"];
                    $representantesRegistrosModel->u_creacion=(int)Yii::$app->user->id;
                    $representantesRegistrosModel->d_creacion=date("Y-m-d H:i:s", time());
                    $representantesRegistrosModel->u_update=(int)Yii::$app->user->id;
                    $representantesRegistrosModel->d_update=date("Y-m-d H:i:s", time());
                    //die(var_dump(isset($model["p_nombre_representante"])));
                    if ($representantesRegistrosModel->save() ) {
                        /*return $this->redirect(['index', 
                            'id' => $id, 
                            'nombre' => $nombre,
                        ]);*/
                        $idRepresentanteAtleta=RegistroRepresentantes::find()->where(["identificacion"=>$model["identificacion_representante"]])->one();
                        $model->id_representante=$idRepresentanteAtleta->id;
                    }
                    else{
                        /**Mensaje de error por no salvado de model Atleta Registro */
                        die(var_dump($representantesRegistrosModel->getErrors()));
                    }
                }
                else{
                    
                    $model->id_representante=$encontraCIRepresentante->id;
                    //die(var_dump($model->id_representante));
                
                };
                
                if ($model->save()) { 
                ?>
                    <script>
                        form.reset()
                    </script>
                <?php
                    return $this->redirect(['index', 
                        'id' => $id, 
                        'nombre' => $nombre,
                    ]);
                }
                else{
                    /**Mensaje de error por no salvado de model Atleta Registro */
                    die(var_dump($model->getErrors()));
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id, 
            'nombre' => $nombre,

        ]);
    }

    /**
     * Updates an existing AtletasRegistro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AtletasRegistro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AtletasRegistro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AtletasRegistro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AtletasRegistro::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
