<html>
<head>
<title>Welcome to LinkIgniter</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>Welcome to LinkIgniter!</h1>

<p>LinkIgniter is a modified version of CodeIgniter 1.7.3. It comes bundled with Doctrine ORM, and is restructured the following way:</p>
<code>
  /application/ &lt- The application folder has been moved here.<br>
  /public/ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;- all public files and folders should go there, css and js files, etc. Your server's DocumentRoot should point here<br>
  /system/ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;- Classic system folder, nothing to modify or see here.<br>
  /utilities/ &nbsp;&nbsp;&lt;- Contains the Doctrine CLI
</code>

<p>Create your model schema by creating YAML schema files in the following folder:</p>
<code>/application/database/schema</code>

<p>Then edit the system/application/database.php file. After that, to create the PHP models, the database and tables, execute the following commands on the terminal:</p>
<code>
  $ cd /path/to/the/project/folder/utilities<br>
  $ ./create-all-load-data
</code>

<p>That creates all models in the application/models folder, drops and creates the database, creates the tables and loads the data.
<hr>
<p>The page you are looking at is being generated dynamically by LinkIgniter.</p>

<p>If you would like to edit this page you'll find it located at:</p>
<code>system/application/views/welcome_message.php</code>

<p>The corresponding controller for this page is found at:</p>
<code>system/application/controllers/welcome.php</code>

<p>If you have doubts, read the CodeIgniter's <a href="user_guide/">User Guide</a>.</p>


<p><br />Page rendered in {elapsed_time} seconds</p>

</body>
</html>