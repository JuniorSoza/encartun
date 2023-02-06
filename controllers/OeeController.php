<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Command;
use yii\helpers\Json;
use yii\filters\AccessControl;


class OeeController extends Controller
{


    public function behaviors()
    {   
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','obtenertrabajadorespormaquina','buscarparasprogramadasnoprogramadas', 'guardarparastemporales', 'actualizarparastemporales','obtenerparasguardadas','obtenerparaguardada','eliminarpara','buscarguardardocumento', 'buscarguardardocumento2', 'obtenercabecera', 'actualizarcabecera'],
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

    public function actionObtenertrabajadorespormaquina()
    {	
    	$maquina = $_POST['maquina'];
        $fechaEncartonado = $_POST['fechaEncartonado'];
        $turnoEncartonado = $_POST['turnoEncartonado'];

        $AllColaboradores = \Yii::$app->db1->createCommand("
        SELECT m.fechaMatriculacion,P.nciPersonalEventual cciUsuario,P.cnoPersonalEventual CnoUsuario,P.capPersonalEventual CnoUsuario2, P.cidPersonalEventual,ca.detalleCargoOEE
        FROM matriculacionPersonalEncartonado m
        INNER JOIN TblPersonalEventual P ON P.nciPersonalEventual = m.cciUsuario
        INNER JOIN cargosOEE ca on ca.codigoCargoOEE = m.codigoCargoOEE
        WHERE idMaquina = '$maquina'
        AND CAST(fechaMatriculacion AS DATE) = CAST('$fechaEncartonado' AS DATE)
        AND turnoMatriculacion = '$turnoEncartonado'") 
        ->queryAll();

    	return json_encode($AllColaboradores);
    }

    public function actionBuscarparasprogramadasnoprogramadas()
    {
    	$paraBuscar = $_POST['paraBuscar'];

    	$AllParasProgramadasNoProgramadas = \Yii::$app->db1->createCommand("
		SELECT top 10 IdParada,CodigoParada,CodigoGrupo,Detalle,TipoParada FROM ParadasProgramadasNoProgramadas
		WHERE detalle like '%".$paraBuscar."%'
        or CodigoParada like '".$paraBuscar."%'
		AND Estado=1 ") 
        ->queryAll();
    	

    	return json_encode($AllParasProgramadasNoProgramadas);
    }

    public function actionGuardarparastemporales()
    {
    	$numeroDocumento = $_POST['numeroDocumento'];
    	$horaIniciaPara = $_POST['horaIniciaPara'];
    	$horaFinPara = $_POST['horaFinPara'];
    	$IdParada = $_POST['IdParada'];
    	$observacionPara = $_POST['observacionPara'];    	
    	$detalleParada = $_POST['detalleParada'];
        $opcion = 2;

    	$AllParasProgramadasNoProgramadasGuardadas = \Yii::$app->db1->createCommand("
		exec spGestionOee   @numeroDocumento ='$numeroDocumento',
							@horaInicioPara  ='$horaIniciaPara',
							@horaFinPara ='$horaFinPara',
							@idParada = '$IdParada',
							@observacion ='$observacionPara',
							@detalleParada ='$detalleParada',
                            @opcion = '$opcion'") 
        ->queryAll();
    	

    	return json_encode($AllParasProgramadasNoProgramadasGuardadas);
    }

    public function actionActualizarparastemporales()
    {
        $numeroDocumento = $_POST['numeroDocumento'];
        $horaIniciaPara = $_POST['horaIniciaPara'];
        $horaFinPara = $_POST['horaFinPara'];
        $observacionPara = $_POST['observacionPara'];       
        $idDetalleOEE = $_POST['idDetalleOEE'];
        $opcion = 3;

        $AllParasProgramadasNoProgramadasGuardadas = \Yii::$app->db1->createCommand("
        exec spGestionOee   @numeroDocumento ='$numeroDocumento',
                            @horaInicioPara  ='$horaIniciaPara',
                            @horaFinPara ='$horaFinPara',
                            @observacion ='$observacionPara',
                            @opcion = '$opcion',
                            @idDetalleOEE = '$idDetalleOEE'") 
        ->queryAll();
        

        return json_encode($AllParasProgramadasNoProgramadasGuardadas);
    }    

    public function actionObtenerparasguardadas()
    {
    	$numeroDocumento = $_POST['numeroDocumento'];

    	$AllParasProgramadasNoProgramadasGuardadas = \Yii::$app->db1->createCommand("
        SELECT d.idDetalleOEE,d.numeroRegistro,d.codigoParada,convert(varchar(12),d.horaInicia,108)horaInicia,convert(varchar(12),d.horaFin,108)horaFin,d.cobCabeceraOEE,d.observacion,Cast(DateDiff(minute, d.horaInicia, d.horafin) as numeric(20)) as Minutos
        FROM  CABECERAOEE C
        INNER JOIN detalleoee D ON D.numeroRegistro = C.numeroRegistro
		WHERE C.numeroRegistro = '$numeroDocumento'
		ORDER BY d.idDetalleOEE desc") 
        ->queryAll();
    	

    	return json_encode($AllParasProgramadasNoProgramadasGuardadas);
    }   

    public function actionObtenerparaguardada(){
        $idDetalleOEE = $_POST['idDetalleOEE'];

        $ParaProgramadaNoProgramadaGuardada = \Yii::$app->db1->createCommand("
        SELECT idDetalleOEE,numeroRegistro,codigoParada,convert(varchar(12),horaInicia,108)horaInicia,convert(varchar(12),horaFin,108)horaFin,cobCabeceraOEE,observacion
        FROM  detalleoee
        WHERE idDetalleOEE = '$idDetalleOEE'") 
        ->queryAll();        

        return json_encode($ParaProgramadaNoProgramadaGuardada);
    }

    public function actionEliminarpara()
    {

        $idDetalleOEE = $_POST['idDetalleOEE'];

        $AllParasProgramadasNoProgramadasGuardadas = \Yii::$app->db1->createCommand("
        DELETE detalleoee where idDetalleOEE ='$idDetalleOEE' ") 
        ->execute();
        

        return json_encode("Para eliminada sin novedad");
    }

    public function actionBuscarguardardocumento()
    {
        $numeroDocumento = @$_POST['numeroDocumento'];
        $maquina = @$_POST['maquina'];
        $fechaEncartonado = @$_POST['fechaEncartonado'];
        $turnoEncartonado = @$_POST['turnoEncartonado'];


        $Documento = \Yii::$app->db1->createCommand("
                SELECT * 
                FROM cabeceraOEE 
                WHERE numeroRegistro like '$numeroDocumento'
                AND linea = '$maquina'
                AND turno = '$turnoEncartonado'
                AND fecha = '$fechaEncartonado'") 
        ->queryAll();

        return json_encode($Documento);
    }

    public function actionBuscarguardardocumento2()
    {
        $numeroDocumento = @$_POST['numeroDocumento'];
        $horaIniciaPara = @$_POST['horaIniciaPara'];
        $horaFinPara = @$_POST['horaFinPara'];
        $maquina = @$_POST['maquina'];
        $fechaEncartonado = @$_POST['fechaEncartonado'];
        $turnoEncartonado = @$_POST['turnoEncartonado'];
        $IdParada = @$_POST['IdParada'];
        $observacionPara = @$_POST['observacionPara'];       
        $detalleParada = @$_POST['detalleParada'];
        $opcion = 1;

        $Documento = \Yii::$app->db1->createCommand("
        exec spGestionOee   @numeroDocumento ='$numeroDocumento',
                            @horaInicioPara  ='$horaIniciaPara',
                            @horaFinPara ='$horaFinPara',
                            @maquina = '$maquina',
                            @fechaEncartonado = '$fechaEncartonado',
                            @turnoEncartonado = '$turnoEncartonado',
                            @idParada = '$IdParada',
                            @observacion ='$observacionPara',
                            @detalleParada ='$detalleParada',
                            @opcion = $opcion") 
        ->queryAll();

        return json_encode($Documento);
    }  

    public function actionObtenercabecera()
    {
        $numeroDocumento = @$_POST['numeroDocumento'];

        $Documento = \Yii::$app->db1->createCommand("
        SELECT CA.numeroRegistro,isnull(PR.minProgramadas,0)minProgramadas,isnull(NOPR.minNoProgramadas,0)minNoProgramadas,CA.fecha,isnull(convert(varchar(12),CA.horaInicia,108),'00:00:00')horaInicia,isnull(convert(varchar(12),CA.horaFin,108),'00:00:00')horaFin,isnull(CA.totalLatas,0)totalLatas,isnull(CA.totalLatasDanadas,0)totalLatasDanadas,CA.cobCabeceraOEE,Ca.cerrado
        FROM CABECERAOEE CA
        LEFT JOIN (SELECT sum(Cast(DateDiff(minute, de.horaInicia, de.horafin) as numeric(20))) as minProgramadas,numeroRegistro
                    FROM detalleOEE de
                        INNER JOIN ParadasProgramadasNoProgramadas p on p.CodigoParada = de.codigoParada
                    WHERE P.tipoParada = 'PROGRAMADAS'
                    GROUP BY numeroRegistro) PR ON PR.numeroRegistro = CA.numeroRegistro
        LEFT JOIN (SELECT sum(Cast(DateDiff(minute, de.horaInicia, de.horafin) as numeric(20))) as minNoProgramadas,numeroRegistro
                    FROM detalleOEE de
                        INNER JOIN ParadasProgramadasNoProgramadas p on p.CodigoParada = de.codigoParada
                    WHERE P.tipoParada = 'NO PROGRAMADAS'
                    GROUP BY numeroRegistro) NOPR ON NOPR.numeroRegistro = CA.numeroRegistro
        WHERE CA.numeroRegistro = '$numeroDocumento'") 
        ->queryAll();

        return json_encode($Documento);        
    } 

    public function actionActualizarcabecera()
    {
        $numeroDocumento = @$_POST['numeroDocumento'];
        $horaInicioMaquina = @$_POST['horaInicioMaquina'];
        $horaFinMaquina = @$_POST['horaFinMaquina'];
        $latasDanadas = @$_POST['latasDanadas'];
        $latas = @$_POST['latas'];
        $observacionDocumento = @$_POST['observacionDocumento'];
        $maquina = @$_POST['maquina'];
        $fechaEncartonado = @$_POST['fechaEncartonado'];
        $turnoEncartonado = @$_POST['turnoEncartonado'];

        try {

        
        $DocumentoActualizado = \Yii::$app->db1->createCommand("
        exec spActualizarDocumentoOEE   @numeroDocumento ='$numeroDocumento',
                            @horaInicioMaquina ='$horaInicioMaquina',
                            @horaFinMaquina  = '$horaFinMaquina',
                            @latasDanadas  = '$latasDanadas',
                            @latas  = '$latas',
                            @observacionDocumento  = '$observacionDocumento',
                            @maquina  = '$maquina',
                            @fechaEncartonado  ='$fechaEncartonado',
                            @turnoEncartonado  = '$turnoEncartonado'") 
        ->queryAll();

            return json_encode($DocumentoActualizado);
        } catch (Exception $e) {
            return json_encode($e);
        }
    }

}
