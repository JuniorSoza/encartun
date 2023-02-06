<?php

namespace app\controllers;

use Yii;
use app\models\parametroBalanza;
use app\models\parametroBalanzaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ProgramaProduccionD;
use yii\helpers\Json;
use yii\db\Command;

/**
 * ParametroBalanzaController implements the CRUD actions for parametroBalanza model.
 */
class ParametroBalanzaController extends Controller
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
                    'searchof' => ['GET'],
                    'searchop' => ['GET'],
                    'datosof' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all parametroBalanza models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new parametroBalanzaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single parametroBalanza model.
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
     * Creates a new parametroBalanza model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new parametroBalanza();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing parametroBalanza model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing parametroBalanza model.
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

    public function actionSearchop($dia)
    {
        $opDia = ProgramaProduccionD::findBySql("SELECT B.nciOP FROM ProgramaProduccionC A INNER JOIN ProgramaProduccionD B ON A.nciProgramacion = B.nciProgramacion  WHERE A.dfeProgramacion = '$dia' AND A.cstProgramacion = 'A' AND A.proceso IN ('LT','PO') GROUP BY B.nciOP ")->all();
        echo Json::encode($opDia);
    }

    public function actionSearchof($dia, $op)
    {
        $ofPtDia = ProgramaProduccionD::findBySql("SELECT B.ordenFabricacion_PT, B.nciOP FROM ProgramaProduccionC A INNER JOIN ProgramaProduccionD B ON A.nciProgramacion = B.nciProgramacion  WHERE A.dfeProgramacion = '$dia' AND B.nciOP = '$op' AND A.cstProgramacion = 'A' AND A.proceso IN ('LT','PO') ")->all();
        echo Json::encode($ofPtDia);
    }

    public function actionDatosof($ofseleccionada)
    {
        $ofdatos = \Yii::$app->db->createCommand("SELECT 'Producto: ' + LTRIM(RTRIM(B.cciProducto))+', Formato: '+LTRIM(RTRIM(B.cciTalla))+ ', Tipo: '+ LTRIM(RTRIM(D.cnoPresentacion))+ ', en: ' + LTRIM(RTRIM(E.cnoLiquidoCoberturaCorto))+', Marca: ' + LTRIM(RTRIM(F.cnoMarca)) Producto, B.PesoNeto FROM ProgramaProduccionC A WITH (NOLOCK) INNER JOIN ProgramaProduccionD B WITH (NOLOCK) ON A.nciProgramacion = B.nciProgramacion INNER JOIN TblProducto C WITH (NOLOCK) ON B.cciProducto = C.cciProducto INNER JOIN TblPresentaciones D WITH (NOLOCK) ON C.cciPresentacion = D.cciPresentacion INNER JOIN tblLiquidoCobertura E WITH (NOLOCK) ON B.cciCobertura = E.cciLiquidoCobertura INNER JOIN TblMarcas F WITH (NOLOCK) ON B.cciMarca = F.cciMarca WHERE B.ordenFabricacion_PT = $ofseleccionada")->queryAll();
        echo Json::encode($ofdatos);
    }


    /**
     * Finds the parametroBalanza model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return parametroBalanza the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = parametroBalanza::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
