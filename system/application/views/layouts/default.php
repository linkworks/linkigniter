<!DOCTYPE HTML>
<html>
<head>
  <title>LinkIgniter <?php echo $this->layouts->title_for_layout; ?></title>
  
  <!-- Inline Javascript -->
  <script type="text/javascript">
  /**
   * This has to be on the layout to be able to print the base_url() and index_page()
   */
  var BASE_URL = '<?php echo base_url() ?>';
  var INDEX = '<?php echo index_page() ?>';
  var METHOD_URL = BASE_URL + ((INDEX != '') ? (INDEX + '/') : '');
  </script>
  <!-- End Inline Javascript -->
  
  <!-- Javascript Includes -->
  <?php echo $this->layouts->print_js_includes(array(JQUERY_CORE, LINKIGNITER_UTILS, JQUERY_TIPTIP, LINKIGNITER_CONSOLE_JS)); ?>
  <!-- End Javascript Includes -->
  
  <!-- Flash Alerts -->
  <script type="text/javascript">
  // Any alerts?
  $('document').ready(function(){
    <?php 
    if (($message = $this->session->flashdata('message')) && ($type = $this->session->flashdata('type')))
    {
      echo $type . '_msg("' . $message . '");';
    }
    ?>
  });
  </script>
  
  <!-- CSS Includes -->
  <?php echo $this->layouts->print_css_includes(array(CSS_RESET, FANCY_BUTTONS, CSS_TIPTIP, CSS_ALERTS, LINKIGNITER_CONSOLE_CSS, 'css/style')); ?>
  <!-- End CSS Includes -->
</head>
<body>
  <!-- Alerts, Messages & Errors -->
  <div id="error-bar">
    <span class="the-message">Error Gen&eacute;rico</span>
    <span class="close">&times;</span>
  </div>
  <div id="message-bar">
    <span class="the-message">Mensaje Gen&eacute;rico</span>
    <span class="close">&times;</span>
  </div>
  <div id="alert-bar">
    <span class="the-message">Alerta Gen&eacute;rica</span>
    <span class="close">&times;</span>
  </div>
  <!-- End Alerts, Messages & Errors -->
  
  <!-- Linkigniter Console -->
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
  <!-- End Linkigniter Console -->
  
  <div id="container">
    <?php echo $this->layouts->content_for_layout; ?>
  </div>
</body>
</html>