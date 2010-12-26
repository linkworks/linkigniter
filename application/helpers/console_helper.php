<?php
if ( ! function_exists('log_console') )
{
  function log_console($text, $function = NULL)
  {
    $CI =& get_instance();
    
    if ($function == 'print_r')
    {
      ob_start();
      
      print_r($text);
      $text = '[' . date('Y-m-d H:i:s') . '] <br><pre>' . ob_get_contents() . '</pre>';
      
      ob_end_clean();
    }
    elseif ($function == 'var_dump')
    {      
      ob_start();

      var_dump($text);
      $text = '[' . date('Y-m-d H:i:s') . '] <br><pre>' . ob_get_contents() . '</pre>';

      ob_end_clean();
    }
    else
    {
      $text = '[' . date('Y-m-d H:i:s') . '] ' . $text;
    }
    
    // This will be catched by the layout and be shown.
    if ( ! isset($CI->layouts->data['console_output']))
    {
      $CI->layouts->data['console_output'] = $text;
    }
    else
    {
      $CI->layouts->data['console_output'] .= '<br>' . $text;
    }
  }
}