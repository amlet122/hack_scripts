<?php
do
{
	if (!class_exists('DBSEO'))
	{
		// Set important constants
		define('DBSEO_CWD', 	DIR);
		define('DBSEO_TIMENOW', TIMENOW);
		define('IN_DBSEO', 		true);

		// Make sure we nab this class
		require_once(DBSEO_CWD . '/dbtech/dbseo/includes/class_core.php');

		// Init DBSEO
		DBSEO::init(true);
	}

	if (!DBSEO::$config['dbtech_dbseo_active'])
	{
		// Mod is disabled
		break;
	}
	
	if (!DBSEO::$config['dbtech_dbseo_rewrite_tags'])
	{
		// Not rewriting tags
		break;
	}

	if (THIS_SCRIPT != 'tags')
	{
		// Not viewing tag list
		break;
	}

	// Prepend canonical URL
	DBSEO_Url_Create::addCanonical($headinclude, preg_replace('#\?.+#', '', $_SERVER['DBSEO_URI']), false);
}
while (false);
?>