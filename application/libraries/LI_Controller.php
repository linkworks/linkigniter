<?php
class LI_Controller extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Checks valid date in forms. Does not validate if field is empty.
   *
   * @param string $field 
   * @return void
   * @author Ian Murray
   */
  public function check_valid_datetime($field)
  {
    if ($field == '')
    {
      return TRUE;
    }
    
    if ( ! preg_match('/^[0-9][0-9][0-9][0-9](-[0-1][0-9](-[0-3][0-9]( [0-9][0-9](:[0-9][0-9](:[0-9][0-9])?)?)?)?)?$/', $field))
    {
      $this->form_validation->set_message('check_valid_datetime', 'El campo %s no contiene una fecha v&aacute;lida');
      return FALSE;
    }
    
    return TRUE;
  }
}