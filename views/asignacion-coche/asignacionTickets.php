
<div class="row">
    <div class='col-sm-12 col-ls-12 col-md-12 col-xs-12'>
      <br>
       <p class="text-center font-weight-bold">Ticket: <?php echo $ticket; ?></p>
    </div>
 </div>
<div class="allcoches-form" id="allcoches-form">
  <div class=" table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Asignar</th>
          <th scope="col">OP</th>
          <th scope="col">OF</th>
          <th scope="col">Producto</th>
          <th scope="col">Peso Neto</th>
          <th scope="col">Marca</th>
          <th scope="col">Cod. lata</th>
          <th scope="col">Formato</th>
          <th scope="col">Latas</th>      
          <th scope="col">cajas/Latas</th>
          <th scope="col">Lote Producción</th>
        </tr>
      </thead>
      <tbody>
    <?php

    foreach($result as $row)
        {
    ?>
          <td><input type="checkbox" class="form-check-input" id="<?php echo $row['Ticket']; ?>" name="checkboxAsignar" onchange="getSeleccion(this.id)" checked="1"></td> 
          <td><?php echo $row['OP']; ?></td>
          <td><?php echo $row['OF_PT']; ?></td>
          <td><?php echo $row['Producto']; ?></td>  
          <td><?php echo $row['PesoNeto']; ?></td>
          <td><?php echo $row['cnoMarca']; ?></td>
          <td><?php echo $row['CodigoLata']; ?></td>
          <td><?php echo $row['OF_PT']; ?></td>          
          <td><?php echo $row['Stock']; ?></td>
          <td><?php echo $row['OF_PT']; ?></td>
          <td><?php echo $row['Lote']; ?></td>       
        </tr>
    <?php

        }
    ?>
      </tbody>
    </table>
  </div>
</div>

   <div class="form-group">
    <label for="CocheExcluidos">Ticket Excluidos</label>
      <input type="text" class="form-control" name="CocheExcluidos" id="CocheExcluidos" readonly>
  </div>
