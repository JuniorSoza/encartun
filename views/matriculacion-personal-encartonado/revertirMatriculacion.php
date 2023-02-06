<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

?>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-ls-6 col-md-6 ">
    <div class="form-group">
      <label>Máquinas encartonado</label>
          <select id="maquina" class="form-control control-maquina control-encartonado control-cabecera">
          <?php
          foreach($AllMaquinas as $row)
              {
          ?>
          <option value='<?php echo $row['idMaquina'];?>' name='<?php echo $row['idMaquina'];?>' ><?php echo $row['cnoMaquina'];?></option>  
          <?php
               }
          ?>              
        </select>
     </div>
  </div>
  <div class='col-xs-6 col-sm-6 col-ls-6 col-md-6 '>
    <label></label>
    <button class="btn-primary form-control" id="btn-matricular-personal" onclick="RevertirMatriculaPersonal()">Liberar Matriculación</button>
  </div>  
</div>
<div class="row">
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
              <th scope="col">Cargo</th>
              <th scope="col">Máquina</th>
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


<?php
$script = <<< JS
$( "#text-colaborador-buscar" ).keyup(function(event) {
  var colaboradorBuscar = $("#text-colaborador-buscar").val();
  var maquina = $("#maquina").val();
  buscarColaborador(colaboradorBuscar,maquina);
});

$("#maquina").change(function(){
  var colaboradorBuscar = $("#text-colaborador-buscar").val();
  var maquina = $("#maquina").val();
  buscarColaborador(colaboradorBuscar,maquina);
});

JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">

  function buscarColaborador(colaboradorBuscar,maquina)
  {

      $.ajax({
          url: 'buscarcolaboradormatriculados', 
          type : 'POST',
          datatype : 'json',       
          data : {'colaboradorBuscar':colaboradorBuscar,'maquina':maquina},
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
                        html += "<tr id='"+item.cciUsuario+"'><td>"+item.cciUsuario+" </td><td>"+item.CnoUsuario+" "+item.CnoUsuario2+" ("+item.cidPersonalEventual+")</td><td>"+item.detalleCargoOEE+" </td><td>"+item.CnoMaquina+" </td><td><button value='"+item.cciUsuario+"' class='form-control btn-danger' onclick='AgregarColaborador(this)'>Descartar</button></td></tr>";                        
                    }else{
                        html += "<tr id='"+item.cciUsuario+"'><td>"+item.cciUsuario+" </td><td>"+item.CnoUsuario+" "+item.CnoUsuario2+" ("+item.cidPersonalEventual+")</td><td>"+item.detalleCargoOEE+" </td><td>"+item.CnoMaquina+" </td><td><button value='"+item.cciUsuario+"' class='form-control btn-primary' onclick='AgregarColaborador(this)'>Agregar</button></td></tr>";
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

  function RevertirMatriculaPersonal()
  {

    var colaboradores = $("#colaboradores").val();
    valores = {'colaboradores':colaboradores}

        $.ajax({
          url: 'revertirmatriculapersonal', 
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


</script>
