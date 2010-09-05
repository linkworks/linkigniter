var allow_show = true;
var showing_results = false;

function hide_console() 
{
  $('#linkigniter_console').animate({'bottom' : '-345px'}, 'fast');
  allow_show = false;
  showing_results = false;
  setTimeout(function(){allow_show = true}, '1000');
}

function show_console_big() 
{
  showing_results = true;
  $('#linkigniter_console').animate({'bottom' : '0px'}, 'fast');
}

function send_command() 
{
  // Show loading gif
  $('#linkigniter_close').hide();
  $('#linkigniter_loading').show();
  
  $.ajax({
    'url' : site_url('linkigniter/console'),
    'type' : 'post',
    'data' : {
      'command' : $('#linkigniter_command').select().val()
    },
    'success' : function(data){
      $('#linkigniter_response').html('<pre>' + data + '</pre>');
      show_console_big();
      $('#linkigniter_close').show();
      $('#linkigniter_loading').hide();
    }
  });
}

// -----------------------------------------------------------------------------------

$('document').ready(function(){
  // Show the console on hover
  $('#linkigniter_console, #linkigniter_command').hover(function(){
    if (allow_show && ! showing_results)
    {
      $('#linkigniter_console').animate({'bottom' : '-315px'}, 'fast');
      $('#linkigniter_command').select();
    }
  })
  
  // Hide it on request
  $('#linkigniter_close').click(function(){
    hide_console();
  });
  
  // Catch enter key & esc key
  $('#linkigniter_command').keyup(function(e) {
    if(e.keyCode == 13) 
    {
      send_command();
    }
    else if(e.keyCode == 27)
    {
      hide_console();
    }
  });
});