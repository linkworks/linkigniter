<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layouts Class. PHP5 only. Supports method chaining.
 *
 * @author Ian Murray
 */
class Layouts {
	/**
	 * @var CodeIgniter Object
	 */
	var $CI;
	//var $title;
	//var $subtitle;
	
	var $js_includes = array();
	var $css_includes = array();
	
	/**
	 * Extra data set automagically with __set. All this data is sent to the layouts.
	 *
	 * @var string
	 */
	var $data = array();
	
	// -----------------------------------------------------------------------------------------------
	
  function Layouts()
  {
  	$this->CI =& get_instance();
		//$this->title = null;
		//$this->subtitle = null;
		$this->data['title_for_layout'] = null;
  }
  
  // -----------------------------------------------------------------------------------------------
  
  /**
   * Automagic method that sets variables when they do not exist.
   *
   * Usage: Layouts->variable_for_layout = 'something';
   *
   * Can later be accesed from views.
   *
   * @param string $name 
   * @param string $value 
   * @return void
   * @author Ian Murray
   */
  function __set($name, $value)
  {
    $this->data[$name] = $value;
  }
  
  // -----------------------------------------------------------------------------------------------
  
  /**
   * Returns data set with __set().
   *
   * @param string $name 
   * @return void
   * @link http://www.php.net/manual/en/language.oop5.overloading.php
   */
  function __get($name)
  {
    if (array_key_exists($name, $this->data)) 
    {
      return $this->data[$name];
    }
    else 
    {
      $trace = debug_backtrace();
      trigger_error(
        'Undefined property via __get(): ' . $name .
        ' in ' . $trace[0]['file'] .
        ' on line ' . $trace[0]['line'],
        E_USER_NOTICE);
        
      return null;
    }
  }
  
  // -----------------------------------------------------------------------------------------------
  
	/**
	 * Loads a view inside a layout file. By default the layout is called default.php
	 * and is located inside the views/layouts folder. It has to contain at some point
	 * an echo $content_for_layout.
	 *
	 * @return 
	 * @param object $view_name
	 * @param object $params[optional]
	 */
	function view($view_name, $params = array(), $layout = 'default') 
	{
		if ($params === null) 
		{
			$params = array();
		}
		
    $this->CI->output->set_header('Content-Type: text/html; charset=utf-8');		
		$view_content = $this->CI->load->view($view_name, $params, true);
		
		/*
		if($this->title !== null) {
			$this->title = '| ' . $this->title;
		}
		*/
		
		if ($this->data['title_for_layout'] !== null) 
		{
		  $this->data['title_for_layout'] = '- ' . $this->data['title_for_layout'];
		}
		
		//ob_start('ob_gzhandler');
		//$this->CI->output->cache(15);
		//$this->CI->load->view('layouts/' . $layout, array('content_for_layout' => $view_content, 'title_for_layout' => $this->title, 'subtitle_for_layout' => $this->subtitle));
		
		$this->data['content_for_layout'] = $view_content;
		$this->CI->load->view('layouts/' . $layout, $this->data);
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Wrapper for Output::set_header()
	 *
	 * @param string $header 
	 * @return void
	 * @author Ian Murray
	 */
	function set_header($header)
	{
	  $this->CI->output->set_header($header);
	  return $this;
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Loads a 404 page.
	 *
	 * TODO return 404 headers.
	 *
	 * @return void
	 * @author Ian Murray
	 */
	function show_404() 
	{
		//$this->set_title('Página no encontrada');
		//$this->view('404');
		$this->CI->output->set_status_header('404');
		//$this->CI->load->view('errors/404');
		show_404($this->CI->uri->uri_string());
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Sets the title of the page. This has to be printed "manually" with an echo $title_for_layout
	 * on the layout.
	 * @return 
	 * @param object $title
	 */
	function set_title($title) 
	{
		//$this->title = $title;
		$this->data['title_for_layout'] = $title;
		$this;
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Setea el subtitulo de la pagina
	 * @return 
	 * @param object $subtitle
	 */
	function set_subtitle($subtitle) 
	{
		//$this->subtitle = $subtitle;
		$this->data['subtitle_for_layout'] = $subtitle;
		$this;
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Adds javascript includes to the layout. Allows modularization of the javascript files.
	 *
	 * @param string $js 
	 * @return void
	 * @author Ian Murray
	 */
	function add_js($js, $append_path = TRUE)
	{
	  $js = $this->append_ext($js, 'js', $append_path);
	  
	  if (!is_array($js)) 
	  {
	    /* Assume its a string */
	    $this->js_includes[] = $js;
	  }
	  else 
	  {
	    $this->js_includes += $js;
	  }
	  
	  return $this;
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Prints the javascript includes set with the add_js() method. To be called within the layout.
	 *
	 * @param array $extras
	 * @return void
	 * @author Ian Murray
	 */
	function print_js_includes($extras = array())
	{
	  foreach ($extras as $key => $extra)
	  {
	    $extras[$key] = $this->append_ext($extra, 'js');
	  }
	  
	  $string = "";
	  foreach ($extras as $js) 
	  {
	    $string .= '<script type="text/javascript" src="' . $js . '"></script>' . "\n";
	  }
	  
	  foreach ($this->js_includes as $js) 
	  {
	    $string .= '<script type="text/javascript" src="' . $js . '"></script>' . "\n";
	  }
	  
	  return $string;
	}
	
	// -----------------------------------------------------------------------------------------------
  
  /**
	 * Adds css files to the layout. Allows modularization of the css files as well.
	 *
	 * @param string $js 
	 * @return void
	 * @author Ian Murray
	 */
	function add_css($css, $append_path = TRUE)
	{
	  $css = $this->append_ext($css, 'css', $append_path);
	  
	  if ( ! is_array($css)) 
	  {
	    /* Assume its a string */
	    $this->css_includes[] = $css;
	  }
	  else 
	  {
	    $this->css_includes += $css;
	  }
	  
	  return $this;
	}
	
	// -----------------------------------------------------------------------------------------------
  
	/**
	 * Appends an extension if necessary
	 *
	 * @param string $ext 
	 * @return void
	 * @author Ian Murray
	 */
	function append_ext($path_to_file, $ext, $append = TRUE)
	{
	  if ($append) 
	  {
	    $path = base_url(); 
	  }
	  else 
	  {
	    $path = '';
	  }
	  
	  $ext = '.' . $ext;
    if (substr($path_to_file, -1, 3) != $ext) 
	  {
	    $path_to_file .= $ext;
	  }
	  
	  return $path . $path_to_file;
	}
	
	// -----------------------------------------------------------------------------------------------
	
	/**
	 * Prints the css file includes. To be called within the layout.
	 *
 	 * @param array $extras
	 * @return void
	 * @author Ian Murray
	 */
	function print_css_includes($extras = array())
	{
	  foreach ($extras as $key => $extra)
	  {
	    $extras[$key] = $this->append_ext($extra, 'css');
	  }
	  
	  $string = "";
	  foreach ($extras as $css) 
	  {
	    $string .= '<link href="' . $css . '" rel="stylesheet" type="text/css" />' . "\n";
	  }
	  
	  foreach ($this->css_includes as $css) 
	  {
	    $string .= '<link href="' . $css . '" rel="stylesheet" type="text/css" />' . "\n";
	  }
	  
	  return $string;
	}
	
	// -----------------------------------------------------------------------------------------------

	
	/**
	 * Redirects the user to the given page, and sets 2 flashdata variables
	 * to show a message.
	 *
	 * @param string $url 
	 * @param string $message 
	 * @param string $type 
	 * @return void
	 * @author Ian Murray
	 */
	function flash_redirect($message = '', $url = '/', $type = FLASH_MESSAGE)
	{
	  if ($message != '') 
	  {
      $this->CI->session->set_flashdata('message', $message);
      $this->CI->session->set_flashdata('type', $type);
    }
    
    redirect($url);
	}
}
