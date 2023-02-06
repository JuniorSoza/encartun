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


class AsignacionCocheController extends Controller
{

    //public $freeAccessActions = ['allcoches','Coches','asignarcoche'];

    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','allcoches','coches', 'tickets', 'asignarcoche','obtenermaquinas'],
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

    public function actionAllcoches()
    {
        $fechaProduccion = $_POST['fechaProduccion'];
        $turnoProduccion = $_POST['turnoProduccion'];
        $proceso = $_POST['proceso'];
        $egreso = @$_POST['egreso'];
        $idMaquina = @$_POST['idMaquinaConf'];
        $view = '';
        $result = '';


        if ($proceso == "SEMIELABORADO") {
            $result = \Yii::$app->db1->createCommand("SELECT d.*,LTRIM(RTRIM(d.ctkIngreCam)) ctkIngreCam,a.nqnstock,a.bstEgresoTotal,m.cnoMarca,substring(p.nombreProductoFT,21,300) Producto,OP= I.nciOp,OF_PT=h.OF_PT,CodigoLata= h.cciCodigoLotePrd,Lote=LTRIM(RTRIM(A.cnqLote)),cast(ISNULL(p.PesoNeto,0) as numeric(12,0))PesoNeto ,maquina = isnull(d3.cnoMaquina,'No Programada')
                from TblEgreCamGenLTC c
            inner join  TblEgreCamGenLTd d on c.nciEgreCamGenLT = d.nciEgreCamGenLT
            inner join TblDevolEncartonadoD d1 on d1.nciEgreCamGenLT = d.nciEgreCamGenLT and d1.ctkIngreCam = d.ctkIngreCam
            INNER JOIN TblStockAtun A  ON A.ctkIngreCam = d.ctkIngreCam
            INNER JOIN TblProducto p on p.cciProducto = A.cciProducto
            INNER JOIN TblMarcas m on m.cciMarca = p.cciMarca
            left join ProgramaEncartonadoD d2 on LTRIM(RTRIM(d.ctkIngreCam)) = LTRIM(RTRIM(d2.ctkIngreCam))
            left join MaquinaEncartonado d3 on d3.IdMaquina = d2.cciMaquina
            left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
            left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado
            left join (SELECT idMaquinaConf, granajeInicio, granajeFin FROM maquinaEncartonadoconf) cf on cf.idMaquinaConf = '$idMaquina'
            WHERE c.nciEgreCamGenLT = '$egreso'
                AND p.pesoNeto between cf.granajeInicio and cf.granajeFin
                AND d.ctkIngreCam not in(SELECT ticket FROM CocheAsignado WHERE SUBSTRING(ticket ,1,1) = 'C')")->queryAll();

            $view = 'asignacionTickets2';

        }else{

            $result = \Yii::$app->db1->createCommand("SELECT b.autoClave,b.parada 
            FROM EnfriamientoLatasDetalle b 
            inner join TblLoteProduccionC A WITH (NOLOCK) on  A.cnqLotePrd = B.loteProduccion
            left join (SELECT idMaquinaConf, granajeInicio, granajeFin FROM maquinaEncartonadoconf) cf on cf.idMaquinaConf = '$idMaquina'
            WHERE CAST(A.dfeLotePrdIni AS DATE) = '$fechaProduccion'
                and a.cciTurno  = '$turnoProduccion'
                and b.pesoNeto between cf.granajeInicio and cf.granajeFin
                and b.asignado = 0
                AND  convert(varchar,b.finEnfriamiento,120 ) <= convert(varchar,GETDATE(),120 )
                group by b.autoClave,b.parada")->queryAll();

            $view =  'allcoches';            
        }
               

        return $this->renderAjax($view , [
                                'result' => $result,
                    ]);     
    } 

    public function actionCoches()
    {
        $fechaProduccion = $_POST['fechaProduccion'];
        $turnoProduccion = $_POST['turnoProduccion'];
        $parada = $_POST['parada'];
        $autoClave = $_POST['autoClave'];
        
        $result = \Yii::$app->db1->createCommand("
            SELECT b.*,CASE 
                WHEN convert(varchar,b.finEnfriamiento,120 ) <= convert(varchar,GETDATE(),120 )
                THEN 1
                ELSE 0
            END AS estado,
            isnull(m.cnoMaquina, 'No programado') maquina, CAST(A.fechaProduccion AS DATE) sd
            FROM EnfriamientoLatasDetalle b 
                INNER JOIN EnfriamientoLatas A WITH (NOLOCK) on  A.id = B.idEnfriamiento
                left JOIN (select c.dfeProgramacion,c.nciTurno,d.nciOP,d.ordenFabricacion_PT,d.ctkIngreCam,m.cnoMaquina,m.idMaquina
                            from programaencartonadoc c
                                INNER JOIN programaencartonadod d on c.nciprogramacion = d.nciprogramacion
                                INNER JOIN maquinaencartonadoconf cf on cf.idmaquinaconf = d.ccimaquina
                                INNER JOIN maquinaencartonado m on cf.idmaquina = m.idMaquina)M on M.nciOP= b.ordenProduccion 
                AND M.ordenFabricacion_PT = b.ordenFabricacion  and m.dfeProgramacion = a.fechaProduccion and m.nciTurno = a.turno            
            WHERE CAST(A.fechaProduccion AS DATE) = '$fechaProduccion'
            and a.turno  = '$turnoProduccion'
            and b.asignado = 0
            AND  convert(varchar,b.finEnfriamiento,120 ) <= convert(varchar,GETDATE(),120 )
            and b.autoClave = '$autoClave'
            and b.parada = '$parada'     
            ")->queryAll();

            return $this->renderAjax('asignacionCoche', [
                                'fechaProduccion' => $fechaProduccion,
                                'turnoProduccion' => $turnoProduccion,
                                'parada' => $parada,
                                'autoClave' => $autoClave,
                                'result' => $result,
                    ]);        

    }

    public function actionTickets()
    {
        $ticket = $_POST['ticket'];

        
        $result = \Yii::$app->db1->createCommand("SELECT
                    OP= I.nciOp ,
                     h.OF_PT
                    ,Ticket=LTRIM(RTRIM(A.ctkIngreCam))
                    ,Fila= LTRIM(RTRIM(A.cciFila))
                    ,CodigoLata= h.cciCodigoLotePrd 
                    ,Lote=LTRIM(RTRIM(A.cnqLote))
                    , StatusTicket=LTRIM(RTRIM(K.cnoStatusLatas))
                    , CodProducto=LTRIM(RTRIM(  A.cciProducto))
                    , Producto=LTRIM(RTRIM(substring(C.nombreProductoFT,21,300))) 
                    , ISNULL(E.cnoCalificacionCtrlCalidad,'SIN CALIFICACION') as 'Calificacion'
                    ,(select cciAutoclaveVuelta from TblEncartonadoD WHERE ctkEncartonado = A.ctkIngreCam) as 'Autoclave_Paradas'
                    , Talla =LTRIM(RTRIM(A.cciTalla))
                    , cast(ISNULL(C.PesoNeto,0) as numeric(12,0))PesoNeto
                    ,Stock= cast(A.nqnstock as numeric(18,0))
                    ,StockCajas = cast( A.nqnstock / j.nqnUnidades as numeric(18,0))
                    , CalificacionCode= ISNULL(LTRIM(RTRIM(E.cciCalificacionCtrlCalidad)),'0')
                    ,m.cnoMarca
                    ,j.nqnUnidades factor
                    ,h.cnoReferencia
                    ,CONVERT(varchar(15), i.dfeEncartonadoIni, 105) as dfeEncartonadoIni
                FROM TblStockAtun A 
                INNER JOIN TblIngreCamGenLTD B ON A.ctkIngreCam = B.ctkIngreCam
                inner join TblIngreCamGenLTC B2 on  B2.nciIngreCamGenLT = B.nciIngreCamGenLT
                INNER JOIN TblProducto C ON A.cciProducto = C.cciProducto
                inner join TblMarcas m on m.cciMarca = c.cciMarca
                INNER JOIN TblTallas D ON A.cciTalla = D.cciTalla
                LEFT JOIN TblCalificacionCtrlCalidad E ON A.cciCalificacionCtrlCalidad = E.cciCalificacionCtrlCalidad
                left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
                left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado
                left join TblEmbalajes J on J.cciEmbalaje = C.cciEmbalaje
                left join tblStatusLatas K on K.cciStatusLatas = H.cciStatusLatas
                left join TblLoteProduccionc l on i.cnqLotePrd = l.cnqLotePrd
                WHERE LTRIM(RTRIM(A.ctkIngreCam)) = '$ticket'   
                    and A.bstEgresoTotal = 0 
                    AND A.nqnstock > 0 ")->queryAll();

            return $this->renderAjax('asignacionTickets', [
                                'ticket' => $ticket,
                                'result' => $result,
                    ]);        

    }

    public function actionAsignarcoche()
    {

       $this->layout = 'spa';
        $transaction = \Yii::$app->db1->beginTransaction();
        try {

                $view = '';

                $proceso = $_POST['proceso'];

                if ($proceso == "SEMIELABORADO") {
                    
                    //spAsignarTicket

                    $RespuestaAsignacion = \Yii::$app->db1->createCommand("exec spAsignarTicket :fechaEncartonado, :turnoEncartonado, :TicketsExcluidos,:idMaquina,:idMaquinaConf, :egreso") 
                    ->bindValue(':fechaEncartonado', $_POST['fechaEncartonado'])
                    ->bindValue(':turnoEncartonado', $_POST['turnoEncartonado'])
                    ->bindValue(':TicketsExcluidos', @$_POST['TicketsExcluidos'])
                    ->bindValue(':idMaquina', $_POST['maquina'])
                    ->bindValue(':idMaquinaConf', $_POST['idMaquinaConf']) 
                    ->bindValue(':egreso', $_POST['egreso'])
                    ->queryAll();

                    $result = \Yii::$app->db1->createCommand("SELECT d.*,LTRIM(RTRIM(d.ctkIngreCam)) ctkIngreCam,a.nqnstock,a.bstEgresoTotal,m.cnoMarca,substring(p.nombreProductoFT,21,300) Producto,OP= I.nciOp,OF_PT=h.OF_PT,CodigoLata= h.cciCodigoLotePrd,Lote=LTRIM(RTRIM(A.cnqLote)),cast(ISNULL(p.PesoNeto,0) as numeric(12,0))PesoNeto from TblEgreCamGenLTC c
                    inner join  TblEgreCamGenLTd d on c.nciEgreCamGenLT = d.nciEgreCamGenLT
                    INNER JOIN TblStockAtun A  ON A.ctkIngreCam = d.ctkIngreCam
                    INNER JOIN TblProducto p on p.cciProducto = A.cciProducto
                    INNER JOIN TblMarcas m on m.cciMarca = p.cciMarca
                    left join TblEncartonadoD H on H.ctkEncartonado = A.ctkIngreCam and H.cciProducto = a.cciProducto
                    left join TblEncartonadoC I on I.nciEncartonado = H.nciEncartonado
                    WHERE c.nciEgreCamGenLT = ".$_POST['egreso']."
                        AND d.ctkIngreCam not in(SELECT ticket FROM CocheAsignado WHERE SUBSTRING(ticket ,1,1) = 'C')")->queryAll();

                    $view = 'asignacionTickets2';                    


                }else{
                    $RespuestaAsignacion = \Yii::$app->db1->createCommand("exec spAsignarCoche :fechaProduccion, :turnoProduccion, :fechaEncartonado, :turnoEncartonado, :CocheExcluidos,:parada,:autoclave,:idMaquina,:idMaquinaConf") 
                    ->bindValue(':fechaProduccion', $_POST['fechaProduccion'])
                    ->bindValue(':turnoProduccion', $_POST['turnoProduccion'])
                    ->bindValue(':fechaEncartonado', $_POST['fechaEncartonado'])
                    ->bindValue(':turnoEncartonado', $_POST['turnoEncartonado'])
                    ->bindValue(':CocheExcluidos', @$_POST['CocheExcluidos'])
                    ->bindValue(':parada', $_POST['parada'])
                    ->bindValue(':autoclave', $_POST['autoClave'])
                    ->bindValue(':idMaquina', $_POST['maquina']) 
                    ->bindValue(':idMaquinaConf', $_POST['idMaquinaConf']) 
                    ->queryAll();
                    
             
                    $result = \Yii::$app->db1->createCommand("SELECT b.autoClave,b.parada 
                        FROM EnfriamientoLatasDetalle b 
                        inner join TblLoteProduccionC A WITH (NOLOCK) on  A.cnqLotePrd = B.loteProduccion
                        WHERE CAST(A.dfeLotePrdIni AS DATE) = '".$_POST['fechaProduccion']."'
                        and a.cciTurno  = ".$_POST['turnoProduccion']."
                        and b.asignado = 0
                        group by b.autoClave,b.parada
                        ORDER BY b.autoClave,b.parada
                        ")->queryAll();
                    $view = 'allcoches' ;
                }
        
                $transaction->commit();


                return $this->renderAjax($view, [
                                'result' => $result,
                                'RespuestaAsignacion' => $RespuestaAsignacion,
                ]);

        } catch (Exception $e) {
            $transaction->rollback();

        }

    }   
    /* AQUI OBTENGO TODAS LAS MAQUINAS QUE ESTAN ACTIVAS PARA SU USO*/
    public function actionObtenermaquinas()
    {
        //maquinas de encartonado
        $proceso = $_POST['proceso'];

        $AllMaquinas = \Yii::$app->db1->createCommand("
            SELECT cf.idMaquinaConf,cf.TipoProceso ,m.idMaquina, m.cnoMaquina, cf.granajeInicio,cf.granajeFin
            ,m.cnoMaquina+' - Gramaje ('+cast(cf.granajeInicio as varchar)+' - '+cast(cf.granajeFin as varchar)+')' NombreMaquina 
            FROM maquinaencartonado m INNER JOIN maquinaencartonadoConf cf on cf.idMaquina = m.idMaquina
            WHERE cf.TipoProceso = '$proceso'") 
        ->queryAll();
        //fin de consulta de maquinas de encartonado
        return json_encode($AllMaquinas);
    }

}
