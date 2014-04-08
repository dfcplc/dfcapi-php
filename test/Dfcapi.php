<?php
echo PHP_EOL.PHP_EOL.'---------------------------------------------------------------'.PHP_EOL;
echo "Running the DFCAPI-PHP bindings test suite.\n\n".
     "If you're trying to use the DFCAPI-PHP bindings you'll probably\n".
     "want to require('lib/Dfcapi.php'); instead of this file";
echo PHP_EOL.'---------------------------------------------------------------'.PHP_EOL.PHP_EOL;

require_once(dirname(__FILE__) . '/Dfcapi/DfcapiTest.php');

?>