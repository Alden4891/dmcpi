<?php
/**
 * Import a .sql file in a MySQL database
 *
 * Usage:
 *
 * 1. edit the configuration parameters here below and save
 * 2. upload to the proper folder - usually /public_html - on your server
 * 3. open a browser and execute with with an URL similar to:
 *		http://example.com/dbimport.php
 *
 *		Changing example.com with the name of your site
 *
 * (c) 2013 http://grandolini.com
 */

/**
 * Full path to the file you want to import
 * It must be a valid sql file, like the one exported by phpMyAdmin or the dbexport.php 
 * file you found in the same zip as this script
 *
 * Examples:
 * $filename = '~/public_html/mydata.sql';
 * $filename = '~/mydata.sql';
 * $filename = 'mydata.sql';
 */
$filename	= 'mydata.sql';

/**
 * MySQL connection configuration
 */
$database	= 'Enter the name of the database where you want to import your data';
$user		= 'Enter the MySQL user to access the database';
$password	= 'Enter the MySQL password to access the database';

/**
 * usually it's ok to leave the MySQL host as 'localhost'
 * if your hosting provider instructed you differently, edit the next one as needed
 */
$host = 'localhost';

/**
 * DO NOT EDIT BELOW THIS LINE
 */
$command = 'mysql -h '. $host .' -u '. $user .' -p'. $password .' '. $database .' < '. $filename;

exec( $command, $output = array(), $worked );

switch( $worked ) {

	case 0:

		echo 'Import file <b>'. $filename .'</b> successfully imported to database <b>'. $database .'</b>';
		break;

	case 1:

		echo 'There was an error during import.'
			. 'Please make sure the import file is saved in the same folder as this script and check your values:'
			. '<br/><br/><table>'
			. '<tr><td>MySQL Database Name:</td><td><b>'. $database .'</b></td></tr>'
			. '<tr><td>MySQL User Name:</td><td><b>'. $user .'</b></td></tr>'
			. '<tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr>'
			. '<tr><td>MySQL Host Name:</td><td><b>'. $host .'</b></td></tr>'
			. '<tr><td>MySQL Import Filename:</td><td><b>'. $filename .'</b></td>'
			. '</tr></table>'
		;
		break;
}
