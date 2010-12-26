<?php
/**
 * This is the bootstraping file for the doctrine CLI.
 *
 * Execute it using the "doctrine" shell script in this same
 * directory.
 *
 * @author Ian Murray
 */
require_once('plugins/doctrine_pi.php');

// Configure Doctrine Cli
// Normally these are arguments to the cli tasks but if they are set here the arguments will be auto-filled
$config = array('data_fixtures_path'  =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '/fixtures',
                'models_path'         =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '/models',
                'migrations_path'     =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '/migrations',
                'sql_path'            =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '/sql',
                'yaml_schema_path'    =>  dirname(__FILE__) . DIRECTORY_SEPARATOR . '/schema',
                );

$config['generate_models_options'] = array(
  // Define the PHPDoc Block in the generated classes
  'phpDocPackage'         =>'LinkIgniter',
  'phpDocSubpackage'      =>'Models',
  'phpDocName'            =>'YOUR_NAME_HERE',
  'phpDocEmail'           =>'YOUR@NAME.HERE',
  //'phpDocVersion'         =>'1.0',
  
  // Define whats what and named how, where.
  'suffix'                => '.php',
  'pearStyle'             => TRUE,
  'baseClassPrefix'       => 'Base_',
  
  // Unless you have created a custom class or want Default_Model_Base_Abstract
  'baseClassName'         => 'Doctrine_Record',
  
  // Leave this empty as specifying 'Base' will create Base/Base
  'baseClassesDirectory'  => NULL,
  
  // Should make it Zend Framework friendly AFAIK
  //'classPrefix'           => 'Dagho_Model_',
  'classPrefixFiles'      => FALSE,
  'generateBaseClasses'   => TRUE,
  'generateTableClasses'  => TRUE,
  //'packagesPath'          => APPLICATION_PATH . '/models',
  //'packagesFolderName'    => 'packages',
);

$cli = new Doctrine_Cli($config);
$cli->run($_SERVER['argv']);