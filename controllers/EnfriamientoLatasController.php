<?php

namespace app\controllers;

use Yii;
use app\models\EnfriamientoLatas;
use app\models\EnfriamientoLatasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\db\Command;
use yii\filters\AccessControl;

/**
 * EnfriamientoLatasController implements the CRUD actions for EnfriamientoLatas model.
 */
class EnfriamientoLatasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete','buscardetalle','buscarrecibido','searchautoclave', 'searchturno', 'addtime', 'settimequery'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all EnfriamientoLatas models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = 'spa';
        $searchModel = new EnfriamientoLatasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnfriamientoLatas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //$this->layout = 'spa';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EnfriamientoLatas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$this->layout = 'spa';

        $transaction = \Yii::$app->db1->beginTransaction();
        try {
            $model = new EnfriamientoLatas();            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $detalle = \Yii::$app->db1->createCommand("EXEC spInsertarEnfriamiento :fechaPrd, :turnoPrd, :autoclave, :parada, :idCabecera, :cochesNoIncluir") 
                ->bindValue(':fechaPrd', $model->fechaProduccion)
                ->bindValue(':turnoPrd', $model->turno)
                ->bindValue(':autoclave', $model->autoClave)
                ->bindValue(':parada', $model->parada)
                ->bindValue(':idCabecera', $model->id)
                ->bindValue(':cochesNoIncluir', $model->cochesNoIncluir)
                ->execute();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (Exception $e) {
            $transaction->rollback();
        }

        /*$model = new EnfriamientoLatas();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnfriamientoLatas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //$this->layout = 'spa';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EnfriamientoLatas model.
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

    public function actionBuscardetalle($fechaproduccion, $autoclave, $parada, $turno)
    {
        $result = \Yii::$app->db1->createCommand("SELECT CAST(A.dfeLotePrdIni AS DATE)FechaProduccion, A.cnqLotePrd, B.IdAutoclaves, B.orden_prod, B.ordenFabricacion_PT,
            producto= CASE WHEN C.cciProceso = '06' THEN 'LATA : ' ELSE 'POUCH : ' END + LTRIM(RTRIM(D.cnoPresentacion)) + ' EN ' + LTRIM(RTRIM(E.cnoLiquidoCobertura)) + ' DE ' + CAST(C.PesoNeto AS VARCHAR) +' GRAMOS',
            B.peso_neto, F.cnoMarca marca, B.codigo_lata, B.coche, B.autoclave, B.parada, B.latas,
            dbo.fnObtenerCajasLatas(B.producto,B.latas)cjsLatas
            FROM TblLoteProduccionC A WITH (NOLOCK)
            INNER JOIN TblProdConserva B WITH (NOLOCK) ON A.cnqLotePrd = B.lote
            INNER JOIN TblProducto C WITH (NOLOCK) ON B.producto = C.cciProducto
            INNER JOIN TblPresentaciones D WITH (NOLOCK) ON C.cciPresentacion = D.cciPresentacion
            INNER JOIN tblLiquidoCobertura E WITH (NOLOCK) ON C.cciCobertura = E.cciLiquidoCobertura
            INNER JOIN TblMarcas F WITH (NOLOCK) ON C.cciMarca = F.cciMarca
            WHERE B.parada = '$parada'
            AND B.autoclave = '$autoclave'
            AND B.turno = '$turno'
            AND B.coche NOT IN (
                SELECT DISTINCT coche
                FROM EnfriamientoLatas X WITH (NOLOCK)
                INNER JOIN EnfriamientoLatasDetalle Y WITH (NOLOCK) ON X.id = Y.idEnfriamiento
                WHERE X.fechaProduccion = '$fechaproduccion' AND X.turno = '$turno'
                AND X.autoClave = '$autoclave' AND X.parada = '$parada'
            )
            AND CAST(A.dfeLotePrdIni AS DATE) = '$fechaproduccion'
            ")->queryAll();
        echo Json::encode($result);

    }

    public function actionBuscarrecibido($fechaproduccion, $autoclave, $parada, $turno)
    {
        $result = \Yii::$app->db1->createCommand("SELECT CAST(A.dfeLotePrdIni AS DATE)FechaProduccion, A.cnqLotePrd, B.IdAutoclaves, B.orden_prod, B.ordenFabricacion_PT,
            producto= CASE WHEN C.cciProceso = '06' THEN 'LATA : ' ELSE 'POUCH : ' END + LTRIM(RTRIM(D.cnoPresentacion)) + ' EN ' + LTRIM(RTRIM(E.cnoLiquidoCobertura)) + ' DE ' + CAST(C.PesoNeto AS VARCHAR) +' GRAMOS',
            B.peso_neto, F.cnoMarca marca, B.codigo_lata, B.coche, B.autoclave, B.parada, B.latas,
            dbo.fnObtenerCajasLatas(B.producto,B.latas)cjsLatas,
            G.inicioEnfriamiento, G.finEnfriamiento, G.idEnfriamiento
            FROM TblLoteProduccionC A WITH (NOLOCK)
            INNER JOIN TblProdConserva B WITH (NOLOCK) ON A.cnqLotePrd = B.lote
            INNER JOIN TblProducto C WITH (NOLOCK) ON B.producto = C.cciProducto
            INNER JOIN TblPresentaciones D WITH (NOLOCK) ON C.cciPresentacion = D.cciPresentacion
            INNER JOIN tblLiquidoCobertura E WITH (NOLOCK) ON C.cciCobertura = E.cciLiquidoCobertura
            INNER JOIN TblMarcas F WITH (NOLOCK) ON C.cciMarca = F.cciMarca
            INNER JOIN EnfriamientoLatasDetalle G WITH (NOLOCK) ON B.IdAutoclaves = G.idAutoclave
            WHERE B.parada = '$parada'
            AND B.autoclave = '$autoclave'
            AND B.turno = '$turno'
            AND B.coche IN (
                SELECT DISTINCT coche
                FROM EnfriamientoLatas X WITH (NOLOCK)
                INNER JOIN EnfriamientoLatasDetalle Y WITH (NOLOCK) ON X.id = Y.idEnfriamiento
                WHERE X.fechaProduccion = '$fechaproduccion' AND X.turno = '$turno'
                AND X.autoClave = '$autoclave' AND X.parada = '$parada'
            )
            AND CAST(A.dfeLotePrdIni AS DATE) = '$fechaproduccion'
            ")->queryAll();
        echo Json::encode($result);

    }

    public function actionSearchautoclave($fechaproduccion, $autoclave, $turno)
    {
        $result = \Yii::$app->db1->createCommand("SELECT DISTINCT parada
        FROM TblLoteProduccionC A WITH (NOLOCK) 
        INNER JOIN TblProdConserva B WITH (NOLOCK) ON A.cnqLotePrd = B.lote
        WHERE CAST(A.dfeLotePrdIni AS DATE) = '$fechaproduccion' AND B.turno = '$turno'
        AND B.autoclave = '$autoclave'")->queryAll();
        echo Json::encode($result);
    }

    public function actionSearchturno($fechaproduccion)
    {
        $result = \Yii::$app->db1->createCommand("SELECT DISTINCT B.turno
        FROM TblLoteProduccionC A WITH (NOLOCK) 
        INNER JOIN TblProdConserva B WITH (NOLOCK) ON A.cnqLotePrd = B.lote
        WHERE CAST(A.dfeLotePrdIni AS DATE) = '$fechaproduccion'")->queryAll();
        echo Json::encode($result);
    }


    /**
     * Finds the EnfriamientoLatas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EnfriamientoLatas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnfriamientoLatas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     public function actionAddtime()
    {
        $model = new EnfriamientoLatas();            
        return $this->render('addtime', [
            'model' => $model
        ]);
    }

    public function actionSettimequery()
    {
        $transaction = \Yii::$app->db1->beginTransaction();
        try {
                $fechaPrdPost = $_POST['fechaPrd'];
                $turnoPrdPost = $_POST['turnoPrd'];
                $autoclavePost = $_POST['autoclave'];
                $paradaPost = $_POST['parada'];
                //$idCabeceraPost = $_POST['idCabecera'];
                $fechaEnfriamientoNewPost = $_POST['fechaEnfriamientoNew'];
                $cochesNoIncluirPost = $_POST['cochesNoIncluir'];

                $detalle = \Yii::$app->db1->createCommand("EXEC spModificarEnfriamiento :fechaPrd, :turnoPrd, :autoclave, :parada, :fechaInicioEnfriamientoNew, :cochesNoIncluir") 
                ->bindValue(':fechaPrd', $fechaPrdPost)
                ->bindValue(':turnoPrd', $turnoPrdPost)
                ->bindValue(':autoclave', $autoclavePost)
                ->bindValue(':parada', $paradaPost)
                //->bindValue(':idCabecera', $idCabeceraPost)
                ->bindValue(':fechaInicioEnfriamientoNew', $fechaEnfriamientoNewPost)
                ->bindValue(':cochesNoIncluir', $cochesNoIncluirPost)
                ->execute();
                $transaction->commit();
                return $this->redirect('addtime');
                //return json_encode($detalle);
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }
}
