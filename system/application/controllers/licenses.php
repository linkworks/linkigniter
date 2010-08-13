<?php
/**
 * Generic CRUD controller for the License model.
 * Auto-generated with LinkIgniter's Bake (2010-08-13 00:17:23).
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
   * "Redirects" to $this->all() internally.
   *
   * @return void
   * @author Ian Murray
   */
  public function index()
  {
    $this->all();
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
    
    $this->layouts->add_js(DATATABLES_CORE)
                  ->add_js(DATATABLES_LOADERS_FOLDER . '/datatables_licenses')
                  ->add_css(CSS_JQUERY_UI)
                  ->add_css(CSS_TIPTIP)
                  ->view('licenses/licenses_all', array('licenses' => $licenses));
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
        'field' => 'email',
        'label' => 'email',
        'rules' => 'required|max_length[50]|strip_tags|trim|valid_email'
      ),
      
      array(
        'field' => 'password',
        'label' => 'password',
        'rules' => 'required|max_length[50]|strip_tags|trim'
      ),
      
      array(
        'field' => 'last_call_home',
        'label' => 'last_call_home',
        'rules' => 'callback_check_valid_datetime'
      ),
      
    ));
    
    if ($this->form_validation->run() === FALSE)
    {
      // Form failed or hasn't been submited
      $this->layouts->view('licenses/licenses_create');
    }
    else
    {
      // Create the license
      $license = new License();
      
      $license->id = $this->input->post('id');
      
      $license->email = $this->input->post('email');
      
      $license->password = $this->input->post('password');
      
      $license->last_call_home = $this->input->post('last_call_home');
      
      
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
   * Lists a specific license
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
    
    $this->layouts->view('licenses/licenses_read', array('license' => $license));
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Updates a license
   *
   * @param string $id 
   * @return void
   * @author Ian Murray
   */
  public function update($id)
  {
    // Page title
    $this->layouts->set_title('Licenses - Update license #' . $id);
    
    // Check the record exists
    if ( ! $license = Doctrine::getTable('License')->findOneById($id))
    {
      // Black-hole the petition
      show_404();
      return;
    }
    
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules(array(
      
      array(
        'field' => 'email',
        'label' => 'email',
        'rules' => 'required|max_length[50]|strip_tags|trim|valid_email'
      ),
      
      array(
        'field' => 'password',
        'label' => 'password',
        'rules' => 'required|max_length[50]|strip_tags|trim'
      ),
      
      array(
        'field' => 'last_call_home',
        'label' => 'last_call_home',
        'rules' => 'callback_check_valid_datetime'
      ),
      
    ));
    
    if ($this->form_validation->run() === FALSE)
    {
      // Form failed or hasn't been submited
      $this->layouts->view('licenses/licenses_update', array('license' => $license));
    }
    else
    {
      // Update the license
      
      $license->email = $this->input->post('email');
      
      $license->password = $this->input->post('password');
      
      $license->last_call_home = $this->input->post('last_call_home');
      
      
      if ($license->trySave())
      {
        $this->layouts->flash_redirect(
          'Registro actualizado exitosamente.', 
          'licenses/read/' . $license->id, 
          FLASH_MESSAGE
        );
      }
      else
      {
        $this->layouts->flash_redirect(
          'Ocurrió un error inesperado.', 
          'licenses/read/' . $license->id, 
          FLASH_ERROR
        );
      }
    }
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Deletes a license. Assumes user already confirmed deletion through
   * javascript.
   *
   * @param string $id 
   * @return void
   * @author Ian Murray
   */
  public function delete($id)
  {
    // Check the record exists
    if ( ! $license = Doctrine::getTable('License')->findOneById($id))
    {
      // Black-hole the petition
      show_404();
      return;
    }
    
    // Delete the license
    if ($license->delete())
    {
      // Success
      $this->layouts->flash_redirect(
        'Registro eliminado exitosamente.', 
        'licenses/all', 
        FLASH_MESSAGE
      );
    }
    else
    {
      // Error
      $this->layouts->flash_redirect(
        'Ocurrió un error inesperado.', 
        'licenses/all', 
        FLASH_ERROR
      );
    }
  }
}