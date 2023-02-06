<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;

?>
<div class="row">        
  <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4'> 
              <label>Fecha de Encartonado</label>         
              <?= DateTimePicker::widget([
                    'name' => 'fechaEncartonado',
                    'options' => ['class' => 'form-control control-encartonado','id' => 'fechaEncartonado'],
                    'value' => date('Y-m-d H:i:s'),
                    'readonly' => true,
                    'pluginOptions' => [
                      'autoclose' => true,
                      'format' => 'yyyy-mm-dd hh:ii:ss'
                    ]
                  ]);
              ?>
  </div>
  <div class='col-xs-12 col-sm-2 col-ls-2 col-md-2 '>
              <label>Turno</label>
               <?php echo Html::dropDownList('turnoEncartonado', 'turnoEncartonado_id', array(
                        '1'=>'Turno 1',
                        '2'=>'Turno 2',),
                      array('class'=>'form-control control-encartonado','id' => 'turnoEncartonado')); ?>
  </div>
  <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
            <div class="form-group">
              <label>Máquinas encartonado</label>
              	<select id="maquina" class="form-control control-encartonado">
                <?php
        				foreach($AllMaquinas as $row)
        				    {
        				?>
                    <option value='<?php echo $row['idMaquina'];?>' ><?php echo $row['cnoMaquina'];?></option>	
        				<?php
        				    }
        				?>              
                </select>
            </div>
  </div>
  <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
            <div class="form-group">
              <label>Procesos</label>
                <select id="procesos" class="form-control control-encartonado">
                <?php
                foreach($Procesos as $row)
                    {
                ?>
                    <option value='<?php echo $row['codigoCargoOEE'];?>' ><?php echo $row['detalleCargoOEE'];?></option>  
                <?php
                    }
                ?>              
                </select>
            </div>
  </div>  
  <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
      <div class="form-group">
        <label></label>
        <button class="btn-success form-control" onclick="verMatriculados()" type="button" data-toggle="modal" data-target="#Modal-ver-matriculados"  id="btn-ver-reporte" >Ver matriculados</button>                
      </div>
  </div>  

</div> 
<div class="row">
  <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12 '>
    <button class="btn-primary form-control" id="btn-matricular-personal" onclick="matriculaPersonal()"> Matricular Personal</button>
  </div>
</div>
<br>
<div class="row"> 
  <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
    <input type="text" name="text-colaborador-buscar" id="text-colaborador-buscar" class="form-control" placeholder="Ingrese el nombre del colaborador">
      <span id="span-cargando-data" style="display: none">Buscando colaboradores...</span>
  </div>
</div>
<br>
<div class="row tabla-resultados-personal" style="display: none">
  <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
    <div >
      <div class=" table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Nombre colaborador</th>
              <th scope="col">Acción</th>
            </tr>
          </thead>
          <tbody class="resultado-busqueda" id="resultado-busqueda">
          </tbody>
        </table>
      </div>
    </div>
  </div>  
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-ls-12 col-md-12 ">
    <input type="text" name="colaboradores" id="colaboradores" class="form-control" placeholder="Colaboradores" readonly="true">
  </div>  
</div>


<!-- Modal de las paras programadas y no programadas-->
<div class="modal fade bd-example-modal-lg" id="Modal-ver-matriculados" tabindex="-1" role="dialog" aria-labelledby="Modal-ver-matriculados" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="">Colaboradores matriculados</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row"> 
            <div class="matriculados-resultado">
            </div>            
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>


<?php
$script = <<< JS
$( "#text-colaborador-buscar" ).keyup(function(event) {
  var colaboradorBuscar = $("#text-colaborador-buscar").val();
  buscarColaborador(colaboradorBuscar);
});

$( ".control-encartonado" ).change(function(event) {
  var colaboradorBuscar = $("#text-colaborador-buscar").val();
  buscarColaborador(colaboradorBuscar);
  $("#colaboradores").val("");
});

JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">

  function buscarColaborador(colaboradorBuscar)
  {
      var fechaEncartonado = $("#fechaEncartonado").val();
      var turnoEncartonado = $("#turnoEncartonado").val();
      var maquina = $("#maquina").val();


      $.ajax({
              url: 'buscarcolaborador', 
              type : 'POST',
              datatype : 'json',       
              data : {'colaboradorBuscar':colaboradorBuscar,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'maquina':maquina},
              beforeSend: function() {   
                $("#span-cargando-data").show();
                $(".tabla-resultados-personal").hide();
              },                
              success: function(data) { 
              $("#span-cargando-data").hide(); 

                var obj = jQuery.parseJSON(data);
                var html = "";

                if (obj.length>0) {
                  $(".tabla-resultados-personal").show();
                }else{
                  $(".tabla-resultados-personal").hide();
                }

                $.each(obj, function(i, item) {                 
                 
                    var colaboradores = $("#colaboradores").val();          
                    var textoseparado = colaboradores.split("|");
                    var i = textoseparado.indexOf(item.cciUsuario);
                        if ( i !== -1 ) {
                            html += "<tr id='"+item.cciUsuario+"'><td>"+item.cciUsuario+" </td><td>"+item.CnoUsuario+" "+item.CnoUsuario2+" ("+item.cidPersonalEventual+")</td><td><button value='"+item.cciUsuario+"' class='form-control btn-danger' onclick='AgregarColaborador(this)'>Descartar</button></td></tr>";                        
                        }else{
                            html += "<tr id='"+item.cciUsuario+"'><td>"+item.cciUsuario+" </td><td>"+item.CnoUsuario+" "+item.CnoUsuario2+" ("+item.cidPersonalEventual+")</td><td><button value='"+item.cciUsuario+"' class='form-control btn-primary' onclick='AgregarColaborador(this)'>Agregar</button></td></tr>";
                        }
                });

                $('#resultado-busqueda').html(html);           
              },error:function(){
                $(".tabla-resultados-personal").hide();
                $("#span-cargando-data").hide();
                $('#resultado-busqueda').find('option').remove(); 
              }
          }); 
  }


  function AgregarColaborador(e)
  {
        
    var colaboradores = $("#colaboradores").val();
    var id = e.value;

    if (colaboradores != "") {

          var textoseparado = colaboradores.split("|");
          //busco en el array si existe el valor
          var i = textoseparado.indexOf(id);

          if ( i !== -1 ) {
              textoseparado.splice( i, 1 );
                var arrayNuevo = ""
              $.each(textoseparado, function (ind, elem) {
                if (elem != "") {
                  arrayNuevo =arrayNuevo +elem+'|';
                }                                             
                }); 
              $("#colaboradores").val(arrayNuevo);     
          }else{
                $("#colaboradores").val(colaboradores+id+"|");
          }
    }else{
      $("#colaboradores").val(id+"|");
    } 

    $("#"+id).hide();                  
  }

  function matriculaPersonal()
  {
    var fechaEncartonado = $("#fechaEncartonado").val();
    var turnoEncartonado = $("#turnoEncartonado").val();
    var maquina = $("#maquina").val();
    var colaboradores = $("#colaboradores").val();
    var procesos = $("#procesos").val();

    valores = {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'maquina':maquina,'colaboradores':colaboradores,'procesos':procesos}

        $.ajax({
          url: 'matricularcolaborador', 
          type : 'POST',      
          datatype : 'json',
          data : valores, 
          beforeSend: function() {   

          },
          success: function(data) {
            var obj = jQuery.parseJSON(data);

            alert(obj[0].mensaje);
            $("#colaboradores").val("");

          },error:function(){
            alert("Hubo un error en el proceso");
          }
          }); 
  }

  function verMatriculados()
  {
    var fechaEncartonado = $("#fechaEncartonado").val();
    var turnoEncartonado = $("#turnoEncartonado").val();
    var maquina = $("#maquina").val();
    valores = {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'maquina':maquina}

        $.ajax({
          url: 'vercolaboradoresmatriculados', 
          type : 'POST',      
          datatype : 'json',
          data : valores, 
          beforeSend: function() {   

          },
          success: function(data) {

            var html = "<div class=' table-responsive'><table class='table'><thead><tr><th scope='col'>NCI</th><th scope='col'>Nombres colaborador</th><th scope='col'>Apellidos colaborador</th><th scope='col'>Cargo</th></tr></thead><tbody class='' id=''>";

            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {                 

            html += "<tr><td>"+item.cidPersonalEventual+"</td><td>"+item.CnoUsuario+"</td><td>"+item.CnoUsuario2+"</td><td>"+item.detalleCargoOEE+"</td></tr>"; 

            });

            html +="</tbody></table></div>";

            if (obj.length == 0)
            {
            html = "<h5>No hay colaboradores matriculados.</h5>";
            }
 
            $(".matriculados-resultado").html(html);


          },error:function(){
            alert("Hubo un error en el proceso");
          }
          });         

  }

</script>
