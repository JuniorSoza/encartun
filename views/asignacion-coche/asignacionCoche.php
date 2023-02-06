
<input type="hidden" name="parada" id="parada" value="<?php echo $parada; ?>"> 
<input type="text" name="autoClave" id="autoClave"  value="<?php echo $autoClave; ?>" hidden> 
<div class="row">
    <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
      <br>
       <p class="text-center font-weight-bold">Parada:<?php echo $parada; ?> - Autoclave:<?php echo $autoClave; ?></p>
    </div>
 </div>
<div class="allcoches-form" id="allcoches-form">
  <div class=" table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" class="form-check-input" id="checkAll" name="checkAll" onchange="getSeleccionAll()" checked="1"></th>
          <th scope="col">OP</th>
          <th scope="col">OF</th>
          <th scope="col">Producto</th>
          <th scope="col">Peso Neto</th>
          <th scope="col">Marca</th>
          <th scope="col">Cod. lata</th>
          <th scope="col">#Coche</th>
          <th scope="col">Latas</th>      
          <th scope="col">cajas/Latas</th>
          <th scope="col">Máquina</th>
          <th scope="col">Lote Producción</th>
        </tr>
      </thead>
      <tbody>
    <?php

    foreach($result as $row)
        {
          if ($row['estado'] == 0)
          {
            echo "<tr class='danger'>";
          }else
          {
            echo "<tr>";
          }
    ?>
          <td><input type="checkbox" class="form-check-input" id="<?php echo $row['coche']; ?>" name="checkboxAsignar" onchange="getSeleccion(this.id)" checked="1"></td> 
          <td><?php echo $row['ordenProduccion']; ?></td>
          <td><?php echo $row['ordenFabricacion']; ?></td>
          <td><?php echo $row['nombreProducto']; ?></td>
          <td><?php echo $row['pesoNeto']; ?></td>
          <td><?php echo $row['nombreMarca']; ?></td>
          <td><?php echo $row['codigoLata']; ?></td>
          <td><?php echo $row['coche']; ?></td>
          <td><?php echo $row['latas']; ?></td>
          <td><?php echo $row['cajasLatas']; ?></td>
          <td><?php echo $row['maquina']; ?></td>
          <td><?php echo $row['loteProduccion']; ?></td>
        
        </tr>
    <?php

        }
    ?>
      </tbody>
    </table>
  </div>
</div>

   <div class="form-group">
    <label for="CocheExcluidos">Coches Excluidos</label>
      <input type="text" class="form-control" name="CocheExcluidos" id="CocheExcluidos" readonly>
  </div>
