<?php
/**
 * TEST MODEL!
 *
 * @package default
 * @author Ian Murray
 */
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
    $this->hasColumn('id', 'integer', null, array('primary' => TRUE, 'autoincrement' => FALSE));
    $this->hasColumn('email', 'string', 50);
    
    $this->hasColumn('password', 'string', 50);
    
    // When was the last time we received a call?
    $this->hasColumn('last_call_home', 'timestamp', null, array('notnull' => FALSE));
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