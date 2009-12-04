How to Install
-------------------------
1. Create/locate a new mysql database to install php point of sale into
2. Execute the file database/database.sql to create the tables needed
3. unzip and upload PHP Point Of Sale files to web server
4. Copy application/config/database.php.tmpl to application/config/database.php
5. Modify application/config/database.php to connect to your database
6. Copy application/config/config.php.tmpl to application/config/config.php
7. In application/config/config.php FIND:
$config['base_url']	= "http://localhost/PHP-Point-Of-Sale/";
and replace with the full web path to your PHP Point of Sale Install
8. Go to your point of sale install via the browser
9. LOGIN using
username: admin 
password:pointofsale
10. Enjoy