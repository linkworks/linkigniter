<?php
require(APPPATH . '/libraries/Inflector.php');

class LinkIgniter extends MY_Controller {
  private function _forms($tables = FALSE, $fixtures = FALSE)
  {
    $forms = 'Reminder: Make sure the tables do not exist already.
    <form action="' . site_url('linkigniter/create_tables') . '" method="POST">
		<input type="submit" name="action" value="Create Tables"></form><br /><br />';
		
		$forms .= ($tables) ? 'Done Tables!<br /><br />' : '';
		
		$forms .= 'This will delete all existing data!
		<form action="' . site_url('linkigniter/load_fixtures') . '" method="POST">
		<input type="submit" name="action" value="Load Fixtures"></form><br /><br />';
		
		$forms .= ($fixtures) ? 'Done Fixtures!' : '';
		
		return $forms;
  }
  
  // ----------------------------------------------------------------------
  
  public function index($ok = NULL)
  {
    echo $this->_forms(($ok == 'tables') ? TRUE : FALSE, ($ok == 'fixtures') ? TRUE : FALSE);
  }
  
  // ----------------------------------------------------------------------
  
	public function create_tables() 
	{
		if ($this->input->post('action')) 
		{
			Doctrine::createTablesFromModels();
			redirect('linkigniter/index/tables');
		}
	}
	
	// ----------------------------------------------------------------------
	
	public function load_fixtures() 
	{
		if ($this->input->post('action')) 
		{
			Doctrine_Manager::connection()->execute(
				'SET FOREIGN_KEY_CHECKS = 0');

			Doctrine::loadData(APPPATH.'/fixtures');
			redirect('linkigniter/index/fixtures');
		}
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Creates controllers and views for each table in the model.
	 *
	 * @return void
	 * @author Ian Murray
	 */
	public function bake()
	{
	  $this->load->helper('file');
	  //$this->load->helper('inflector');
	  $this->load->library('parser'); // To parse the templates
	  
	  $controllers_path = APPPATH . '/controllers/';
	  
	  // Fetch table list from models and create controllers + views for each
	  $tables = Doctrine_Manager::connection()->import->listTables();
	  foreach ($tables as $table)
	  {
	    echo "# Cooking " . $table . "<br>";
	    // Create the controller
	    $controller_data = array(
	      'generation_date'           => date('Y-m-d H:i:s'),
	      'controller_name'           => ucfirst($table),  // eg. Users or Users_groups
	      'records'                   => $table,           // eg. users
	      'record_name'               => Inflector::singularize($table), // eg. user  
	      'model_name'                => ucfirst(Inflector::singularize($table)), // eg. user
	      'lowercase_controller_name' => $table,           // eg. users
	      'views_folder_name'         => $table,           // eg. users
	      'validation_rules'          => array(),          // To be filled later
	      'field_listing'             => array()           // To be filled later
	    );
	    
	    // Validation rules & field listing
	    $table_fields = Doctrine_Manager::connection()->import->listTableColumns($table);
	    foreach ($table_fields as $field)
	    {
	      $controller_data['field_listing'][]['name'] = $field['name'];
	      $validation_rules = array('name' => $field['name']);
	      
	      // Add rules depending on the field data
	      $rules = array();

        // Nullable?
        if ($field['notnull'])
        {
          // Since it's not nullable, make it obligatory
          $rules[] = 'required';
        }
	      
	      // Handle numeric types
	      if ($field['type'] == 'integer' && ! in_array('boolean', $field['alltypes'])) 
	      { 
	        $rules[] = 'numeric'; 
	      }
	      
	      if ($field['type'] == 'string') 
	      { 
	        $rules[] = 'max_length[' . $field['length'] . ']'; 
	        $rules[] = 'trim';
	      }
	      
	      // Email?
	      if ($field['name'] == 'email')
	      {
	        $rules[] = 'valid_email';
	      }
	      
	      // Date/DateTime?
	      if ($field['type'] == 'timestamp')
	      {
	        $rules[] = 'callback_check_valid_datetime'; // Callback defined in MY_Controller
	      }
	      
	      $validation_rules['rules'] = implode('|', $rules);
	      $controller_data['validation_rules'][] = $validation_rules;
	    } // foreach ($table_fields as $field)
      
      // Create it.
      write_file(
        $controllers_path . $table . '.php', 
        "<?php\n" . $this->parser->parse('linkigniter/baker_templates/controller', $controller_data, TRUE)
      );
	  }
	}
}