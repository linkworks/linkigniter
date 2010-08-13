<h1>Vista detalle de {title} #<?php /* Careful with this */ echo "<?php echo \${record_name}->id ?>" ?></h1>

{fields}
<p><span class="field-name">{friendly_name}:</span> <?php /* Careful with this */ echo "<?php echo \${record_name}->{name} ?>" ?></p>
{/fields}

<?php
echo <<<HTML
  <?php echo anchor('{controller}/update/' . \${record_name}->id, 'Editar', array('class' => 'btn btn-left btn-main')) ?>
  <?php echo anchor('{controller}/delete/' . \${record_name}->id, 'Borrar', array('class' => 'btn btn-right', 'onclick' => 'if ( ! confirm(\'Está seguro de querer elimninar este registro?\')) return false;')) ?>
HTML;

?>