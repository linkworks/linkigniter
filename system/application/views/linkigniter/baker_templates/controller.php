/**
 * Generic CRUD controller for the {model_name} model.
 * Auto-generated with LinkIgniter's Bake ({generation_date}).
 * 
 * @author Ian Murray
 */
class {controller_name} extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Lists all {records}
   *
   * @return void
   * @author Ian Murray
   */
  public function all()
  {
    // Page title
    $this->layouts->set_title('{controller_name} - List all {records}');
    
    ${records} = Doctrine::getTable('{model_name}')->findAll();
    
    $this->layouts->load('{views_folder_name}/{views_folder_name}_all', array(${records}));
  }
  
  // ----------------------------------------------------------------------
  
  /**
   * Creates a {record_name}
   *
   * @return void
   * @author Ian Murray
   */
  public function create()
  {
    // Page title
    $this->layouts->set_title('{controller_name} - Create {record_name}');
    
    $this->load->library('form_validation');
    
    $this->form_validation->set_rules(array(
      {validation_rules}
      array(
        'field' => '{name}',
        'label' => '{name}',
        'rules' => '{rules}'
      ),
      {/validation_rules}
    ));
    
    if ($this->form_validation->run() === FALSE)
    {
      // Form failed or hasn't been submited
      $this->layotus->view('{views_folder_name}/{views_folder_name}_create');
    }
    else
    {
      // Create the record
      ${record_name} = new {model_name}();
      {field_listing}
      ${record_name}->{name} = $this->input->post('{name}');
      {/field_listing}
      
      if (${record_name}->trySave())
      {
        $this->layouts->flash_redirect(
          'Registro creado exitosamente.', 
          '{lowercase_controller_name}/read/' . ${record_name}->id, 
          FLASH_MESSAGE
        );
      }
      else
      {
        $this->layouts->flash_redirect(
          'Ocurrió un error inesperado.', 
          '{lowercase_controller_name}/all', 
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
    $this->layouts->set_title('{controller_name} - View {record_name} #' . $id);
    
    ${record_name} = Doctrine::getTable('{model_name}')->findOneById($id);
    
    if ( ! ${record_name})
    {
      // No record exists, so black-hole the petition
      show_404();
      return;
    }
    
    $this->layotus->view('{views_folder_name}/{views_folder_name}_read', array('{record_name}' => ${record_name}));
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