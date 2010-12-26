<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('add_icon'))
{
  function add_icon($src, $title, $align = "middle", $class = "icon")
  {

    if ($src[0] == '/')
    {
      $src = substr($src, 1);
    }
  	 
  	$base_url = base_url();
    return '<img class="' . $class . '" src="' . $base_url . ICON_PATH . $src . '" align="' . $align . '" alt="' . $src . ' icon" title="' . $title . '">';       
  }
}

if ( ! function_exists('add_link_icon'))
{
  function add_link_icon($dst, $title, $src, $onclick = FALSE, $align = "middle")
  {
  	if ($dst[0] == '/')
		{
			$dst = substr($dst, 1);
		}
		
    $url_path = site_url() . '/' . $dst;
		if ($onclick == FALSE)
		{
      $icon = '<a href="' . $url_path . '">';
		}
		else
		{
      $icon = '<a href="' . $url_path . '" title="' . $title . '" onclick="' . $onclick . '">';
		}
		
    $icon .= add_icon($src, $title, $align);
    $icon .= '</a>';
    return $icon;   
  }
}

if ( ! function_exists('show_ext_icon'))
{
  function show_ext_icon($name)
  {
    $extensions = array(
      'doc' => 'page_white_word.png',
      'docx' => 'page_white_word.png',
      'xls' => 'page_white_excel.png',
      'xlsx' => 'page_white_excel.png',
      'ppt' => 'page_white_powerpoint.png',
      'pptx' => 'page_white_powerpoint.png',
      '7z' => 'page_white_compressed.png',
      'zip' => 'page_white_compressed.png',
      'rar' => 'page_white_compressed.png',
      'png' => 'page_white_picture.png',
      'jpg' => 'page_white_picture.png',
      'jpeg' => 'page_white_picture.png',
      'gif' => 'page_white_picture.png',
      'pdf' => 'page_white_acrobat.png',
      
      'unknown' => 'page.png'
    );
    
    // Get extension
    $ext = explode('.', $name);
    $ext = $ext[count($ext) - 1];
    
    if (in_array($ext, array_keys($extensions)))
    {
      return add_icon('file_types/' . $extensions[$ext], '');
    }
    else
    {
      return add_icon('file_types/' . $extensions['unknown'], '');
    }
  }
}