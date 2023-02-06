<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;


class MatriculacionPersonalEncartonadoController extends Controller
{

     public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','buscarcolaborador','matricularcolaborador', 'vercolaboradoresmatriculados', 'revertirmatriculacion','buscarcolaboradormatriculados', 'revertirmatriculapersonal'],
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
            SELECT idMaquina, cnoMaquina
            FROM maquinaencartonado") 
        ->queryAll();

        $Procesos = \Yii::$app->db1->createCommand("
        SELECT idCargoOEE,codigoCargoOEE,detalleCargoOEE 
        FROM cargosOEE") 
        ->queryAll();        

        return $this->render('index',
            ['AllMaquinas'=>$AllMaquinas,
            'Procesos'=>$Procesos]);
    }

    public function actionBuscarcolaborador()
    {
    	$colaboradorBuscar = @$_POST['colaboradorBuscar'];
    	$fechaEncartonado = $_POST['fechaEncartonado'];
    	$turnoEncartonado = $_POST['turnoEncartonado']; 
    	$maquina = $_POST['maquina']; 

    	$AllcolaboradorBuscar = \Yii::$app->db1->createCommand("
			SELECT top 10 nciPersonalEventual cciUsuario,cnoPersonalEventual CnoUsuario,capPersonalEventual CnoUsuario2, cidPersonalEventual
			FROM TblPersonalEventual 
			WHERE cciCentroCosto in (SELECT cciCentroCosto 
									FROM TblCentroCosto 
									where cnoCentroCosto like '%encartonado%' )
									AND nciPersonalEventual not IN (select cciUsuario from  matriculacionPersonalEncartonado
																	where cast(fechaMatriculacion as date) = cast('$fechaEncartonado' as date)
																	and turnoMatriculacion = '$turnoEncartonado'
                                                                    and ocupado = 1)
			AND cnoPersonalEventual like '%$colaboradorBuscar%'") 
        ->queryAll();

    	return json_encode($AllcolaboradorBuscar);
    }

    public function actionMatricularcolaborador()
    {	
    	$fechaEncartonado = $_POST['fechaEncartonado'];
    	$turnoEncartonado = $_POST['turnoEncartonado'];
    	$maquina = $_POST['maquina'];
    	$colaboradores = $_POST['colaboradores'];
        $procesos = $_POST['procesos'];

        $RespuestaMatriculacion = \Yii::$app->db1->createCommand("exec spMatricularPersonalEncartonado :fechaEncartonado, :turnoEncartonado, :maquina,:colaboradores,:opcion,:usuario,:procesos") 
        ->bindValue(':fechaEncartonado', $fechaEncartonado)
        ->bindValue(':turnoEncartonado', $turnoEncartonado)
        ->bindValue(':maquina', $maquina)
        ->bindValue(':colaboradores', $colaboradores)
        ->bindValue(':opcion', 1)
        ->bindValue(':usuario', 'sa')
        ->bindValue(':procesos', $procesos)
        ->queryAll();

    	return json_encode($RespuestaMatriculacion);
    }

    public function actionVercolaboradoresmatriculados()
    {
        $fechaEncartonado = $_POST['fechaEncartonado'];
        $turnoEncartonado = $_POST['turnoEncartonado'];
        $maquina = $_POST['maquina'];

        $AllcolaboradorBuscar = \Yii::$app->db1->createCommand("
           SELECT nciPersonalEventual cciUsuario,cnoPersonalEventual CnoUsuario,capPersonalEventual CnoUsuario2, cidPersonalEventual, C.detalleCargoOEE
            FROM  matriculacionPersonalEncartonado M
                INNER JOIN TblPersonalEventual P ON M.CCIUSUARIO = P.nciPersonalEventual
                INNER JOIN cargosOEE C ON C.codigoCargoOEE = M.codigoCargoOEE
            WHERE cast(M.fechaMatriculacion as date) = cast('$fechaEncartonado' as date)
                AND M.turnoMatriculacion = '$turnoEncartonado'
                AND M.IDMAQUINA = '$maquina'") 
        ->queryAll();

        return json_encode($AllcolaboradorBuscar);
    }
    /*desde aqui se programa para revertir el personal que ya esta matriculado*/
    public function actionRevertirmatriculacion()
    {
        $AllMaquinas = \Yii::$app->db1->createCommand("
            SELECT idMaquina, cnoMaquina
            FROM maquinaencartonado") 
        ->queryAll();

        return $this->render('revertirmatriculacion',
                            ['AllMaquinas'=>$AllMaquinas]);
    }

    public function actionBuscarcolaboradormatriculados()
    {
    	$colaboradorBuscar = @$_POST['colaboradorBuscar']; 
        $maquina = @$_POST['maquina']; 

		$AllcolaboradorBuscar = \Yii::$app->db1->createCommand("
            SELECT top 10 T.nciPersonalEventual cciUsuario,T.cnoPersonalEventual CnoUsuario,T.capPersonalEventual CnoUsuario2, T.cidPersonalEventual,CnoMaquina,C.detalleCargoOEE
            FROM TblPersonalEventual T
            INNER JOIN matriculacionPersonalEncartonado M ON M.cciUsuario = T.nciPersonalEventual
            INNER JOIN MaquinaEncartonado MA ON M.idMaquina = MA.IdMaquina
            INNER JOIN CARGOSOEE C ON C.codigoCargoOEE = M.codigoCargoOEE
            WHERE T.cciCentroCosto in (SELECT cciCentroCosto 
                                    FROM TblCentroCosto 
                                    where cnoCentroCosto like '%encartonado%' )
                                    AND nciPersonalEventual IN (select cciUsuario from  matriculacionPersonalEncartonado
                                                                    where ocupado = 1 
                                                                    and cast(fechaMatriculacion as DATE) = CAST(getdate()AS DATE) )
            AND M.idMaquina = '$maquina'                                                                    
            AND cast(M.fechaMatriculacion as date) = cast(GETDATE() as date)
            AND M.ocupado = 1
			AND cnoPersonalEventual like '%$colaboradorBuscar%'") 
        ->queryAll();

    	return json_encode($AllcolaboradorBuscar);
    }

    public function actionRevertirmatriculapersonal()
    {	

    	$colaboradores = $_POST['colaboradores'];

        $RespuestaMatriculacion = \Yii::$app->db1->createCommand("exec spMatricularPersonalEncartonado @colaboradores = '$colaboradores',@opcion = 2") 
        ->queryAll();

    	return json_encode($RespuestaMatriculacion);
    }

}
