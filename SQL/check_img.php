<?php
function check_img($file, $path = null)
{
	$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm"); 
	foreach ($blacklist as $item) 
		if(preg_match("/$item\$/i", $file['name'])) exit; 
	$type = $file['type']; 
	$size = $file['size']; 
	if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/png")) exit; 
	if ($size > 10240000000) exit; 
	if ($path)
	{
		if (!is_dir('../srcs/images/'.$path))
		{
			mkdir('../srcs/images/'.$path);
		}
		$uploadfile = "../srcs/images/$path/".$file['name'];
		move_uploaded_file($file['tmp_name'], $uploadfile);
	}
}
function RemoveFileInDir($dir) {

	$includes = glob($dir.'/*');

	foreach ($includes as $include) {

		if(is_dir($include)) {

			recursiveRemoveDir($include);
		}

		else {

			unlink($include);
		}
	}
}
?>
