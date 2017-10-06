<?php 		// Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = $_SERVER['RDS_HOSTNAME'];
$CFG->dbname    = $_SERVER['RDS_DB_NAME'];
$CFG->dbuser    = $_SERVER['RDS_USERNAME'];
$CFG->dbpass    = $_SERVER['RDS_PASSWORD'];
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3306,
  'dbsocket' => '',
);

$CFG->wwwroot   = $_SERVER['APP_WWWROOT'];
$CFG->dataroot  = '/var/app/moodledata';
$CFG->admin     = 'admin';
// Moodledata perfmissions
$CFG->directorypermissions = 0777;
// SSL Offloading LB
$CFG->sslproxy  = 1;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!