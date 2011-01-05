# LinkIgniter

LinkIgniter is a modified version of [CodeIgniter][1].

## Donations

We welcome donations! If you would like to make a contribution please do so using **[Pledgie][pledgie]**. We would be extremely thankful!

## Features

  - **New directory structure:** The application folder now resides in the root of the project folder, so that the system folder is easily replaceable by any updates. All public files now reside in the `public` folder, which is where the DocumentRoot of the webserver should now point to. This provides better security by isolating all sensitive files.
  - **Doctrine:** LinkIgniter comes bundled with the Doctrine ORM. In the `application` folder you will find a `database` folder containing all things related to Doctrine.
  - **Layouts Manager:** CodeIgniter does not come with a layouts system. LinkIgniter comes with one bundled, and enables you to use layouts for your webpages. There is a default layout in the `application/views/layouts` folder called `default.php` which should give you a basic idea. When needing to render a view, simply call `$this->layouts->view()` instead of `$this->load->view()` and the layout will be rendered with the contents of the view. You can find more info on this in the library itself, located in the applications library folder.
  - **Test Console:** When developing, you will notice a small console in the bottom of all pages, which enables you to test Doctrine queries and stuff. Give it a try! *(This component is still in VERY early development stages)*
  - **Doctrine CLI**: Once you've created your YAML schemas in the `application/database/schema` folder, you can use the included Doctrine CLI in the `utilities` folder, or use the included script `utilities/create-all-load-data` which drops the database, creates a new one, loads the tables, creates the models and loads all fixtures (use this script with care though, it can bite).
  - **Code Baker**: One of the great features of Cake is it's code baker. We've re-created it (using their Inflector class). Once you've created all database tables, point your browser to http://localhost/linkigniter and press the *Bake these tables* button. This will create a complete scaffolding interface with [Datatables][2] included! Give it a try, it's awesome! You can even edit the templates used in the `application/views/linkigniter/baker_templates` folder to customize your design. *(This feature currently works on PHP versions prior to 5.3).*
  - **Action Filters**: Rails-like before\_filters and after\_filters. Just create a method in LI\_Controller or your normal controllers and add `var $beforeFilters = array('method')` to enable. More examples in the source for `LI_Controller.php` in the application/libraries folder.

## Word of advice

This is in **very** early development stages, and there are probably some bugs running around the code. Feel free to fork the repo and submit pull requests with patches and new features!

## On the licenses

The included MIT license only applies to our code (the code baker and the layouts library for example). Every third-party component has its own license.


[1]: http://codeigniter.com
[2]: http://www.datatables.net
[pledgie]: http://www.pledgie.com/campaigns/14354