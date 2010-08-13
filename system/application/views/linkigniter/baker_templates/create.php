<h1>Crear {title}</h1>

<?php
// Careful with this! Only edit what's in between "<<<HTML" and "HTML;" !!
// This was the only easy way I came up with to print all this php code without
// too many echos.
echo <<<HTML

<?php echo validation_errors(); ?>

<?php // echo form_fieldset(); ?>
  <?php echo form_open('{controller}/create') ?>
    {fields}
    <?php echo form_label('{friendly_name}', '{name}')?>
    <?php echo form_{type}(array(
      'name'      => '{name}',
      'id'        => '{name}',
      'value'     => set_value('{name}') // To re-set values if form submission fails due to 
                                         // form validation in the controller.
    )) ?>
    {/fields}
    
    <?php echo form_submit(array(
      'id' => 'submit',
      'name' => 'submit',
      'class' => 'btn btn-main',
      'value' => 'Enviar'
    )) ?>
  <?php echo form_close() ?>
<?php // echo form_fieldset_close(); ?>

HTML;
?>