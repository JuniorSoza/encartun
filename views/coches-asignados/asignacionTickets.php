
<div class="row">
    <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
        <button type="button" id="GuardarCoches" class="btn btn-danger btn-block">Regresar Tickets</button>         
    </div>
</div>
<input type="hidden" name="idMaquina" id="idMaquina" value="0">
<div class="allcoches-form" id="allcoches-form">
  <div class="table-responsive">    
    <table class="table">
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" class="form-check-input" id="checkAll" name="checkAll" onchange="getSeleccionAll()" checked="1"></th>
          <th scope="col">Egreso</th>
          <th scope="col">OP</th>
          <th scope="col">OF</th>
          <th scope="col">Ticket</th>
          <th scope="col">Producto</th>
          <th scope="col">Peso Neto</th>
          <th scope="col">Marca</th>
          <th scope="col">Cod. lata</th>
          <th scope="col">Latas</th>      
          <th scope="col">Lote Producción</th>
          <th scope="col">Máquina</th>
        </tr>
      </thead>
      <tbody>
    <?php
    foreach($result as $row)
        {
    ?>
        <tr>
          <td><input type="checkbox" class="form-check-input" id="<?php echo $row['ticket']; ?>" name="checkboxAsignar" onchange="getSeleccion(this.id)" checked="1"></td>       
          <td><?php echo $row['egreso']; ?></td>
          <td><?php echo $row['OP']; ?></td>          
          <td><?php echo $row['OF_PT']; ?></td>
          <td><?php echo $row['ticket']; ?></td>
          <td><?php echo $row['Producto']; ?></td>
          <td><?php echo $row['PesoNeto']; ?></td> 
          <td><?php echo $row['nombreMarca']; ?></td>
          <td><?php echo $row['CodigoLata']; ?></td>
          <td><?php echo $row['latas']; ?></td>       
          <td><?php echo $row['Lote']; ?></td>
          <td><?php echo $row['CnoMaquina']; ?></td>  
        </tr>
    <?php
        }
    ?>
      </tbody>
    </table>
  </div>
</div>

   <div class="form-group">
    <label for="CocheExcluidos">Tickets Excluidos</label>
      <input type="text" class="form-control" name="CocheExcluidos" id="CocheExcluidos" readonly>
  </div>

<?php
$script = <<< JS

$("#GuardarCoches" ).click(function() {


  var fechaEncartonado = $('#fechaEncartonado').val();
  var turnoEncartonado = $('#turnoEncartonado').val();
  var CocheExcluidos = $('#CocheExcluidos').val();
  var idMaquina = $('#idMaquina').val();
  var proceso = $('#proceso').val();


  var allCochesDatos = {'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado,'CocheExcluidos':CocheExcluidos,'idMaquina':idMaquina,'proceso':proceso};

var r = confirm("Desear regresar los tickets, para volver a asignar?");
if (r == true) {

$.ajax({
        url: 'regresarcoche', 
        type : 'POST',      
        datatype : 'json',
        data : allCochesDatos,       
        success: function(data) {                       
            $("#CochesAsignados" ).html(data);
            }
        });  
}

});


JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">
  
if (<?php echo count($result) ?> <= 0) {
  $("#CochesAsignados").hide();
}else{
  $("#CochesAsignados").show();
}
</script>