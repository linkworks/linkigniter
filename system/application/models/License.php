<?php
class License extends Doctrine_Record 
{
  /**
   * Table structure
   *
   * @return void
   * @author Ian Murray
   */
  public function setTableDefinition()
  {
    $this->hasColumn('id', 'integer', null, array('primary' => TRUE, 'autoincrement' => TRUE));
    $this->hasColumn('server_address', 'string', 15);
    
    // When was the last time we received a call?
    $this->hasColumn('last_call_home', 'timestamp', null, array('notnull' => FALSE));
    
    // This should be unique. It's the permanent licence key
    $this->hasColumn('license_key', 'string', 255, array('unique' => TRUE, 'notnull' => FALSE));
    
    // This is used to perform an installation.
    $this->hasColumn('install_key', 'string', 255, array('unique' => TRUE, 'notnull' => FALSE));
    
    // Is the license active? If not, the next time we receive a call home, deactivate the script.
    $this->hasColumn('active', 'boolean');
  }
  
  /**
   * Set table options
   *
   * @return void
   * @author Ian Murray
   */
  public function setUp()
  {
    $this->setTableName('licenses');
  }
}