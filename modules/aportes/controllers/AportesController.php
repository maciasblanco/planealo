<?php

namespace app\modules\aportes\controllers;

use Yii;
use app\models\AportesSemanales;
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

        // Estadísticas CORREGIDAS
        $totalRecaudado = AportesSemanales::find()
            ->where(['estado' => 'pagado'])
            ->sum('monto') ?? 0;

        $pendientes = AportesSemanales::find()
            ->where(['estado' => 'pendiente'])
            ->count();

        // CORREGIDO: Deuda total pendiente
        $deudaTotal = AportesSemanales::find()
            ->where(['estado' => 'pendiente'])
            ->sum('monto') ?? 0;

        // CORREGIDO: Atletas con deuda - usando consulta directa
        $atletasConDeuda = Yii::$app->db->createCommand("
            SELECT COUNT(DISTINCT atleta_id) 
            FROM contabilidad.aportes_semanales 
            WHERE estado = 'pendiente'
        ")->queryScalar();

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
     * NUEVA ACCIÓN: Reporte de deudas por escuela - CORREGIDO
     */
    public function actionDeudasEscuelas()
    {
        $deudasPorEscuela = Yii::$app->db->createCommand("
            SELECT 
                e.nombre,
                SUM(CASE WHEN a.estado = 'pendiente' THEN a.monto ELSE 0 END) as total_deuda,
                COUNT(DISTINCT CASE WHEN a.estado = 'pendiente' THEN a.atleta_id END) as atletas_deudores
            FROM atletas.escuela e  -- CORREGIDO: agregado esquema atletas.
            LEFT JOIN contabilidad.aportes_semanales a ON a.escuela_id = e.id
            GROUP BY e.id, e.nombre
            HAVING SUM(CASE WHEN a.estado = 'pendiente' THEN a.monto ELSE 0 END) > 0
        ")->queryAll();

        return $this->render('deudas-escuelas', [
            'deudasPorEscuela' => $deudasPorEscuela,
        ]);
    }

    /**
     * NUEVA ACCIÓN: Reporte de atletas morosos - CORREGIDO
     */
    public function actionAtletasMorosos()
    {
        $atletasMorosos = Yii::$app->db->createCommand("
            SELECT 
                ar.p_nombre || ' ' || ar.p_apellido as nombre_completo,
                e.nombre as escuela_nombre,
                SUM(CASE WHEN a.estado = 'pendiente' THEN a.monto ELSE 0 END) as total_deuda,
                COUNT(CASE WHEN a.estado = 'pendiente' THEN 1 END) as semanas_deuda
            FROM atletas.registro ar
            LEFT JOIN atletas.escuela e ON e.id = ar.id_escuela  -- CORREGIDO: agregado esquema atletas.
            LEFT JOIN contabilidad.aportes_semanales a ON a.atleta_id = ar.id
            GROUP BY ar.id, ar.p_nombre, ar.p_apellido, ar.s_nombre, ar.s_apellido, e.nombre
            HAVING SUM(CASE WHEN a.estado = 'pendiente' THEN a.monto ELSE 0 END) > 0
            ORDER BY total_deuda DESC
        ")->queryAll();

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
                    $aporte->escuela_id = $atleta->id_escuela;
                    $aporte->fecha_viernes = $fecha_viernes;
                    $aporte->numero_semana = AportesSemanales::getNumeroSemana($fecha_viernes);
                    $aporte->monto = $monto;
                    $aporte->estado = 'pendiente';
                    
                    if ($aporte->save()) {
                        $count++;
                    } else {
                        $errors++;
                        Yii::error('Error al guardar aporte: ' . json_encode($aporte->errors));
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

/**
 * Genera reporte general de aportes
 */
public function actionReporte()
{
    // Obtener parámetros de filtro
    $fechaInicio = Yii::$app->request->get('fecha_inicio', date('Y-m-01')); // Primer día del mes
    $fechaFin = Yii::$app->request->get('fecha_fin', date('Y-m-t')); // Último día del mes
    
    // Estadísticas generales
    $totalRecaudado = AportesSemanales::find()
        ->where(['estado' => 'pagado'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->sum('monto') ?? 0;

    $totalPendiente = AportesSemanales::find()
        ->where(['estado' => 'pendiente'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->sum('monto') ?? 0;

    $totalCancelado = AportesSemanales::find()
        ->where(['estado' => 'cancelado'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->sum('monto') ?? 0;

    // Conteos por estado
    $countPagados = AportesSemanales::find()
        ->where(['estado' => 'pagado'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->count();

    $countPendientes = AportesSemanales::find()
        ->where(['estado' => 'pendiente'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->count();

    $countCancelados = AportesSemanales::find()
        ->where(['estado' => 'cancelado'])
        ->andWhere(['between', 'fecha_viernes', $fechaInicio, $fechaFin])
        ->count();

    // Top 5 escuelas con más recaudación
    $topEscuelas = Yii::$app->db->createCommand("
        SELECT 
            e.nombre as escuela_nombre,
            COUNT(a.id) as total_aportes,
            SUM(CASE WHEN a.estado = 'pagado' THEN a.monto ELSE 0 END) as total_recaudado,
            SUM(CASE WHEN a.estado = 'pendiente' THEN a.monto ELSE 0 END) as total_pendiente
        FROM atletas.escuela e
        LEFT JOIN contabilidad.aportes_semanales a ON a.escuela_id = e.id 
            AND a.fecha_viernes BETWEEN :fechaInicio AND :fechaFin
        GROUP BY e.id, e.nombre
        ORDER BY total_recaudado DESC
        LIMIT 5
    ", [':fechaInicio' => $fechaInicio, ':fechaFin' => $fechaFin])->queryAll();

    // Evolución mensual (últimos 6 meses)
    $evolucionMensual = Yii::$app->db->createCommand("
        SELECT 
            TO_CHAR(fecha_viernes, 'YYYY-MM') as mes,
            COUNT(*) as total_aportes,
            SUM(CASE WHEN estado = 'pagado' THEN monto ELSE 0 END) as recaudado,
            SUM(CASE WHEN estado = 'pendiente' THEN monto ELSE 0 END) as pendiente
        FROM contabilidad.aportes_semanales
        WHERE fecha_viernes >= DATE_TRUNC('month', CURRENT_DATE - INTERVAL '5 months')
        GROUP BY TO_CHAR(fecha_viernes, 'YYYY-MM')
        ORDER BY mes ASC
    ")->queryAll();

    return $this->render('reporte', [
        'fechaInicio' => $fechaInicio,
        'fechaFin' => $fechaFin,
        'totalRecaudado' => $totalRecaudado,
        'totalPendiente' => $totalPendiente,
        'totalCancelado' => $totalCancelado,
        'countPagados' => $countPagados,
        'countPendientes' => $countPendientes,
        'countCancelados' => $countCancelados,
        'topEscuelas' => $topEscuelas,
        'evolucionMensual' => $evolucionMensual,
    ]);
}







}