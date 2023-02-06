<?php

namespace app\controllers;

use Yii;
use app\models\EnfriamientoLatasDetalle;
use app\models\EnfriamientoLatasDetalleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EnfriamientoLatasDetalleController implements the CRUD actions for EnfriamientoLatasDetalle model.
 */
class EnfriamientoLatasDetalleController extends Controller
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
                        'actions' => ['index','view','create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all EnfriamientoLatasDetalle models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->layout = 'spa';
        $searchModel = new EnfriamientoLatasDetalleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnfriamientoLatasDetalle model.
     * @param string $idAutoclave
     * @param integer $idEnfriamiento
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idAutoclave, $idEnfriamiento)
    {
        //$this->layout = 'spa';
        return $this->render('view', [
            'model' => $this->findModel($idAutoclave, $idEnfriamiento),
        ]);
    }

    /**
     * Creates a new EnfriamientoLatasDetalle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$this->layout = 'spa';
        $model = new EnfriamientoLatasDetalle();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idAutoclave' => $model->idAutoclave, 'idEnfriamiento' => $model->idEnfriamiento]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnfriamientoLatasDetalle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $idAutoclave
     * @param integer $idEnfriamiento
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idAutoclave, $idEnfriamiento)
    {
        //$this->layout = 'spa';
        $model = $this->findModel($idAutoclave, $idEnfriamiento);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idAutoclave' => $model->idAutoclave, 'idEnfriamiento' => $model->idEnfriamiento]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EnfriamientoLatasDetalle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $idAutoclave
     * @param integer $idEnfriamiento
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idAutoclave, $idEnfriamiento)
    {
        //$this->layout = 'spa';
        $this->findModel($idAutoclave, $idEnfriamiento)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EnfriamientoLatasDetalle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $idAutoclave
     * @param integer $idEnfriamiento
     * @return EnfriamientoLatasDetalle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idAutoclave, $idEnfriamiento)
    {
        if (($model = EnfriamientoLatasDetalle::findOne(['idAutoclave' => $idAutoclave, 'idEnfriamiento' => $idEnfriamiento])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
