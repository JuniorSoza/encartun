<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;


class ConfirmacionAsignacionController extends Controller
{

        public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','buscarcoches','confirmarasignacion', 'validamateriales'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
 
    }

    public function actionIndex()
    {
        $AllMaquinas = \Yii::$app->db1->createCommand("
        SELECT M.idMaquina, M.cnoMaquina, CF.granajeInicio, CF.granajeFin FROM maquinaencartonado M
        INNER JOIN maquinaencartonadoconf CF ON M.idMaquina = CF.idMaquina
        GROUP BY M.idMaquina, M.cnoMaquina, CF.granajeInicio, CF.granajeFin ") 
        ->queryAll();
        

        return $this->render('index',
            ['AllMaquinas'=>$AllMaquinas]);
    }

    public function actionBuscarcoches()
    {
    	try {
	        $cocheTicketBuscar = $_POST['cocheTicketBuscar'];
            $proceso = $_POST['proceso'];
            $maquina = $_POST['maquina'];
            $fechaEncartonado = $_POST['fechaEncartonado'];
            $turnoEncartonado = $_POST['turnoEncartonado'];

            if ($proceso == "SEMIELABORADO") {
            //aqui se debe buscar a la tabla de cocheAsignado para buscar por medio de tickets
            $Coches = \Yii::$app->db1->createCommand("SELECT  top 1 c.*,loteProduccion=LTRIM(RTRIM(A.cnqLote)),substring(p.nombreProductoFT,21,300) nombreProducto,cast(ISNULL(p.PesoNeto,0) as numeric(12,0))pesoNeto ,M.cnoMarca nombreMarca,codigoLata= h.cciCodigoLotePrd,ordenProduccion= I.nciOp,ordenFabricacion=h.OF_PT,'SD' coche,'SD' parada,'SD' autoClave,c.ticket idAutoclave,'0000-00-00 00:00:00' inicioEnfriamiento, '0000-00-00 00:00:00' finEnfriamiento,'SD' cajasLatas,ma.cnoMaquina
            FROM COCHEASIGNADO C
            INNER JOIN TblStockAtun A  ON A.ctkIngreCam = c.ticket
            INNER JOIN TblProducto p on p.cciProducto = A.cciProducto
            INNER JOIN TblMarcas m on m.cciMarca = p.cciMarca
            INNER JOIN maquinaEncartonado ma on ma.idMaquina = c.idMaquina
            left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
            left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado            
                    WHERE C.cochePasado = 0
                    AND SUBSTRING(ticket ,1,1) = 'C'
                    AND c.ticket ='$cocheTicketBuscar' 
                    and C.idMaquina= '$maquina'
                    and cast(c.fechaEncartonado as date) = '$fechaEncartonado'
                    and c.turnoEncartonado = '$turnoEncartonado'")->queryAll();

            }else{
            //los de produccion se buscan por numero de coche
            $Coches = \Yii::$app->db1->createCommand("SELECT top 1 m.cnoMaquina,en.* 
                FROM CocheAsignado c
                    INNER JOIN EnfriamientoLatasDetalle en on en.idAutoclave = c.idAutoclave                
                    INNER JOIN maquinaEncartonado m on m.idMaquina = C.idMaquina
                WHERE c.cochePasado = 0
                AND c.coche = '$cocheTicketBuscar'
                and C.idMaquina= '$maquina'
                and cast(c.fechaEncartonado as date) = '$fechaEncartonado'
                and c.turnoEncartonado = '$turnoEncartonado'
                order by en.inicioEnfriamiento
            ")->queryAll();
            
            }

        	return json_encode($Coches);

    	} catch (Exception $e) {
    		return json_encode($e);
    	}
    }

    public function actionConfirmarasignacion()
    {
		
		$this->layout = 'spa';
		$transaction = \Yii::$app->db1->beginTransaction();
    	try {

    		$proceso = @$_POST['proceso'];
            $fechaEncartonado = @$_POST['fechaEncartonado'];
            $turnoEncartonado = @$_POST['turnoEncartonado'];
    		$valor = @$_POST['valor'];

            $confirmacionCoche = \Yii::$app->db1->createCommand("exec spConfirmarCocheTicket @proceso='$proceso', @fechaEncartonado='$fechaEncartonado', @turnoEncartonado='$turnoEncartonado', @valor='$valor'") 
                ->execute();

            $transaction->commit();
            //}

    		return json_encode($confirmacionCoche);

        	} catch (Exception $e) {
        		$transaction->rollback();
        		return json_encode($e);
        	}    	
    }

    public function actionValidamateriales()
    {

        $proceso = $_POST['proceso'];
        $valor = $_POST['valor'];

        $RespuestaMatriculacion = \Yii::$app->db1->createCommand("exec spValidarMaterialesMaquina @coche = '$valor',@proceso = '$proceso'") 
        ->queryAll();

        return json_encode($RespuestaMatriculacion);
    }

}