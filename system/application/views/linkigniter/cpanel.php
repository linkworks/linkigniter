<!DOCTYPE HTML>
<html>
<head>
  <title>LinkIgniter Cpanel</title>
  <style type="text/css">
  #container
  {
    margin:0 auto;
    width: 700px;
  }
  
  #container li
  {
    list-style: none;
    float: left;
  }
  
  #container li input.big
  {
    font-size: 25px;
  }
  
  #container li select
  {
    font-size: 18px;
  }
  </style>
  
  <script type="text/javascript">
<?php if ($ok == 'tables'): ?>
  alert('Tables created!');
<?php elseif ($ok == 'deltables'): ?>
  alert('Tables deleted!');
<?php elseif ($ok == 'bake'): ?>
  alert('Baking complete! <?php echo $tables_cooked ?> tables cooked.');
<?php endif; ?>
  </script>
</head>
<body>
  <div id="container">
    <ul>
      <li>
        <!-- Create Tables -->
        <input type="button" class="big" value="Create Tables From Models" onclick="if ( ! confirm('Please make sure you have deleted the old tables first, or this command does not work properly.')) return false; else location.href = '<?php echo site_url('linkigniter/create_tables') ?>';">
      </li>
      <li>
        <!-- Delete Tables -->
        <input type="button" class="big" value="Delete All Tables" onclick="if ( ! confirm('Are you sure?.')) return false; else location.href = '<?php echo site_url('linkigniter/delete_tables') ?>';">
      </li>
      <li>
        <?php echo form_open('linkigniter/bake') ?>
        <select multiple="multiple" name="tables[]">
          <?php foreach ($tables as $table): ?>
          <option value="<?= $table ?>" selected="selected"><?= $table ?></option>
          <?php endforeach; ?>
        </select>
        <?php echo form_submit(array('value' => 'Bake these tables'))?>
        <?php echo form_close(); ?>
      </li>
    </ul>
  </div>
</body>
</html>