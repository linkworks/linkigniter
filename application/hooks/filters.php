<?php
/**
* Filters Class. This allows for rails-like (or cake-like) action
* filters, so that specific actions can be executed before and after
* an action is called on a controller.
*
* Inspired by http://codeigniter.com/forums/viewthread/76228/
*
* @author Ian Murray
*/
class Filters
{
  /**
   * Holds the CodeIgniter instance.
   *
   * @var string
   */
  private $CI;
  
  // -----------------------------------------------------------------------------------
  
  /**
   * Class Constructor
   *
   * @author Ian Murray
   */
  function __construct()
  {
    $this->CI =& get_instance();
  }
  
  // -----------------------------------------------------------------------------------
  
  private function __call_filters($filters)
  {
    foreach ($filters as $filter => $options)
    {
      // Check if only the filter was specified or not
      if (is_numeric($filter))
      {
        // Only the filter was specified
        $filter = $options;
        $options = array();
      }
      
      // Validate options
      if (in_array('only', array_keys($options)) && in_array('except', array_keys($options)))
      {
        show_error('Cannot specify "only" and "except" on the same filter (' . $filter . ').');
      }
      
      $only = isset($options['only']) ? $options['only'] : NULL;
      $except = isset($options['except']) ? $options['except'] : NULL;
      
      // Check if we can call the filter and do so if possible
      if ( ($only && in_array($this->CI->router->fetch_method(), $only)) 
           || ($except && ! in_array($this->CI->router->fetch_method(), $except)))
      {
        // Can do! Does the filter exist?
        if (method_exists($this->CI, $filter))
        {
          // Call it
          call_user_func(array($this->CI, $filter));
        }
        else
        {
          show_error('Filter method ' . $filter . ' not defined.');
        }
      }
    }
  }
  
  // -----------------------------------------------------------------------------------
  
  public function call_before_filters()
  {
    if (isset($this->CI->beforeFilters)) 
    {
      $this->__call_filters($this->CI->beforeFilters);
    }
  }
  
  // -----------------------------------------------------------------------------------
  
  public function call_after_filters()
  {
    if (isset($this->CI->afterFilters)) 
    {
      $this->__call_filters($this->CI->afterFilters);
    }
  }
}
