<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ProgramaProduccionD".
 *
 * @property int $ordenFabricacion_PT
 * @property int $nciProgramacion
 * @property int $nqnSecuencia
 * @property float $nciOP
 * @property string $idCliente
 * @property int $nqnSecuenciaOP
 * @property int $lineaPedido
 * @property string $cciDestino
 * @property int $region
 * @property string $cciPresentacion
 * @property string $cciProducto
 * @property string $cciMarca
 * @property string $cciTalla
 * @property int $nqnTipoTapa
 * @property int $cciProvTapa
 * @property int $cciTapa
 * @property string $cciEmbalaje
 * @property float $nqnKilosOil
 * @property int $bstReproceso
 * @property int $kilosRound
 * @property int $kilosRefrigerados
 * @property int $kilosReprocesos
 * @property int $kilosPiso
 * @property int $kilosTransferenciaCR
 * @property float $nqnFillLomos
 * @property float $nqnFillMigas
 * @property string $cciEspecie
 * @property int $cciCalificacionCtrlCalidad
 * @property int $bstOrigen
 * @property float $nqnRendLomos
 * @property float $nqnRendMigas
 * @property float $nqnRend
 * @property int $nqnCajasProducir
 * @property string $cciLinea
 * @property float $nqnNumFormato
 * @property string $cciCobertura
 * @property int $nqnFactor
 * @property string $cnoObservacion
 * @property float $NP
 * @property float $Espesortapa
 * @property float $Espesorenvase
 * @property int $cciProvEnvase
 * @property string $Zapata
 * @property int $ratio
 * @property string $ItemEnvase
 * @property string $ItemTapa
 * @property int $tipoEnvase
 * @property string $cciTallaMP
 * @property int $subClasificacion
 * @property string $cciTipoLimpieza
 * @property float $nqnKilosHoras
 * @property int $idFichaTecnica
 * @property float $PesoNeto
 * @property float $PesoDrenado
 * @property int $programado
 * @property int $idEmpaquePrimario
 * @property int $proveedorEmpaquePrimario
 * @property string $itemEmpaquePrimario
 * @property int $idEmpaqueSecundario
 * @property int $proveedorEmpaqueSecundario
 * @property string $itemEmpaqueSecundario
 * @property float $nqnFillcaja
 * @property float $nqnTotalLomos
 * @property float $nqnTotalMigas
 * @property float $totalKilosLimpios
 * @property float $nqnTotalFill
 * @property float $nqnPCrudo
 * @property float $nqnPTCrudo
 * @property float $nqnKilosAceite
 * @property string $itemAceite
 * @property int $omitirEnvase
 * @property int $omitirTapa
 * @property int $omitirPrimario
 * @property int $omitirSecundario
 * @property int $omitirAceite
 * @property int $mpSAE
 * @property int $mpGYT
 * @property int $mpConsignacion
 * @property int $procesarMPTurno1
 * @property int $omitirFAO
 * @property string $fecha_creacion
 * @property string $usuario_creacion
 * @property string $maquina_creacion
 * @property string|null $fecha_modificacion
 * @property string|null $usuario_modificacion
 * @property string|null $maquina_modificacion
 * @property int $ventresca
 * @property int $apr
 *
 * @property ProgramaMP[] $programaMPs
 * @property ProgramaProduccionC $nciProgramacion0
 */
class ProgramaProduccionD extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ProgramaProduccionD';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ordenFabricacion_PT', 'nciProgramacion', 'nqnSecuencia', 'nciOP', 'idCliente', 'nqnSecuenciaOP', 'lineaPedido', 'cciDestino', 'region', 'cciPresentacion', 'cciProducto', 'cciMarca', 'cciTalla', 'nqnTipoTapa', 'cciProvTapa', 'cciTapa', 'cciEmbalaje', 'nqnKilosOil', 'bstReproceso', 'kilosRound', 'kilosRefrigerados', 'kilosReprocesos', 'kilosPiso', 'kilosTransferenciaCR', 'nqnFillLomos', 'nqnFillMigas', 'cciEspecie', 'cciCalificacionCtrlCalidad', 'bstOrigen', 'nqnRendLomos', 'nqnRendMigas', 'nqnRend', 'nqnCajasProducir', 'cciLinea', 'nqnNumFormato', 'cciCobertura', 'nqnFactor', 'cnoObservacion', 'NP', 'Espesortapa', 'Espesorenvase', 'cciProvEnvase', 'Zapata', 'ratio', 'ItemEnvase', 'ItemTapa', 'tipoEnvase', 'cciTallaMP', 'subClasificacion', 'cciTipoLimpieza', 'nqnKilosHoras', 'idFichaTecnica', 'PesoNeto', 'PesoDrenado', 'programado', 'idEmpaquePrimario', 'proveedorEmpaquePrimario', 'itemEmpaquePrimario', 'idEmpaqueSecundario', 'proveedorEmpaqueSecundario', 'itemEmpaqueSecundario', 'nqnFillcaja', 'nqnTotalLomos', 'nqnTotalMigas', 'totalKilosLimpios', 'nqnTotalFill', 'nqnPCrudo', 'nqnPTCrudo', 'nqnKilosAceite', 'itemAceite', 'omitirEnvase', 'omitirTapa', 'omitirPrimario', 'omitirSecundario', 'omitirAceite', 'mpSAE', 'mpGYT', 'mpConsignacion', 'procesarMPTurno1', 'omitirFAO', 'fecha_creacion', 'usuario_creacion', 'maquina_creacion'], 'required'],
            [['ordenFabricacion_PT', 'nciProgramacion', 'nqnSecuencia', 'nqnSecuenciaOP', 'lineaPedido', 'region', 'nqnTipoTapa', 'cciProvTapa', 'cciTapa', 'bstReproceso', 'kilosRound', 'kilosRefrigerados', 'kilosReprocesos', 'kilosPiso', 'kilosTransferenciaCR', 'cciCalificacionCtrlCalidad', 'bstOrigen', 'nqnCajasProducir', 'nqnFactor', 'cciProvEnvase', 'ratio', 'tipoEnvase', 'subClasificacion', 'idFichaTecnica', 'programado', 'idEmpaquePrimario', 'proveedorEmpaquePrimario', 'idEmpaqueSecundario', 'proveedorEmpaqueSecundario', 'omitirEnvase', 'omitirTapa', 'omitirPrimario', 'omitirSecundario', 'omitirAceite', 'mpSAE', 'mpGYT', 'mpConsignacion', 'procesarMPTurno1', 'omitirFAO', 'ventresca', 'apr'], 'integer'],
            [['nciOP', 'nqnKilosOil', 'nqnFillLomos', 'nqnFillMigas', 'nqnRendLomos', 'nqnRendMigas', 'nqnRend', 'nqnNumFormato', 'NP', 'Espesortapa', 'Espesorenvase', 'nqnKilosHoras', 'PesoNeto', 'PesoDrenado', 'nqnFillcaja', 'nqnTotalLomos', 'nqnTotalMigas', 'totalKilosLimpios', 'nqnTotalFill', 'nqnPCrudo', 'nqnPTCrudo', 'nqnKilosAceite'], 'number'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['idCliente', 'cciDestino', 'cciPresentacion', 'cciEmbalaje', 'cciEspecie', 'cciLinea', 'cciCobertura'], 'string', 'max' => 6],
            [['cciProducto', 'cciMarca', 'ItemEnvase', 'ItemTapa', 'itemEmpaquePrimario', 'itemEmpaqueSecundario', 'itemAceite'], 'string', 'max' => 50],
            [['cciTalla', 'cciTallaMP'], 'string', 'max' => 10],
            [['cnoObservacion'], 'string', 'max' => 255],
            [['Zapata'], 'string', 'max' => 5],
            [['cciTipoLimpieza'], 'string', 'max' => 3],
            [['usuario_creacion', 'maquina_creacion', 'usuario_modificacion', 'maquina_modificacion'], 'string', 'max' => 100],
            [['nciProgramacion', 'nqnSecuencia'], 'unique', 'targetAttribute' => ['nciProgramacion', 'nqnSecuencia']],
            [['nciProgramacion'], 'exist', 'skipOnError' => true, 'targetClass' => ProgramaProduccionC::className(), 'targetAttribute' => ['nciProgramacion' => 'nciProgramacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ordenFabricacion_PT' => 'Orden Fabricacion Pt',
            'nciProgramacion' => 'Nci Programacion',
            'nqnSecuencia' => 'Nqn Secuencia',
            'nciOP' => 'Nci Op',
            'idCliente' => 'Id Cliente',
            'nqnSecuenciaOP' => 'Nqn Secuencia Op',
            'lineaPedido' => 'Linea Pedido',
            'cciDestino' => 'Cci Destino',
            'region' => 'Region',
            'cciPresentacion' => 'Cci Presentacion',
            'cciProducto' => 'Cci Producto',
            'cciMarca' => 'Cci Marca',
            'cciTalla' => 'Cci Talla',
            'nqnTipoTapa' => 'Nqn Tipo Tapa',
            'cciProvTapa' => 'Cci Prov Tapa',
            'cciTapa' => 'Cci Tapa',
            'cciEmbalaje' => 'Cci Embalaje',
            'nqnKilosOil' => 'Nqn Kilos Oil',
            'bstReproceso' => 'Bst Reproceso',
            'kilosRound' => 'Kilos Round',
            'kilosRefrigerados' => 'Kilos Refrigerados',
            'kilosReprocesos' => 'Kilos Reprocesos',
            'kilosPiso' => 'Kilos Piso',
            'kilosTransferenciaCR' => 'Kilos Transferencia Cr',
            'nqnFillLomos' => 'Nqn Fill Lomos',
            'nqnFillMigas' => 'Nqn Fill Migas',
            'cciEspecie' => 'Cci Especie',
            'cciCalificacionCtrlCalidad' => 'Cci Calificacion Ctrl Calidad',
            'bstOrigen' => 'Bst Origen',
            'nqnRendLomos' => 'Nqn Rend Lomos',
            'nqnRendMigas' => 'Nqn Rend Migas',
            'nqnRend' => 'Nqn Rend',
            'nqnCajasProducir' => 'Nqn Cajas Producir',
            'cciLinea' => 'Cci Linea',
            'nqnNumFormato' => 'Nqn Num Formato',
            'cciCobertura' => 'Cci Cobertura',
            'nqnFactor' => 'Nqn Factor',
            'cnoObservacion' => 'Cno Observacion',
            'NP' => 'Np',
            'Espesortapa' => 'Espesortapa',
            'Espesorenvase' => 'Espesorenvase',
            'cciProvEnvase' => 'Cci Prov Envase',
            'Zapata' => 'Zapata',
            'ratio' => 'Ratio',
            'ItemEnvase' => 'Item Envase',
            'ItemTapa' => 'Item Tapa',
            'tipoEnvase' => 'Tipo Envase',
            'cciTallaMP' => 'Cci Talla Mp',
            'subClasificacion' => 'Sub Clasificacion',
            'cciTipoLimpieza' => 'Cci Tipo Limpieza',
            'nqnKilosHoras' => 'Nqn Kilos Horas',
            'idFichaTecnica' => 'Id Ficha Tecnica',
            'PesoNeto' => 'Peso Neto',
            'PesoDrenado' => 'Peso Drenado',
            'programado' => 'Programado',
            'idEmpaquePrimario' => 'Id Empaque Primario',
            'proveedorEmpaquePrimario' => 'Proveedor Empaque Primario',
            'itemEmpaquePrimario' => 'Item Empaque Primario',
            'idEmpaqueSecundario' => 'Id Empaque Secundario',
            'proveedorEmpaqueSecundario' => 'Proveedor Empaque Secundario',
            'itemEmpaqueSecundario' => 'Item Empaque Secundario',
            'nqnFillcaja' => 'Nqn Fillcaja',
            'nqnTotalLomos' => 'Nqn Total Lomos',
            'nqnTotalMigas' => 'Nqn Total Migas',
            'totalKilosLimpios' => 'Total Kilos Limpios',
            'nqnTotalFill' => 'Nqn Total Fill',
            'nqnPCrudo' => 'Nqn P Crudo',
            'nqnPTCrudo' => 'Nqn Pt Crudo',
            'nqnKilosAceite' => 'Nqn Kilos Aceite',
            'itemAceite' => 'Item Aceite',
            'omitirEnvase' => 'Omitir Envase',
            'omitirTapa' => 'Omitir Tapa',
            'omitirPrimario' => 'Omitir Primario',
            'omitirSecundario' => 'Omitir Secundario',
            'omitirAceite' => 'Omitir Aceite',
            'mpSAE' => 'Mp Sae',
            'mpGYT' => 'Mp Gyt',
            'mpConsignacion' => 'Mp Consignacion',
            'procesarMPTurno1' => 'Procesar Mp Turno1',
            'omitirFAO' => 'Omitir Fao',
            'fecha_creacion' => 'Fecha Creacion',
            'usuario_creacion' => 'Usuario Creacion',
            'maquina_creacion' => 'Maquina Creacion',
            'fecha_modificacion' => 'Fecha Modificacion',
            'usuario_modificacion' => 'Usuario Modificacion',
            'maquina_modificacion' => 'Maquina Modificacion',
            'ventresca' => 'Ventresca',
            'apr' => 'Apr',
        ];
    }


    /**
     * Gets query for [[NciProgramacion0]].
     *
     * @return \yii\db\ActiveQuery|ProgramaProduccionCQuery
     */
    public function getFKProgramaProduccionC()
    {
        return $this->hasOne(ProgramaProduccionC::className(), [ 'nciProgramacion' => 'nciProgramacion']);
    }

    /**
     * {@inheritdoc}
     * @return ProgramaProduccionDQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProgramaProduccionDQuery(get_called_class());
    }
}
