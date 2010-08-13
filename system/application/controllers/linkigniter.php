<?php
require(APPPATH . '/libraries/Inflector.php');

class LinkIgniter extends MY_Controller {
  public function index($ok = NULL, $tables_cooked = NULL, $zip = NULL)
  {
    $tables = Doctrine_Manager::connection()->import->listTables();
    $this->load->view('linkigniter/cpanel', array('ok' => $ok, 'tables_cooked' => $tables_cooked, 'tables' => $tables, 'zip' => $zip));
  }
  
  // ----------------------------------------------------------------------
  
	public function create_tables() 
	{
		Doctrine::createTablesFromModels();
		redirect('linkigniter/index/tables');
	}
	
	// ----------------------------------------------------------------------
  
	public function delete_tables() 
	{
		$tables = Doctrine_Manager::connection()->import->listTables();
		
		Doctrine_Manager::connection()->execute(
			'SET FOREIGN_KEY_CHECKS = 0');
		
		foreach ($tables as $table)
		{
		  Doctrine_Manager::connection()->export->dropTable($table);
		}
		
		redirect('linkigniter/index/deltables');
	}
	
	// ----------------------------------------------------------------------
	
	public function load_fixtures() 
	{
	  return;
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
	 * Not the DRYest approach, but works.
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
	  $views_path = APPPATH . '/views/';
	  $js_path = DATATABLES_LOADERS_FOLDER . '/';
	  
	  // Fetch table list from models and create controllers + views for each
	  $tables = Doctrine_Manager::connection()->import->listTables();
	  $tables_cooked = 0;
	  
	  $cookable_tables = $this->input->post('tables');
	  $cookable_tables = empty($cookable_tables) ? array() : $cookable_tables;
	  
	  // Save backup
	  $zip_file = $this->backup();
	  
	  foreach ($tables as $table)
	  {
	    if ( ! in_array($table, $cookable_tables))
	    {
	      continue;
	    }
	    
	    // Create the controller
	    $controller_data = array(
	      'generation_date'             => date('Y-m-d H:i:s'),
	      'controller_name'             => ucfirst($table),  // eg. Users or Users_groups
	      'records'                     => $table,           // eg. users
	      'record_name'                 => Inflector::singularize($table), // eg. user  
	      'model_name'                  => ucfirst(Inflector::singularize($table)), // eg. user
	      'lowercase_controller_name'   => $table,           // eg. users
	      'views_folder_name'           => $table,           // eg. users
	      'validation_rules'            => array(),          // To be filled later
	      'validation_rules_for_update' => array(),          // To be filled later
	      'field_listing'               => array(),          // To be filled later
	      'field_listing_for_update'    => array()           // To be filled later
	    );
	    
	    // Validation rules & field listing
	    $table_fields = Doctrine_Manager::connection()->import->listTableColumns($table);
	    foreach ($table_fields as $field)
	    {
        // If the field is primary AND autoincremental, hide it from
        // all forms
	      if ($field['primary'] && $field['autoincrement'])
	      {
	        continue;
	      }
	      elseif ( ! $field['primary'])
	      {
	        // This allows to NOT show a primary field in the update form
  	      $controller_data['field_listing_for_update'][]['name'] = $field['name'];
	      }
	      
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
	        $rules[] = 'strip_tags'; // Strips HTML from input
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
	      
	      if ( ! $field['primary'])
	      {
	        // This allows to NOT validate a primary field in 
	        // the update form (which wouldn't be shown anyway)
	        $controller_data['validation_rules_for_update'][] = $validation_rules;
	      }
	    } // foreach ($table_fields as $field)
      
      // Create it.
      write_file(
        $controllers_path . $table . '.php', 
        "<?php\n" . $this->parser->parse('linkigniter/baker_templates/controller', $controller_data, TRUE)
      );
      
      // Now for the views!
      //
      // The 'all' view
      //
      $all_view_data = array(
        'title' => $table,
        'headers' => array(),
        'footers' => array(),
        'fields' => array(),
        'records' => $table,
        'record_name' => Inflector::singularize($table),
        'controller' => $table,
        'table_id' => $table . '_datatable'
      );
      
      foreach($table_fields as $field)
      {
        $all_view_data['headers'][] = array('name' => Inflector::humanize($field['name']));
        $all_view_data['fields'][] = array('name' => $field['name']);
        $all_view_data['footers'][] = array('search_name' => $field['name'], 'friendly_name' => Inflector::humanize($field['name']));
      }
      
      // Create controller's views directory & the all.php view itself
      if ( ! file_exists($views_path . '/' . $table)) 
      {
        mkdir($views_path . '/' . $table);
      }
      
      write_file(
        $views_path . '/' . $table . '/' . $table . '_all.php', 
        $this->parser->parse('linkigniter/baker_templates/all', $all_view_data, TRUE)
      );
      
      // Also create the datatables trigger javascript file
      $datatables_trigger = array('table_id' => $table . '_datatable');
            
      write_file(
        $js_path . 'datatables_' . $table . '.js', 
        $this->parser->parse('linkigniter/baker_templates/datatables_loader.js', $datatables_trigger, TRUE)
      );
      
      //
      // The 'create' view
      //
      $create_view_data = array(
        'title' => Inflector::singularize($table),
        'controller' => $table,
        'fields' => array()
      );
      
      foreach ($table_fields as $field)
      {
        $temp = array(
          'name' => $field['name'],
          'friendly_name' => Inflector::humanize($field['name'])
        );
        
        // Field Type
        if ($field['name'] == 'password')
        {
          $temp['type'] = 'password';
        }
        else
        {
          $temp['type'] = 'input';
        }
        
        $create_view_data['fields'][] = $temp;
      }
      
      write_file(
        $views_path . '/' . $table . '/' . $table . '_create.php', 
        $this->parser->parse('linkigniter/baker_templates/create', $create_view_data, TRUE)
      );
      
      //
      // The update view
      //
      $update_view_data = array(
        'title' => Inflector::singularize($table),
        'controller' => $table,
        'fields' => array(),
        'record_name' => Inflector::singularize($table)
      );
      
      foreach ($table_fields as $field)
      {
        $temp = array(
          'name' => $field['name'],
          'friendly_name' => Inflector::humanize($field['name'])
        );
        
        // Field Type
        if ($field['name'] == 'password')
        {
          $temp['type'] = 'password';
        }
        else
        {
          $temp['type'] = 'input';
        }
        
        $update_view_data['fields'][] = $temp;
      }
      
      write_file(
        $views_path . '/' . $table . '/' . $table . '_update.php', 
        $this->parser->parse('linkigniter/baker_templates/update', $update_view_data, TRUE)
      );
      
      // 
      // Read view
      //
      $read_view_data = array(
        'title' => Inflector::singularize($table),
        'controller' => $table,
        'fields' => array(),
        'record_name' => Inflector::singularize($table)
      );
      
      foreach ($table_fields as $field)
      {
        $read_view_data['fields'][] = array(
          'name' => $field['name'],
          'friendly_name' => Inflector::humanize($field['name'])
        );
      }
      
      write_file(
        $views_path . '/' . $table . '/' . $table . '_read.php', 
        $this->parser->parse('linkigniter/baker_templates/read', $read_view_data, TRUE)
      );
      
      $tables_cooked++;
	  }
	  
	  redirect('linkigniter/index/bake/' . $tables_cooked . '/' . $zip_file);
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Backs up all folders that could be overwritten
	 *
	 * @return void
	 * @author Ian Murray
	 */
	public function backup()
	{
	  $this->load->library('zip');
	  
	  // Folders to be backed up
	  $folders = array(
	    'system/application/controllers/', 
	    'system/application/views/', 
	    'js/datatables_loaders/'
	  );
	  
	  foreach ($folders as $folder)
	  {
	    $this->zip->read_dir($folder);
	  }
	  
	  // Create backup dir if not exists
	  if ( ! file_exists(APPPATH . '/baker_backups'))
	  {
	    mkdir(APPPATH . '/baker_backups');
	  }
	  
	  // Add readme file
	  $readme = <<<README
This is an automatically generated backup of the following folders.
  system/application/controllers/
  system/application/views/
  js/datatables_loaders
README;
	  
	  $this->zip->add_data('readme.txt', $readme);
	  
	  // Save the backup
	  $zip_name = 'backup_' . date('Ymd_His') . '.zip';
	  $this->zip->archive(APPPATH . '/baker_backups/' . $zip_name);
	  
	  return $zip_name;
	}
}