<!DOCTYPE HTML>
<html>
<head>
  <title>LinkIgniter Cpanel</title>
  <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.4.2.min.js"></script>
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
  
  .clear 
  {
    clear: both;
  }
  
  .message
  {
    text-align: center;
    color: green;
    font-size: 16px;
  }
  </style>
  
  <style type="text/css">
  #linkigniter_console
  {
    position: fixed;
    bottom: -345px;
    left: 50%;
    margin-left: -300px;
    width: 600px;
    
    background: #eee;
    line-height: 13px;
    font-size: 13px;
    font-family: Consolas, Menlo, Monaco, 'Lucida Console', 'Liberation Mono', 'DejaVu Sans Mono';
    
    padding: 10px 10px 5px 10px;
    
    -webkit-border-top-left-radius: 10px;
    -webkit-border-top-right-radius: 10px;
    -moz-border-radius-topleft: 10px;
    -moz-border-radius-topright: 10px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    
    -moz-box-shadow: 0px 0px 10px #666; 
    -webkit-box-shadow: 0px 0px 10px #666; 
    box-shadow: 0px 0px 10px #666; 
  }
  
  #linkigniter_command
  {
    font-size: 13px;
    font-family: Consolas, Menlo, Monaco, 'Lucida Console', 'Liberation Mono', 'DejaVu Sans Mono';
    width: 500px;
    
    border: 1px solid #ccc;
  }
  
  #linkigniter_command:focus 
  {
    border: 1px solid #000;
  }
  
  #linkigniter_close
  {
    cursor: pointer;
  }
  
  #linkigniter_loading
  {
    display: none;
    vertical-align: middle;
    padding-top: 5px;
  }
  
  #linkigniter_response
  {
    height: 300px;
    overflow: auto;
  }
  
  #linkigniter_response pre 
  {
    font-size: 13px;
    font-family: Consolas, Menlo, Monaco, 'Lucida Console', 'Liberation Mono', 'DejaVu Sans Mono';
  }
  </style>
  
  <script type="text/javascript">
  $('document').ready(function(){
    var allow_show = true;
    var showing_results = false;
    
    function hide_console() 
    {
      $('#linkigniter_console').animate({'bottom' : '-345px'}, 'fast');
      allow_show = false;
      showing_results = false;
      setTimeout(function(){allow_show = true}, '1000');
    }
    
    function send_command() 
    {
      // Show loading gif
      $('#linkigniter_close').hide();
      $('#linkigniter_loading').show();
      
      $.ajax({
        'url' : '<?php echo site_url('linkigniter/console') ?>',
        'type' : 'post',
        'data' : {
          'command' : $('#linkigniter_command').select().val()
        },
        'success' : function(data){
          $('#linkigniter_response').html('<pre>' + data + '</pre>');
          $('#linkigniter_console').animate({'bottom' : '0px'}, 'fast');
          
          $('#linkigniter_close').show();
          $('#linkigniter_loading').hide();
          
          showing_results = true;
        }
      });
    }
    
    // Show the console on hover
    $('#linkigniter_console, #linkigniter_command').hover(function(){
      if (allow_show && ! showing_results)
      {
        $('#linkigniter_console').animate({'bottom' : '-315px'}, 'fast');
        $('#linkigniter_command').select();
      }
    })
    
    // Hide it on request
    $('#linkigniter_close').click(function(){
      hide_console();
    });
    
    // Catch enter key & esc key
    $('#linkigniter_command').keyup(function(e) {
      if(e.keyCode == 13) 
      {
        send_command();
      }
      else if(e.keyCode == 27)
      {
        hide_console();
      }
    });
  });
  </script>
</head>
<body>
  <div id="linkigniter_console">
    <abbr title="eval() and exec() not allowed. Command must end with semi-colon.">Command</abbr> 
    &gt; 
    <input type="text" name="linkigniter_command" id="linkigniter_command">
    <span title="Hide console" id="linkigniter_close">&darr;</span>
    <span id="linkigniter_loading"><img src="<?php echo base_url() ?>images/linkigniter_console_loader.gif"></span>
    <hr size="1" noshadow="noshadow">
    <div id="linkigniter_response">
      
    </div>
  </div>
  
  <div id="container">
    <?php if ($tables === FALSE): ?>
    Invalid Database Connection!
    <?php else: ?>
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
        <br>
        <?php echo form_submit(array('value' => 'Bake these tables'))?>
        <?php echo form_close(); ?>
      </li>
    </ul>
    <div class="clear"></div>
    <div class="message">
      <?php if ($ok == 'tables'): ?>
        Tables created!
      <?php elseif ($ok == 'deltables'): ?>
        Tables deleted!
      <?php elseif ($ok == 'bake'): ?>
       Baking complete! <?php echo $tables_cooked ?> tables cooked. Backup of controllers views and datatables loaders saved to <?php echo $zip ?>.
      <?php endif; ?>
    </div>
    
    <?php endif; ?>
  </div>
</body>
</html>