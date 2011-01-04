<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// This calls all beforeFilters before the action itself is called, but
// after the controller's action is called.
$hook['post_controller_constructor'] = array(
  'class'    => 'Filters',
  'function' => 'call_before_filters',
  'filename' => 'filters.php',
  'filepath' => 'hooks'
);

// This calls all afterFilters after the action has been executed.
$hook['post_controller'] = array(
  'class'    => 'Filters',
  'function' => 'call_after_filters',
  'filename' => 'filters.php',
  'filepath' => 'hooks'
);

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */