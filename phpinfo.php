<?php

// show all php.ini configuration info
// default argument is 'INFO_ALL'
phpinfo();

?>

<!-- 
phpinfo() options
Name (constant) 	Value	Description
================================================================================================================
INFO_GENERAL	    1	    The configuration line, php.ini location, build date, Web Server, System and more.
INFO_CREDITS	    2	    PHP Credits. See also phpcredits().
INFO_CONFIGURATION	4	    Current Local and Master values for PHP directives. See also ini_get().
INFO_MODULES	    8	    Loaded modules and their respective settings. See also get_loaded_extensions().
INFO_ENVIRONMENT	16	    Environment Variable information that's also available in $_ENV.
INFO_VARIABLES	    32	    Shows all predefined variables from EGPCS (Environment, GET, POST, Cookie, Server).
INFO_LICENSE	    64	    PHP License information. See also the » license FAQ.
INFO_ALL	        -1	    Shows all of the above.
================================================================================================================
-->