<?php

ini_set('max_execution_time', 0);
$dir = realpath('.');
$count = 0;
$files = $mysqli->query('SELECT id,file,size FROM bf_files');
foreach($files as $file){
	$file->file = str_replace('//', '/', $file->file);
	if(!file_exists($dir . '/logs' . $file->file)){
		$mysqli->query('delete from bf_files where (id = \''.$file->id.'\')');
		$count++;
	}
}
echo $count;
?>