<?php
function check_img($file)
{
	$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm"); 
	foreach ($blacklist as $item)
		if(preg_match("/$item\$/i", $file['name']))
			exit("<script type='text/javascript'>alert('Недопустимый формат файла! - ".$file['name'].':'.$type."')</script>");
	$type = $file['type']; 
	$size = $file['size']; 
	if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/gif") && ($type != "image/webp") && ($type != "image/png"))
		exit("<script type='text/javascript'>alert('Недопустимый формат файла! - ".$file['name'].':'.$type."')</script>");
	if ($size > 1024000)
		exit("<script type='text/javascript'>alert('Превышен размер файла! - ".$file['name'].':'.$size."')</script>");
}
// function removeFileInDir($dir) {

// 	$includes = glob($dir.'/*');

// 	foreach ($includes as $include) {

// 		if(is_dir($include)) {

// 			recursiveRemoveDir($include);
// 		}

// 		else {

// 			unlink($include);
// 		}
// 	}
// }
?>