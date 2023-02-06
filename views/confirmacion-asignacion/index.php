<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

?>

	<div class="row">
		    <div class='col-xs-12 col-sm-12 col-ls-12 col-md-12'>
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
	</div>
	
      <div class="row">
        <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>  
        <label>Fecha de Encartonado(Confirmación)</label>         
        <?= DatePicker::widget(['name' => 'fechaEncartonado',
                                'options' => ['class' => 'form-control control-encartonado','id' => 'fechaEncartonado'],
                                'attribute' => 'from_date',                                
                                'language' => 'es',
                                'dateFormat' => 'dd-MM-yyyy',
                                'value' => date('d-m-Y'),])?>
        </div>
        <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>
        <label>Turno Encartonado(Confirmación)</label>
         <?php echo Html::dropDownList('turnoEncartonado', 'turnoEncartonado_id', array(
                  '1'=>'Turno 1',
                  '2'=>'Turno 2',),
                array('class'=>'form-control control-encartonado','id' => 'turnoEncartonado')); ?>
        </div>
          <div class='col-xs-12 col-sm-4 col-ls-4 col-md-4 '>
              <label>Proceso</label>
               <?php echo Html::dropDownList('proceso', 'proceso_id', array(
                        'PRODUCCIÓN'=>'PRODUCCIÓN',
                        'SEMIELABORADO'=>'SEMIELABORADO',),
                      array('class'=>'form-control control-encartonado','id' => 'proceso')); ?>
          </div>         
      </div>
<br>  
<div class="row">
	<div class="col-xs-12 col-ls-12 col-sm-6 col-md-4 ">
		<div id="label-coche-ticket"><label>Coche a buscar</label></div>
     	<input type="text" name="cocheTicketBuscar"id="cocheTicketBuscar" class="form-control">
     	<span id="span-cargando-data" style="display: none">Buscando información...</span>
	</div>
</div>
<br>
	<div class="alert alert-success" role="alert" id="resultado-confirmacion" style="display: none">
		<div class="resultado-confirmacion-mensaje">		  
		 </div>
	</div>
<div class="row" style="display: none" id="datos-coche">
	<div class="col-xs-12">
		  <button class="btn btn-primary btn-block" type="button" onclick="confirmarAsignacion(this.value)" id="confirmar-asignacion" >
		    Confirmar asignación
		  </button>
		<div class="table-responsive">
		  <table class="table table-hover">
		  	<thead>
			    <tr>
			      <th scope="col">Objeto</th>
			      <th scope="col">Detalle</th>			      
			    </tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td>Fecha Inicio enfriamiento: </td>
	  				<td><div id="fehaIncioEnfriamiento" class="datos-coche-individuales"></div></td>
	  			</tr>
	  			<tr>
	  				<td>Fecha Fin enfriamiento: </td>
	  				<td><div id="fehaFinEnfriamiento" class="datos-coche-individuales"></div></td>
	  			</tr>
				<tr>
					<td>Máquina asignada: </td>
	  				<td><div id="maquinaAsignada" class="datos-coche-individuales"></div></td>
				</tr>	
				<tr>
					<td>Orden Producción: </td>
	  				<td><div id="op" class="datos-coche-individuales"></div></td>
				</tr>
				<tr>
					<td>Orden Fabricación: </td>
	  				<td><div id="of" class="datos-coche-individuales"></div></td>
				</tr>
	  			<tr>
	  				<td>Lote producción: </td>
	  				<td><div id="loteProduccion" class="datos-coche-individuales"></div></td>	
	  			</tr>
	  			<tr>
	  				<td>Nombre Producto: </td>
	  				<td><div id="nombreProducto" class="datos-coche-individuales"></div></td>
	  			</tr>
				<tr>
					<td>Codigo Lata: </td>
	  				<td><div id="codigoLata" class="datos-coche-individuales"></div></td>
				</tr>
				<tr>
					<td>Cajas Latas: </td>
	  				<td><div id="cajasLatas" class="datos-coche-individuales"></div></td>
				</tr>
				<tr>
					<td>Cantidad Latas: </td>
	  				<td><div id="cantidadLatas" class="datos-coche-individuales"></div></td>
				</tr>				
				<tr>
					<td>Nombre Marca: </td>
	  				<td><div id="nombreMarca" class="datos-coche-individuales"></div></td>
				</tr>
				<tr>
					<td>Número Coche: </td>
	  				<td><div id="coche" class="datos-coche-individuales"></div></td>
				</tr>				
				<tr>
					<td>AutoClave: </td>
	  				<td><div id="autoClave" class="datos-coche-individuales"></div></td>
				</tr>	
				<tr>
					<td>Parada: </td>
	  				<td><div id="parada" class="datos-coche-individuales"></div></td>
				</tr>							
				<tr>
					<td>Peso Neto: </td>
	  				<td><div id="pesoNeto" class="datos-coche-individuales"></div></td>
				</tr>				
	  		</tbody>
		  </table>
		</div>
	</div>
</div> 


<?php
$script = <<< JS

$('#proceso').change(function (){
	$( "#cocheTicketBuscar" ).val('');
	$('#datos-coche').hide()
	
	if($('#proceso').val() == "SEMIELABORADO"){
		$("#label-coche-ticket").html('<label>Ticket a buscar</label>')
	}else
	{
		$("#label-coche-ticket").html('<label>Coche a buscar</label>')
	}
	
});

$( "#cocheTicketBuscar" ).keyup(function(event) {
	var idMaquina = $("#comboBox-maquinas").val();

	if (idMaquina == 0){
		alert('Debe seleccionar una máquina');
	}else{
		 buscarCochesTicket("ª");
	} 
});


$( ".control-encartonado" ).change(function(event) {
	var idMaquina = $("#comboBox-maquinas").val();

	if (idMaquina == 0){
		alert('Debe seleccionar una máquina');
	}else{
		 buscarCochesTicket("ª");
	} 
});
JS;
$this->REGISTERJS($script);
?>


<script type="text/javascript">
	
	function buscarCochesTicket(value){
		if (value == "ª") {
		var cocheTicketBuscar = $("#cocheTicketBuscar").val();
		}else{
		var cocheTicketBuscar = value;	
		}

		var maquina = $("#maquina").val();
		var proceso = $("#proceso").val();
		var fechaEncartonado = $("#fechaEncartonado").val();
		var turnoEncartonado = $("#turnoEncartonado").val();

        $.ajax({
        url: 'buscarcoches', 
        type : 'POST',
        datatype : 'json',       
        data : {'cocheTicketBuscar':cocheTicketBuscar,'proceso':proceso,'maquina':maquina,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado},
        beforeSend: function() {   
			$("#span-cargando-data").show();
		}, 
        success: function(data) { 
        	$("#span-cargando-data").hide();
			var obj = jQuery.parseJSON(data);

				if (obj.length > 0){
                $.each(obj, function(key, value){                	
                	$("#fehaIncioEnfriamiento") .html(value.inicioEnfriamiento); 
                	$("#fehaFinEnfriamiento") .html(value.finEnfriamiento);  
                	$("#maquinaAsignada") .html(value.cnoMaquina); 
                	$("#op") .html(value.ordenProduccion); 
                	$("#of") .html(value.ordenFabricacion); 
                	$("#loteProduccion") .html(value.loteProduccion); 
                	$("#nombreProducto") .html(value.nombreProducto); 
                	$("#codigoLata") .html(value.codigoLata); 
                	$("#cantidadLatas") .html(value.latas);
                	$("#cajasLatas") .html(value.cajasLatas); 
                	$("#nombreMarca") .html(value.nombreMarca); 
                	$("#pesoNeto") .html(value.pesoNeto); 
                	$("#autoClave") .html(value.autoClave);
                	$("#parada") .html(value.parada);
                	$("#coche") .html(value.coche);
                	$("#confirmar-asignacion").val(value.idAutoclave);
                });
                $('#datos-coche').show();
				}else{
					$(".datos-coche-individuales") .html(""); 
                	$('#datos-coche').hide();
				}            
        },error: function(){
        	$("#span-cargando-data").hide();
			$(".datos-coche-individuales") .html(""); 
            $('#datos-coche').hide();        	
        }
        }); 
	}

	function confirmarAsignacion(valor){		
		var fechaEncartonado = $("#fechaEncartonado").val();
		var turnoEncartonado = $("#turnoEncartonado").val();
		var proceso = $("#proceso").val();
		var r = confirm("Desea confirmar la asignación?");

		if (r == true) {

			$.ajax({
		        url: 'validamateriales', 
		        type : 'POST',
		        datatype : 'json',       
		        data : {'proceso':proceso,'valor':valor},     
		        success: function(data) { 
		        		var obj = jQuery.parseJSON(data);
		        		$.each(obj, function(i, item) { 
							
							$(".resultado-confirmacion-mensaje").html(item.MENSAJE);
							if (item.ESTADO == 1) {
								console.log(proceso);
								$.ajax({
							        url: 'confirmarasignacion', 
							        type : 'POST',
							        datatype : 'json',       
							        data : {'proceso':proceso,'valor':valor,'fechaEncartonado':fechaEncartonado,'turnoEncartonado':turnoEncartonado},     
							        success: function(data) { 
							       		if (data ==1) {
											$("#resultado-confirmacion").removeClass("alert-danger");
											$("#resultado-confirmacion").addClass("alert-success");
							       			buscarCochesTicket("ª");
							       		}else{
							       			alert("Hubo un error en el proceso vuelve a intentarlo");
							       		}
							        }
							    });
							}else{
								$("#resultado-confirmacion").addClass("alert-danger");
								$("#resultado-confirmacion").removeClass("alert-success");
							}
		        		});
		        		
						$("#resultado-confirmacion").fadeIn(1);
						$("#resultado-confirmacion").fadeOut(10000);
        	
		        }
		    });			
		}
	}


</script>