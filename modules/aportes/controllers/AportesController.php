<?php

namespace app\modules\aportes\controllers;

use Yii;
use app\modules\aportes\models\AportesSemanales;
use app\modules\aportes\models\AportesSemanalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AtletasRegistro;
use app\models\Escuela;

/**
 * AportesController implements the CRUD actions for AportesSemanales model.
 */
class AportesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AportesSemanales models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AportesSemanalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Estadísticas MEJORADAS
        $totalRecaudado = AportesSemanales::find()
            ->where(['estado' => 'pagado'])
            ->sum('monto') ?? 0;

        $pendientes = AportesSemanales::find()
            ->where(['estado' => 'pendiente'])
            ->count();

        // NUEVO: Deuda total pendiente
        $deudaTotal = AportesSemanales::find()
            ->where(['estado' => 'pendiente'])
            ->sum('monto') ?? 0;

        // NUEVO: Atletas con deuda
        $atletasConDeuda = AtletasRegistro::find()
            ->select(['atletas_registro.*', 
                'deuda' => 'SUM(CASE WHEN aportes_semanales.estado = "pendiente" THEN aportes_semanales.monto ELSE 0 END)'
            ])
            ->joinWith('aportes')
            ->groupBy('atletas_registro.id')
            ->having('deuda > 0')
            ->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalRecaudado' => $totalRecaudado,
            'pendientes' => $pendientes,
            'deudaTotal' => $deudaTotal,
            'atletasConDeuda' => $atletasConDeuda,
        ]);
    }

    /**
     * Displays a single AportesSemanales model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AportesSemanales model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AportesSemanales();
        $model->fecha_viernes = AportesSemanales::getViernesActual();
        $model->numero_semana = AportesSemanales::getNumeroSemana($model->fecha_viernes);
        $model->monto = AportesSemanales::MONTO_SEMANAL;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Aporte semanal registrado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'atletas' => AtletasRegistro::find()->all(),
            'escuelas' => Escuela::find()->all(),
        ]);
    }

    /**
     * Updates an existing AportesSemanales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Aporte semanal actualizado exitosamente.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'atletas' => AtletasRegistro::find()->all(),
            'escuelas' => Escuela::find()->all(),
        ]);
    }

    /**
     * Deletes an existing AportesSemanales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AportesSemanales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AportesSemanales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AportesSemanales::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * NUEVA ACCIÓN: Reporte de deudas por escuela
     */
    public function actionDeudasEscuelas()
    {
        $deudasPorEscuela = Escuela::find()
            ->select([
                'escuela.nombre',
                'total_deuda' => 'SUM(CASE WHEN aportes_semanales.estado = "pendiente" THEN aportes_semanales.monto ELSE 0 END)',
                'atletas_deudores' => 'COUNT(DISTINCT CASE WHEN aportes_semanales.estado = "pendiente" THEN aportes_semanales.atleta_id END)'
            ])
            ->joinWith('aportes')
            ->groupBy('escuela.id, escuela.nombre')
            ->having('total_deuda > 0')
            ->asArray()
            ->all();

        return $this->render('deudas-escuelas', [
            'deudasPorEscuela' => $deudasPorEscuela,
        ]);
    }

    /**
     * NUEVA ACCIÓN: Reporte de atletas morosos
     */
    public function actionAtletasMorosos()
    {
        $atletasMorosos = AtletasRegistro::find()
            ->select([
                'atletas_registro.*',
                'escuela.nombre as escuela_nombre',
                'total_deuda' => 'SUM(CASE WHEN aportes_semanales.estado = "pendiente" THEN aportes_semanales.monto ELSE 0 END)',
                'semanas_deuda' => 'COUNT(CASE WHEN aportes_semanales.estado = "pendiente" THEN 1 END)'
            ])
            ->joinWith(['escuela', 'aportes'])
            ->groupBy('atletas_registro.id, atletas_registro.nombre_completo, escuela.nombre')
            ->having('total_deuda > 0')
            ->orderBy('total_deuda DESC')
            ->asArray()
            ->all();

        return $this->render('atletas-morosos', [
            'atletasMorosos' => $atletasMorosos,
        ]);
    }

    /**
     * REGISTRO MASIVO MEJORADO
     */
    public function actionRegistroMasivo()
    {
        $model = new AportesSemanales();
        $fechaViernes = AportesSemanales::getViernesActual();
        $numeroSemana = AportesSemanales::getNumeroSemana($fechaViernes);

        if (Yii::$app->request->post()) {
            $selectedAtletas = Yii::$app->request->post('atletas', []);
            $fecha_viernes = Yii::$app->request->post('fecha_viernes', $fechaViernes);
            $monto = Yii::$app->request->post('monto', AportesSemanales::MONTO_SEMANAL);

            $count = 0;
            $errors = 0;

            foreach ($selectedAtletas as $atletaId) {
                // Verificar si ya existe el aporte para esta semana
                $existe = AportesSemanales::find()
                    ->where([
                        'atleta_id' => $atletaId,
                        'fecha_viernes' => $fecha_viernes
                    ])
                    ->exists();

                if (!$existe) {
                    $atleta = AtletasRegistro::findOne($atletaId);
                    $aporte = new AportesSemanales();
                    $aporte->atleta_id = $atletaId;
                    $aporte->escuela_id = $atleta->escuela_id;
                    $aporte->fecha_viernes = $fecha_viernes;
                    $aporte->numero_semana = AportesSemanales::getNumeroSemana($fecha_viernes);
                    $aporte->monto = $monto;
                    $aporte->estado = 'pendiente';
                    
                    if ($aporte->save()) {
                        $count++;
                    } else {
                        $errors++;
                    }
                }
            }

            if ($count > 0) {
                Yii::$app->session->setFlash('success', 
                    "Se registraron {$count} aportes semanales exitosamente." . 
                    ($errors > 0 ? " {$errors} errores." : "")
                );
            } else {
                Yii::$app->session->setFlash('warning', 
                    "No se registraron nuevos aportes. Posiblemente ya estaban registrados para esta semana."
                );
            }

            return $this->redirect(['index']);
        }

        return $this->render('registro-masivo', [
            'model' => $model,
            'atletas' => AtletasRegistro::find()->all(),
            'fechaViernes' => $fechaViernes,
            'numeroSemana' => $numeroSemana,
        ]);
    }

    /**
     * Acción para marcar un aporte como pagado
     */
    public function actionMarcarPagado($id)
    {
        $model = $this->findModel($id);
        $model->estado = 'pagado';
        $model->fecha_pago = date('Y-m-d');

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Aporte marcado como pagado exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al marcar el aporte como pagado.');
        }

        return $this->redirect(['index']);
    }
}