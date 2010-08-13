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
  <?php echo $this->layouts->print_js_includes(array(JQUERY_CORE, LINKIGNITER_UTILS, JQUERY_TIPTIP)); ?>
  <!-- End Javascript Includes -->
  
  <!-- CSS Includes -->
  <?php echo $this->layouts->print_css_includes(array(CSS_RESET, FANCY_BUTTONS, CSS_TIPTIP, CSS_ALERTS)); ?>
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
  
  <div id="container">
    <?php echo $this->layouts->content_for_layout; ?>
  </div>
</body>
</html>