<?php

namespace app\controllers;

use Yii;
use app\models\AsignacionCoche;
use app\models\enfriamientoLatasDetalleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;


class CochesAsignadosController extends Controller
{

    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','allcoches','coches', 'regresarcoche'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
 
    }

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionAllcoches()//aqui obtengo todas las paradas y las autoclaves de los coches
    {
        $fechaEncartonado = $_POST['fechaEncartonado'];
        $turnoEncartonado = $_POST['turnoEncartonado'];

        $proceso = $_POST['proceso'];        
        if ($proceso == "SEMIELABORADO") {                                                       //cuando es un semielaborado
        $result = \Yii::$app->db1->createCommand("SELECT c.*,Lote=LTRIM(RTRIM(A.cnqLote)),substring(p.nombreProductoFT,21,300) Producto,cast(ISNULL(p.PesoNeto,0) as numeric(12,0))PesoNeto ,M.cnoMarca nombreMarca,CodigoLata= h.cciCodigoLotePrd,OP= I.nciOp,OF_PT=h.OF_PT,MA.CnoMaquina
            FROM COCHEASIGNADO C
            INNER JOIN TblStockAtun A  ON A.ctkIngreCam = c.ticket
            INNER JOIN TblProducto p on p.cciProducto = A.cciProducto
            INNER JOIN TblMarcas m on m.cciMarca = p.cciMarca
            INNER JOIN MaquinaEncartonado MA ON MA.IDMAQUINA = C.IDMAQUINA
            left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
            left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado            
                    WHERE C.cochePasado = 0
                    AND SUBSTRING(ticket ,1,1) = 'C'
                    and CAST(c.fechaEncartonado AS DATE) = '$fechaEncartonado'
                    and c.turnoEncartonado  = '$turnoEncartonado'
            ")->queryAll();  
        $view = 'asignacionTickets';

        }else{                                                                                   //cuando es produccion

        $result = \Yii::$app->db1->createCommand("SELECT c.autoClave,c.parada FROM COCHEASIGNADO C
                    WHERE C.cochePasado = 0
                    and CAST(c.fechaEncartonado AS DATE) = '$fechaEncartonado'
                    and c.turnoEncartonado  = '$turnoEncartonado'
                    AND isnull(C.parada, 0) <> 0
                    group by c.autoClave,c.parada,c.turnoEncartonado,c.fechaEncartonado
            ")->queryAll(); 
        $view = 'allcoches';

        }
            
        return $this->renderAjax($view, [
                                'fechaEncartonado' => $fechaEncartonado,
                                'turnoEncartonado' => $turnoEncartonado,
                                'result' => $result,
                    ]);     
    } 

    public function actionCoches()//aqui obtengo todos los coches que pertenecen a esa parada y a esa autoclave
    {
        $fechaEncartonado = $_POST['fechaEncartonado'];
        $turnoEncartonado = $_POST['turnoEncartonado'];
        $parada = $_POST['parada'];
        $autoClave = $_POST['autoClave'];
        
        $result = \Yii::$app->db1->createCommand("
            SELECT c.*,cast(c.fechaProduccion as date) fecha,D.ordenProduccion,D.ordenFabricacion,D.nombreProducto,D.pesoNeto,D.nombreMarca,D.codigoLata,D.cajasLatas,D.loteProduccion,M.CnoMaquina FROM COCHEASIGNADO C
                INNER JOIN EnfriamientoLatasDetalle D ON D.idAutoclave = C.idAutoclave
                INNER JOIN MaquinaEncartonado M ON M.IdMaquina = C.IDMAQUINA
                WHERE C.cochePasado = 0
                and CAST(c.fechaEncartonado AS DATE) = '$fechaEncartonado'
                and c.turnoEncartonado  = '$turnoEncartonado'
                and c.autoClave = '$autoClave'
                and c.parada = '$parada'    
                ")->queryAll();


        return $this->renderAjax('asignacionCoche', [
                                'fechaEncartonado' => $fechaEncartonado,
                                'turnoEncartonado' => $turnoEncartonado,
                                'parada' => $parada,
                                'autoClave' => $autoClave,
                                'result' => $result,
                    ]);        
    }

    public function actionRegresarcoche()
    {

        $this->layout = 'spa';
        $transaction = \Yii::$app->db1->beginTransaction();
        $proceso = $_POST['proceso'];

        try {

            if ($proceso == "SEMIELABORADO") {

                $RespuestaAsignacion = \Yii::$app->db1->createCommand("exec spDevolucionTickets :fechaEncartonado, :turnoEncartonado, :TicketsExcluidos, :IdMaquina") 
                ->bindValue(':fechaEncartonado', $_POST['fechaEncartonado'])
                ->bindValue(':turnoEncartonado', $_POST['turnoEncartonado'])
                ->bindValue(':TicketsExcluidos', @$_POST['CocheExcluidos'])
                ->bindValue(':IdMaquina', @$_POST['IdMaquina'])
                ->queryAll();
                $transaction->commit();

                $fechaEncartonado = $_POST['fechaEncartonado'];
                $turnoEncartonado = $_POST['turnoEncartonado'];
                
                $result = \Yii::$app->db1->createCommand("SELECT c.*,cast(c.fechaProduccion as date) fecha,Lote=LTRIM(RTRIM(A.cnqLote)),substring(p.nombreProductoFT,21,300) Producto,cast(ISNULL(p.PesoNeto,0) as numeric(12,0))PesoNeto ,M.cnoMarca nombreMarca,CodigoLata= h.cciCodigoLotePrd,OP= I.nciOp,OF_PT=h.OF_PT,Ma.CnoMaquina
                    FROM COCHEASIGNADO C
                    INNER JOIN TblStockAtun A  ON A.ctkIngreCam = c.ticket
                    INNER JOIN TblProducto p on p.cciProducto = A.cciProducto
                    INNER JOIN TblMarcas m on m.cciMarca = p.cciMarca
                    INNER JOIN MaquinaEncartonado Ma ON Ma.IdMaquina = C.IDMAQUINA
                    left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
                    left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado            
                        WHERE C.cochePasado = 0
                        AND SUBSTRING(ticket ,1,1) = 'C'
                        and CAST(c.fechaEncartonado AS DATE) = '$fechaEncartonado'
                        and c.turnoEncartonado  = '$turnoEncartonado'")->queryAll(); 

                $view = "asignacionTickets";

            }  else{

                $RespuestaAsignacion = \Yii::$app->db1->createCommand("exec spDevolucionCoche :fechaEncartonado, :turnoEncartonado, :CocheExcluidos,:parada, :autoClave, :IdMaquina") 
                ->bindValue(':fechaEncartonado', $_POST['fechaEncartonado'])
                ->bindValue(':turnoEncartonado', $_POST['turnoEncartonado'])
                ->bindValue(':CocheExcluidos', @$_POST['CocheExcluidos'])
                ->bindValue(':parada', $_POST['parada'])
                ->bindValue(':autoClave', $_POST['autoClave'])
                ->bindValue(':IdMaquina', @$_POST['IdMaquina'])
                ->queryAll();
                $transaction->commit();

                $result = \Yii::$app->db1->createCommand("SELECT c.autoClave,c.parada FROM COCHEASIGNADO C
                    WHERE C.cochePasado = 0
                    AND isnull(C.parada, 0) <> 0
                    and CAST(c.fechaEncartonado AS DATE) = '".$_POST['fechaEncartonado']."'
                    and c.turnoEncartonado  = '".$_POST['turnoEncartonado']."'
                    group by c.autoClave,c.parada,c.turnoEncartonado,c.fechaEncartonado")->queryAll(); 
                $view = "allcoches";
            }


                return $this->renderAjax($view, [
                                'fechaEncartonado' => $_POST['fechaEncartonado'],
                                'turnoEncartonado' => $_POST['turnoEncartonado'],
                                'result' => $result,
                                'RespuestaAsignacion' => $RespuestaAsignacion,
                ]);

        } catch (Exception $e) {
            $transaction->rollback();
        }

    }    


}
