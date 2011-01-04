<h1>Lista de {title}</h1>

<?php echo "<?php echo anchor('{controller}/create', 'Nuevo registro', array('class' => 'btn btn-main')); ?>"; ?>

<table id="{table_id}" class="display">
  <thead>
    <tr>
      {headers}
      <th>{name}</th>
      {/headers}
      <th>Opciones</th>
    </tr>
  </thead>
  
  <tfoot>
    <tr>
      {footers}
      <th><input type="text" name="{search_name}" value="Buscar en {friendly_name}" class="search_init"></th>
      {/footers}
      <th>&nbsp;</th>
    </tr>
  </tfoot>
  
  <tbody>
    <?php /* Careful with this */ echo "<?php foreach (\${records} as \${record_name}): ?>" ?>
    <tr>
      {fields}
      <td><?php /* Careful with this */ echo "<?php echo \${record_name}->{name} ?>" ?></td>
      {/fields}
      <td>
        <?php /* The 'view' button */ echo "<?php echo add_link_icon('{controller}/read/' . \${record_name}->id, 'Ver', 'read.png'); ?>"; ?>
        
        <?php /* The 'edit' button */echo "<?php echo add_link_icon('{controller}/update/' . \${record_name}->id, 'Editar', 'edit.png'); ?>"; ?>
        
        <?php /* The 'delete' button */echo "<?php echo add_link_icon('{controller}/delete/' . \${record_name}->id, 'Eliminar', 'delete.png', 'if ( ! confirm(\'Está seguro de querer eliminar este registro?\')) return false;'); ?>"; ?>  
      </td>
    </tr>
    <?php /* Careful with this */ echo "<?php endforeach; ?>" ?>
    
  </tbody>
</table>