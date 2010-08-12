<?php
/**
 * Generic CRUD controller for the License model.
 * Auto-generated with LinkIgniter's Bake (2010-08-12 00:56:11).
 * 
 * @author Ian Murray
 */
class Licenses extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Lists all licenses
   *
   * @return void
   * @author Ian Murray
   */
  public function all()
  {
    // Page title
    $this->layouts->set_title('Licenses - List all licenses');
    
    $licenses = Doctrine::getTable('License')->findAll();
    
    $this->layouts->load('licenses/licenses_all', array($licenses));
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Creates a license
   *
   * @return void
   * @author Ian Murray
   */
  public function create()
  {
    // Page title
    $this->layouts->set_title('Licenses - Create license');
    
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules(array(
      
      array(
        'field' => 'id',
        'label' => 'id',
        'rules' => 'required|numeric'
      ),
      
      array(
        'field' => 'server_address',
        'label' => 'server_address',
        'rules' => 'required|max_length[15]|trim'
      ),
      
      array(
        'field' => 'last_call_home',
        'label' => 'last_call_home',
        'rules' => 'callback_check_valid_datetime'
      ),
      
      array(
        'field' => 'license_key',
        'label' => 'license_key',
        'rules' => 'max_length[255]|trim'
      ),
      
      array(
        'field' => 'install_key',
        'label' => 'install_key',
        'rules' => 'max_length[255]|trim'
      ),
      
      array(
        'field' => 'active',
        'label' => 'active',
        'rules' => 'required'
      ),
      
    ));
    
    if ($this->form_validation->run() === FALSE)
    {
      // Form failed or hasn't been submited
      $this->layotus->view('licenses/licenses_create');
    }
    else
    {
      // Create the record
      $license = new License();
      
      $license->id = $this->input->post('id');
      
      $license->server_address = $this->input->post('server_address');
      
      $license->last_call_home = $this->input->post('last_call_home');
      
      $license->license_key = $this->input->post('license_key');
      
      $license->install_key = $this->input->post('install_key');
      
      $license->active = $this->input->post('active');
      
      
      if ($license->trySave())
      {
        $this->layouts->flash_redirect(
          'Registro creado exitosamente.', 
          'licenses/read/' . $license->id, 
          FLASH_MESSAGE
        );
      }
      else
      {
        $this->layouts->flash_redirect(
          'Ocurrió un error inesperado.', 
          'licenses/all', 
          FLASH_ERROR
        );
      }
    }
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Lists a specific {record}
   *
   * @param string $id 
   * @return void
   * @author Ian Murray
   */
  public function read($id)
  {
    // Page title
    $this->layouts->set_title('Licenses - View license #' . $id);
    
    $license = Doctrine::getTable('License')->findOneById($id);
    
    if ( ! $license)
    {
      // No record exists, so black-hole the petition
      show_404();
      return;
    }
    
    $this->layotus->view('licenses/licenses_read', array('license' => $license));
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Updates a {record}
   *
   * @param string $id 
   * @return void
   * @author Ian Murray
   */
  public function update($id)
  {
    
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Deletes a {record}
   *
   * @param string $id 
   * @return void
   * @author Ian Murray
   */
  public function delete($id)
  {
    
  }
}