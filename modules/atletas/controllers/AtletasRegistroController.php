<?php

namespace app\modules\atletas\controllers;
use app\models\AtletasRegistro;
use app\models\Escuela;
use app\models\RegistroRepresentantes;
use app\modules\atletas\models\AtletasRegistroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\db\Transaction;

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
    public function actionIndex($id=0, $nombre=null)
    {
        Yii::beginProfile('atletas-grid-search');

        $searchModel = new AtletasRegistroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        Yii::endProfile('atletas-grid-search');

        $this->layout='escuelas'; 
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
        $model = $this->findModel($id);
        
        // Obtener información de la escuela para el breadcrumb
        $idEscuela = $model->id_escuela;
        $escuela = $idEscuela ? Escuela::findOne($idEscuela) : null;
        $nombreEscuela = $escuela ? $escuela->nombre : 'Escuela No Encontrada';

        return $this->render('view', [
            'model' => $model,
            'idEscuela' => $idEscuela,
            'nombreEscuela' => $nombreEscuela,
        ]);
    }

    /**
     * Creates a new AtletasRegistro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id=null, $nombre=null)
    {
        $model = new AtletasRegistro();
        $this->layout='escuelas';
        
        // Establecer la escuela por defecto si se pasa por parámetro
        if ($id) {
            $model->id_escuela = $id;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                
                $transaction = Yii::$app->db->beginTransaction();
                
                try {
                    $representantesRegistrosModel = new RegistroRepresentantes();
                    
                    /* Verificar cédula de representante registrada */
                    $encontraCIRepresentante = RegistroRepresentantes::find()
                        ->where(["identificacion" => $model->identificacion_representante])
                        ->one();
                        
                    if ($encontraCIRepresentante == NULL) {
                        // NUEVO REPRESENTANTE - CORREGIR FORMATO DE FECHA
                        $representantesRegistrosModel->p_nombre = $model->p_nombre_representante;
                        $representantesRegistrosModel->s_nombre = $model->s_nombre_representante;
                        $representantesRegistrosModel->p_apellido = $model->p_apellido_representante;
                        $representantesRegistrosModel->s_apellido = $model->s_apellido_representante;
                        $representantesRegistrosModel->id_nac = $model->id_nac_representante;
                        $representantesRegistrosModel->identificacion = $model->identificacion_representante;
                        $representantesRegistrosModel->cell = $model->cell_representante;
                        $representantesRegistrosModel->telf = $model->telf_representante;
                        $representantesRegistrosModel->u_creacion = (int)Yii::$app->user->id;
                        
                        // CORRECCIÓN: Usar el formato correcto para PostgreSQL timestamp
                        $representantesRegistrosModel->d_creacion = date('Y-m-d H:i:s');
                        
                        $representantesRegistrosModel->u_update = (int)Yii::$app->user->id;
                        
                        // CORRECCIÓN: También para d_update
                        $representantesRegistrosModel->d_update = date('Y-m-d H:i:s');
                        
                        $representantesRegistrosModel->eliminado = false;
                        $representantesRegistrosModel->dir_ip = Yii::$app->request->userIP;

                        if (!$representantesRegistrosModel->save()) {
                            throw new \Exception('Error al guardar representante: ' . print_r($representantesRegistrosModel->getErrors(), true));
                        }
                        
                        // Obtener el ID del representante recién guardado
                        $idRepresentanteAtleta = $representantesRegistrosModel->id;
                        $model->id_representante = $idRepresentanteAtleta;
                    } else {
                        // REPRESENTANTE EXISTENTE
                        $model->id_representante = $encontraCIRepresentante->id;
                    }
                    
                    // Configurar datos del atleta
                    $model->u_creacion = (int)Yii::$app->user->id;
                    $model->d_creacion = date('Y-m-d H:i:s');
                    $model->u_update = (int)Yii::$app->user->id;
                    $model->d_update = date('Y-m-d H:i:s');
                    $model->eliminado = false;
                    $model->dir_ip = Yii::$app->request->userIP;

                    if (!$model->save()) {
                        throw new \Exception('Error al guardar atleta: ' . print_r($model->getErrors(), true));
                    }
                    
                    $transaction->commit();
                    
                    Yii::$app->session->setFlash('success', 'Atleta registrado correctamente.');
                    return $this->redirect(['index', 'id' => $id, 'nombre' => $nombre]);
                    
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Error al registrar atleta: ' . $e->getMessage());
                    Yii::error('Error en actionCreate: ' . $e->getMessage(), 'atletas');
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
        
        // Obtener información de la escuela para el breadcrumb
        $idEscuela = $model->id_escuela;
        $escuela = $idEscuela ? Escuela::findOne($idEscuela) : null;
        $nombreEscuela = $escuela ? $escuela->nombre : 'Escuela No Encontrada';

        if ($this->request->isPost && $model->load($this->request->post())) {
            // Campos de auditoría
            $model->u_update = (int)Yii::$app->user->id;
            $model->d_update = date('Y-m-d H:i:s');
            $model->dir_ip = Yii::$app->request->userIP;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Atleta actualizado correctamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Error al actualizar atleta: ' . implode(', ', $model->getErrorSummary(true)));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'idEscuela' => $idEscuela,
            'nombreEscuela' => $nombreEscuela,
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
        $model = $this->findModel($id);
        
        // Validar que el atleta tenga escuela asociada
        if (empty($model->id_escuela)) {
            Yii::$app->session->setFlash('warning', 'Este atleta no tiene una escuela asociada.');
            return $this->redirect(['index']);
        }
        
        $idEscuela = $model->id_escuela;
        
        // Obtener el nombre de la escuela
        $escuela = Escuela::findOne($idEscuela);
        $nombreEscuela = $escuela ? $escuela->nombre : 'Escuela No Encontrada';
        
        $model->delete();

        Yii::$app->session->setFlash('success', 'Atleta eliminado correctamente.');
        
        return $this->redirect(['index', 'id' => $idEscuela, 'nombre' => $nombreEscuela]);
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