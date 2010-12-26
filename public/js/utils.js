/**
 * Simulates CI's site_url()
 */
function site_url(url) {
  return METHOD_URL + url;
}

function error_msg(message)
{
  $('#error-bar').find('.the-message').html(message);
  $('#error-bar').slideDown('fast');
}

function alert_msg(message)
{
  $('#alert-bar').find('.the-message').html(message);
  $('#alert-bar').slideDown('fast');
}

function message_msg(message)
{
  $('#message-bar').find('.the-message').html(message);
  $('#message-bar').slideDown('fast');
}

function close_msg()
{
  $('#error-bar').slideUp();
  $('#alert-bar').slideUp();
  $('#message-bar').slideUp();
}

function load_tiptips()
{
  $('img.icon').tipTip({
    defaultPosition: 'top',
    fadeIn: 100,
    fadeOut: 100,
    delay: 50
  });
}

// ------------------------------------------------------------------------

$('document').ready(function(){

  // Block form submit button when submitting.
	$('form').submit(function(){
	    $('input[type=submit]', this).attr('disabled', 'disabled')
	                                 .attr('value', 'Enviando ...');
	});
	
	// Handle clicks on the close button of alerts
  $('#error-bar .close').click(close_msg);
  $('#alert-bar .close').click(close_msg);
  $('#message-bar .close').click(close_msg);
	
  // Tiptips for img.icon
  load_tiptips();
  
  // Custom tiptips
  $('.tiptip_top').tipTip({defaultPosition: 'top', fadeIn: 100, fadeOut: 100, delay: 0});
  $('.tiptip_right').tipTip({defaultPosition: 'right', fadeIn: 100, fadeOut: 100, delay: 0});
  $('.tiptip_bottom').tipTip({defaultPosition: 'bottom', fadeIn: 100, fadeOut: 100, delay: 0});
  $('.tiptip_left').tipTip({defaultPosition: 'left', fadeIn: 100, fadeOut: 100, delay: 0});

});