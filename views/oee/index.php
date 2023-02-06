<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\bootstrap4\Modal;
use kartik\datetime\DateTimePicker;
use kartik\time\TimePicker;
?>

<div class="row">        
    <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
      <div class="form-group">
        <label>Máquinas encartonado</label>
          <select id="maquina" class="form-control control-maquina control-encartonado control-cabecera">
          <?php
        	foreach($AllMaquinas as $row)
        			{
        	?>
          <option value='<?php echo $row['idMaquina'];?>' name='<?php echo $row['idMaquina'];?>' ><?php echo $row['cnoMaquina'];?> gramaje (<?php echo $row['granajeInicio']." - ".$row['granajeFin'];?>)</option>	
        	<?php
        			 }
        	?>              
        </select>
      </div>
    </div>
<div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
     <div class="row">
        <div class='col-xs-12 col-sm-8 col-ls-8 col-md-8'>
            <label>Fecha encartonado</label>         
           <?php echo DatePicker::widget(['name' => 'fechaEncartonado',
                'options' => ['class' => 'form-control control-cabecera','id' => 'fechaEncartonado'],
                'attribute' => 'from_date',                                
                'language' => 'es',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),])?>               
        </div>
        <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4'>
            <label>Turno</label>
              <?php echo Html::dropDownList('turnoEncartonado', 'turnoEncartonado_id', array(
                    '1'=>'Turno 1',
                    '2'=>'Turno 2',),
                     array('class'=>'form-control control-cabecera','id' => 'turnoEncartonado')); 
              ?>     
        </div>    
    </div>  
</div>    
</div>
<div class="row">        
    <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6 '>
      <div class="row">
        <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4'> 
        <label>N. documento</label>           
            <input type="text" name="text-numeroDocumento" id="text-numeroDocumento" class="form-control control-cabecera">
        </div>        
        <div class='col-xs-12 col-sm-8 col-ls-8 col-md-8'>   
        <label></label>         
            <button type="button" class="form-control btn btn-primary" id="generarObuscarDocumento">Generar o buscar documento</button>         
        </div>         
      </div>
    <div class="row">
        <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
            <label for="observacion-para">Observación del documento</label>
            <textarea class="form-control controles-cabecera" id="observacion-documento" rows="3" disabled="true"></textarea>
        </div> 
    </div>    
    <div class="row">
      <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
          <label>Hora inicio - Máquina</label>         
                <?php
                  echo TimePicker::widget([
                      'name' => 'horaInicioMaquina',
                      'id' => 'horaInicioMaquina',
                      'class' =>'control-encartonado',
                      'pluginOptions' => [
                          'showSeconds' => true,
                          'showMeridian' => false,
                          'minuteStep' => 5,
                          'secondStep' => 5,
                      ]
                  ]);
                ?>          
      </div>
      <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
        <label>Hora fin - Máquina</label>         
                <?php
                  echo TimePicker::widget([
                      'name' => 'horaFinMaquina',
                      'id' => 'horaFinMaquina',
                      'class' =>'control-encartonado',
                      'pluginOptions' => [
                          'showSeconds' => true,
                          'showMeridian' => false,
                          'minuteStep' => 5,
                          'secondStep' => 5,
                      ]
                  ]);
                ?> 
      </div>         
    </div>    
      <div class="row">
       <div class='col-xs-12 col-sm-3 col-ls-3 col-md-3'>
            <label>L. totales</label>
            <input type="text" name="cant-latas" id="cant-latas" class="form-control" disabled="true">          
        </div>          
        <div class='col-xs-12 col-sm-3 col-ls-3 col-md-3'>
            <label>L. dañadas</label>
            <input type="text" name="cant-latas-danadas" id="cant-latas-danadas" class="form-control" disabled="true" value=0>          
        </div> 
        <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6'>
            <label></label>
            <button class="form-control btn btn-primary controles-cabecera" id="btn-guardar-cabecera" onclick="actualizarCabecera()" disabled="true">Actualizar cabecera</button>         
        </div>
      </div>       
    </div>
    <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6 '>
      <div class="alert alert-success" role="alert">
        Hora Inicio: <span id="div-horaInicioMaquina"></span><br> 
        Hora Fin: <span id="div-horaFinMaquina"></span> <br>
        Tiempo total paras programadas: <span id="div-tiempo-parasprogramadas"></span> <br>
        Tiempo total paras no programadas: <span id="div-tiempo-parasnoprogramadas"></span>
      </div>        
      <div class="row">     
          <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
            <label></label>
            <button type="button" data-toggle="modal" data-target="#Modal-parasprogramadas-parasnoprogramadas"  name="agregar-paras" id="btn-modal-paras" class="form-control btn-danger controles-cabecera" disabled="true">Agregar Paras</button>
          </div>                       
      </div>      
    </div>          
</div> 
<br>      
  <div class="row">
    <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12 '>
      <div class="resultado-paras-guardadas" id="resultado-paras-guardadas">        
      </div>   
    </div>
  </div>
<br>      
  <div class="row">
    <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12 '>
        <div id="datos-colaboradores">
          
        </div> 
    </div>
  </div>  
</div>


<!-- Modal de las paras programadas y no programadas-->
<div class="modal fade bd-example-modal-lg" id="Modal-parasprogramadas-parasnoprogramadas" tabindex="-1" role="dialog" aria-labelledby="Modal-parasprogramadas-parasnoprogramadas" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="Modal-parasprogramadas-parasnoprogramadas">Agregar paras</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">        
            <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6 '> 
              <input type="hidden" name="idDetalleOEE" id="idDetalleOEE">       
                <?php
                  echo '<label>Hora Inicio para</label>';
                  echo TimePicker::widget([
                      'name' => 'horaIniciaPara',
                      'id' => 'horaIniciaPara',
                      'options' => [
                          'readonly' => true,
                      ],
                      'pluginOptions' => [
                          'showSeconds' => true,
                          'showMeridian' => false,
                          'minuteStep' => 5,
                          'secondStep' => 5,                          
                      ]
                  ]);
                ?>
            </div>  
            <div class='col-xs-12 col-sm-6 col-ls-6 col-md-6 '> 
                <?php
                  echo '<label>Hora Fin para</label>';
                  echo TimePicker::widget([
                      'name' => 'horaFinPara',
                      'id' => 'horaFinPara',
                      'options' => [
                          'readonly' => true,
                      ],
                      'pluginOptions' => [
                          'showSeconds' => true,
                          'showMeridian' => false,
                          'minuteStep' => 5,
                          'secondStep' => 5,                          
                      ]
                  ]);
                ?>
            </div>            
        </div> 
        <br>
        <div class="row"> 
          <div id="opciones-buscador-paras">          
            <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
              <input type="text" name="text-para-buscar" id="text-para-buscar" class="form-control" placeholder="Ingrese la para">
                <span id="span-cargando-data" style="display: none">Buscando colaboradores...</span>
            </div>
            <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
              <div class="resultado-paras" id="resultado-paras"></div>           
            </div>
          </div> 
          <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
              <label for="observacion-para">Observación de la para</label>
              <textarea class="form-control" id="observacion-para" rows="3"></textarea>
          </div>               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-agregar-para" onclick="agregarActualizarPara(this.id)">Agregar Para</button>
      </div>
    </div>
  </div>
</div>


<?php
$script = <<< JS
$( ".control-encartonado" ).change(function(event) {
    cargarFechasTiempoMaquina();
});
$( "#text-para-buscar" ).keyup(function(event) {
  var paraBuscar = $("#text-para-buscar").val();
  Buscarparasprogramadasnoprogramadas(paraBuscar);
});

$("#btn-modal-paras").click(function(){
  $("#observacion-para").val("");
  $("#opciones-buscador-paras").show();
  $("#btn-editar-para").attr("id","btn-agregar-para");
  $("#btn-agregar-para").html("Guardar Para");

  //obtener la hora actual
  var hora = new Date().getHours()         // Get the hour (0-23)
  var minuto =  new Date().getMinutes()       // Get the minutes (0-59)
  var segundos = new Date().getSeconds()       // Get the seconds (0-59)

  $("#horaIniciaPara").val(hora+':'+minuto+':'+segundos);
  $("#horaFinPara").val(hora+':'+minuto+':'+segundos);
  
});

$(".control-cabecera").change(function(){
  vaciarCampos();
});



$("#generarObuscarDocumento").click(function(){
  gestionDocumento();
});

JS;
$this->REGISTERJS($script);
?>

<script type="text/javascript">

  function cargarFechasTiempoMaquina()
  {
    
    var horaInicioMaquina = $("#horaInicioMaquina").val();
    var horaFinMaquina = $("#horaFinMaquina").val();
    $('#div-horaInicioMaquina').html("");
    $('#div-horaInicioMaquina').append(horaInicioMaquina);
    $('#div-horaFinMaquina').html("");
    $('#div-horaFinMaquina').append(horaFinMaquina);

    //cargar los colaboradores que trabajaron en esta maquina
    ObtenerTrabajadoresPorMaquina();
  }

  function ObtenerTrabajadoresPorMaquina()
  {
        var maquina = $("#maquina").val();
        var fechaEncartonado = $("#fechaEncartonado").val();
        var turnoEncartonado = $("#turnoEncartonado").val();
        var valores = {'maquina':maquina,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado};

        $.ajax({
          url: 'obtenertrabajadorespormaquina', 
          type : 'POST',      
          datatype : 'json',
          data : valores, 
          beforeSend: function() {   

          },
          success: function(data) {

            var html = "<span>Listado de los colaboradores que trabajan en esta línea</span><div class=' table-responsive'><table class='table'><thead><tr><th scope='col'>Código</th><th scope='col'>NCI</th><th scope='col'>Nombres colaborador</th><th scope='col'>Apellidos colaborador</th><th scope='col'>Cargo</th></tr></thead><tbody class='' id=''>";

            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {                 

            html += "<tr><td>"+item.cciUsuario+"</td><td>"+item.cidPersonalEventual+"</td><td>"+item.CnoUsuario+"</td><td>"+item.CnoUsuario2+"</td><td>"+item.detalleCargoOEE+"</td></tr>"; 

            });

            html +="</tbody></table></div>";

            if (obj.length == 0)
            {
            html = "<h5>No hay colaboradores que mostrar.</h5>";
            }
 
            $("#datos-colaboradores").html(html);


          },error:function(){
            alert("Hubo un error en el proceso");
          }
          });    
  }

  function Buscarparasprogramadasnoprogramadas(paraBuscar)
  {

        $.ajax({
          url: 'buscarparasprogramadasnoprogramadas', 
          type : 'POST',      
          datatype : 'json',
          data : {'paraBuscar':paraBuscar}, 
          beforeSend: function() {   

          },
          success: function(data) {

            var html = "<div class=' table-responsive'><table class='table'><thead><tr><th scope='col'>Acción</th><th scope='col'>Cod Parada</th><th scope='col'>Cod Grupo</th><th scope='col'>Detalle</th><th scope='col'>Tipo Parada</th></tr></thead><tbody>";

            var obj = jQuery.parseJSON(data);
            $.each(obj, function(i, item) {                 

            Detalle2 = '"'+item.Detalle+'"';

            html += "<tr><td><button onclick='agregarParaTemporal("+item.IdParada+","+item.CodigoParada+","+Detalle2+")' class='btn btn-primary'>Agregar</button></td><td>"+item.CodigoParada+"</td><td>"+item.CodigoGrupo+"</td><td>"+item.Detalle+"</td><td>"+item.TipoParada+"</td></tr>";

            });

            html +="</tbody></table></div>";

            if (obj.length == 0)
            {
            html = "<h5>Busque las paras.</h5>";
            }
 
            $("#resultado-paras").html(html);

          },error:function(){
            alert("Hubo un error en el proceso");
          }
          });     
  }

  function agregarParaTemporal(IdParada,CodigoParada,Detalle)
  { 
    var html = "<br><div class='row'><div class='col-xs-3 col-sm-3 col-ls-3 col-md-3'><input type='hidden' readonly='true' class='form-control' id='IdParada' name='IdParada' value='"+CodigoParada+"'><input type='text' readonly='true' class='form-control' name='CodigoParada' value='"+CodigoParada+"'></div><div class='col-xs-9 col-sm-9 col-ls-9 col-md-9'><input type='text' readonly='true' name='Detalle' id='detalleParada' class='form-control' value='"+Detalle+"'></div></div>";
    
    $("#resultado-paras").html(html);  
  }

  function guardarParasTemporales()
  {
      var horaIniciaPara = $("#horaIniciaPara").val();
      var horaFinPara = $("#horaFinPara").val();
      var IdParada = $("#IdParada").val();
      var observacionPara = $("#observacion-para").val();   
      var detalleParada = $("#detalleParada").val();
      var numeroDocumento = $("#text-numeroDocumento").val();


      if (horaIniciaPara != "") {
          if (IdParada != "") {
            if (observacionPara != "") {
                var valores = {'numeroDocumento':numeroDocumento,'horaIniciaPara':horaIniciaPara,'horaFinPara':horaFinPara,'IdParada':IdParada,'observacionPara':observacionPara,'detalleParada':detalleParada};

                  $.ajax({
                      url: 'guardarparastemporales', 
                      type : 'POST',      
                      datatype : 'json',
                      data : valores, 
                      beforeSend: function() {   

                      },
                      success: function(data) {

                      //alert(data);
                      //aqui debo ocultar el modal nuevamente  
                      $("#Modal-parasprogramadas-parasnoprogramadas").modal('hide');

                      obtenerParasGuardadas(numeroDocumento);

                      },error:function(){
                        alert("Hubo un error en el proceso");
                      }
                      });
            }else{
        alert("debe ingresar la observacion")
      }
          }else{
        alert("debe ingresar la parada")
      }      
      }else{
        alert("debe ingresar la hora de inicio")
      }
  }

  function obtenerParasGuardadas(numeroDocumento)
  {
      $.ajax({
      url: 'obtenerparasguardadas', 
      type : 'POST',      
      datatype : 'json',
      data : {'numeroDocumento':numeroDocumento}, 
      beforeSend: function() {   

      },
      success: function(data) {
            var html = "<div class=' table-responsive'><table class='table'><thead><tr><th scope='col'>Código para</th><th scope='co'>Descripcion de la para</th><th scope='col'>Hora inicio</th><th scope='col'>Hora fin</th><th scope='col'>Minutos</th><th scope='col'>Observación</th><th scope='col'>Acciones</th></tr></thead><tbody>";

            var obj = jQuery.parseJSON(data); 

            $.each(obj, function(i, item) {                 

            html += "<tr><td>"+item.codigoParada+"</td><td>"+item.cobCabeceraOEE+"</td><td>"+item.horaInicia+"</td><td>"+item.horaFin+"</td><td>"+item.Minutos+"</td><td>"+item.observacion+"</td><td><button type='button' onclick='eliminarPara("+item.idDetalleOEE+")' class='btn btn-danger controles-cabecera'>E</button><button type='button' onclick='editarPara("+item.idDetalleOEE+")' class='btn btn-primary  controles-cabecera'>M</button></td></tr>";

            });

            html +="</tbody></table></div>";

            if (obj.length == 0)
            {
            html = "<h5>No hay paras guardadas en esta línea.</h5>";
            }
            $(".controles-cabecera").prop('disabled',false);
            $("#resultado-paras-guardadas").html(html);
            obtenerCabecera(numeroDocumento);

      },error:function(){
        alert("Hubo un error en el proceso");
      }
      });
  }

  function eliminarPara(idDetalleOEE)
  {
    var r = confirm("Desea eliminar la para?");
    if (r == true) {   
      $.ajax({
      url: 'eliminarpara', 
      type : 'POST',      
      datatype : 'json',
      data : {'idDetalleOEE':idDetalleOEE}, 
      beforeSend: function() {   

      },
      success: function(data) {
        alert(data);

        obtenerParasGuardadas($("#text-numeroDocumento").val());
      },error:function(){
        alert("Hubo un error en el proceso");
      }
      });
    }
  }

  function editarPara(idDetalleOEE)
  {
      $("#opciones-buscador-paras").hide();
      $("#btn-agregar-para").attr("id","btn-editar-para");
      $("#btn-editar-para").html("Actualizar Para");
      $("#idDetalleOEE").val(idDetalleOEE);
      $.ajax({
      url: 'obtenerparaguardada', 
      type : 'POST',      
      datatype : 'json',
      data : {'idDetalleOEE':idDetalleOEE}, 
      beforeSend: function() {   

      },
      success: function(data) {

        var obj = jQuery.parseJSON(data);

        $.each(obj, function(i, item) {                 
        
        if (item.horaFin == null)
        {
          //obtener la hora actual
          var hora = new Date().getHours()         // Get the hour (0-23)
          var minuto =  new Date().getMinutes()       // Get the minutes (0-59)
          var segundos = new Date().getSeconds()       // Get the seconds (0-59)

          $("#horaFinPara").val(hora+':'+minuto+':'+segundos);

        }else
        {
          $("#horaFinPara").val(item.horaFin);
        }
        
        $("#horaIniciaPara").val(item.horaInicia);
        
        $("#observacion-para").val(item.observacion);

        }); 


      },error:function(){
        alert("Hubo un error en el proceso");
      }
      });
      $("#Modal-parasprogramadas-parasnoprogramadas").modal('show');
  }

  function gestionDocumento()
  {
    var numeroDocumento = $("#text-numeroDocumento").val();
    var maquina = $("#maquina").val(); 
    var fechaEncartonado = $("#fechaEncartonado").val(); 
    var turnoEncartonado = $("#turnoEncartonado").val();   
    var horaInicioMaquina = $("#horaInicioMaquina").val();
    var horaFinMaquina = $("#horaFinMaquina").val();


    var valores = {'numeroDocumento':numeroDocumento,'maquina':maquina,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'horaIniciaPara':horaInicioMaquina,'horaFinPara':horaFinMaquina}

     $.ajax({
          url: 'buscarguardardocumento', 
          type : 'POST',      
          datatype : 'json',
          data : valores, 
          beforeSend: function() {   

          },
          success: function(data) {
              var obj = jQuery.parseJSON(data);


              $.each(obj, function(i, item) {
               

              $("#text-numeroDocumento").val(item.numeroRegistro);
              obtenerParasGuardadas(item.numeroRegistro);
              ObtenerTrabajadoresPorMaquina();              
                         

              });  
              if (obj.length == 0) {
                    var r = confirm("No se encontro el documento, desea crear uno?");
                    if (r == true) { 

                     $.ajax({
                          url: 'buscarguardardocumento2', 
                          type : 'POST',      
                          datatype : 'json',
                          data : valores, 
                          beforeSend: function() {   

                          },
                          success: function(data) {
                              var obj = jQuery.parseJSON(data);

                              $.each(obj, function(i, item) {                 
                              
                              $("#text-numeroDocumento").val(item.numeroRegistro);
                              obtenerParasGuardadas(item.numeroRegistro);

                              }); 
                          }
                          });
                    }else{
                        $(".controles-cabecera").prop('disabled',true);
                        $("#datos-colaboradores").html("");                     
                    }
              }   

          }
          });

  }

  function agregarActualizarPara(id)
  {

    if (id == "btn-agregar-para") {
      guardarParasTemporales();
    }else{
      actualizarParasTemporales();
    }

  }
  function actualizarParasTemporales()
  {
      var horaIniciaPara = $("#horaIniciaPara").val();
      var horaFinPara = $("#horaFinPara").val();
      var observacionPara = $("#observacion-para").val();   
      var numeroDocumento = $("#text-numeroDocumento").val();
      var idDetalleOEE = $("#idDetalleOEE").val();


      if (horaIniciaPara != "") {
            if (observacionPara != "") {
                var valores = {'numeroDocumento':numeroDocumento,'horaIniciaPara':horaIniciaPara,'horaFinPara':horaFinPara,'observacionPara':observacionPara,'idDetalleOEE':idDetalleOEE};

                  $.ajax({
                      url: 'actualizarparastemporales', 
                      type : 'POST',      
                      datatype : 'json',
                      data : valores, 
                      beforeSend: function() {   

                      },
                      success: function(data) {

                      $("#Modal-parasprogramadas-parasnoprogramadas").modal('hide');

                      obtenerParasGuardadas(numeroDocumento);

                      },error:function(){
                        alert("Hubo un error en el proceso");
                      }
                      });
            }else{
        alert("debe ingresar la observacion")
      }
     
      }else{
        alert("debe ingresar la hora de inicio")
      }
  }

  function vaciarCampos()
  {
      $("#resultado-paras-guardadas").html("");
      $("#cant-latas").val("");    
      $("#cant-latas-danadas").val("");  
      $("#observacion-documento").val("");
      $("#datos-colaboradores").html(""); 
  
  }

  function obtenerCabecera(numeroDocumento)
  {

    $.ajax({
        url: 'obtenercabecera', 
        type : 'POST',      
        datatype : 'json',
        data : {'numeroDocumento':numeroDocumento}, 
        beforeSend: function() {   

        },
        success: function(data) {

          var obj = jQuery.parseJSON(data);

          $.each(obj, function(i, item) { 
            $("#horaInicioMaquina").val(item.horaInicia);
            $("#horaFinMaquina").val(item.horaFin);
            $("#div-horaInicioMaquina").html(item.horaInicia);
            $("#div-horaFinMaquina").html(item.horaFin);
            $("#cant-latas").val(item.totalLatas);
            $("#observacion-documento").val(item.cobCabeceraOEE);
            $("#cant-latas-danadas").val(item.totalLatasDanadas);
            $("#div-tiempo-parasprogramadas").html(item.minProgramadas);
            $("#div-tiempo-parasnoprogramadas").html(item.minNoProgramadas);
              if (item.cerrado == 1){
                $(".controles-cabecera").prop('disabled',true);
              }else{
                $(".controles-cabecera").prop('disabled',false);
              }
          });
        },error:function(){
          alert("Hubo un error en el proceso");
        }
        });

  }

  function actualizarCabecera()
  {
    
    var r = confirm("Desea actualizar la cabecera del documento?");
    if (r == true) {
      var numeroDocumento = $("#text-numeroDocumento").val();
      var horaInicioMaquina = $("#horaInicioMaquina").val();
      var horaFinMaquina = $("#horaFinMaquina").val();
      var latas = $("#cant-latas").val();    
      var latasDanadas = $("#cant-latas-danadas").val();  
      var observacionDocumento = $("#observacion-documento").val();
      var maquina = $("#maquina").val(); 
      var fechaEncartonado = $("#fechaEncartonado").val(); 
      var turnoEncartonado = $("#turnoEncartonado").val(); 
      var valores = {'numeroDocumento':numeroDocumento,'horaInicioMaquina':horaInicioMaquina,'horaFinMaquina':horaFinMaquina,'latasDanadas':latasDanadas,'latas':latas,'observacionDocumento':observacionDocumento,'maquina':maquina,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado};

      if (horaInicioMaquina != "") {
        if (horaFinMaquina != "" ) {
                  $.ajax({
                      url: 'actualizarcabecera', 
                      type : 'POST',      
                      datatype : 'json',
                      data : valores, 
                      beforeSend: function() {   

                      },
                      success: function(data) {

                        var obj = jQuery.parseJSON(data);

                        $.each(obj, function(i, item) {                           
                          alert(item.MENSAJE);
                          $("#cant-latas").val(item.VALOR);
                          $("#cant-latas-danadas").val(item.VALOR2);

                          if(item.ESTADO== 1){
                              $(".controles-cabecera").prop('disabled',true);                            
                          }else{
                              $(".controles-cabecera").prop('disabled',false);
                          }
                        });
                      },error:function(){
                        alert("Hubo un error en el proceso");
                      }
                      });

        }else{
          alert("debe ingresar la hora final");
        }
      }else{
        alert("debe ingresar la hora de inicio");
      }
    }
  }

</script>