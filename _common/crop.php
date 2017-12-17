<?php

function crop($file_name, $savePath, $crop_width, $crop_height)
{
	$file_type = explode('.', $file_name);
	$file_type = $file_type[count($file_type) -1];
	$file_type = strtolower($file_type);

	$original_image_size = getimagesize($file_name);
	$original_width = $original_image_size[0];
	$original_height = $original_image_size[1];

	switch ($file_type)
	{
		case 'jpg':
		case 'jpeg':
			$original_image_gd = imagecreatefromjpeg($file_name);
			break;
		case 'gif':
			$original_image_gd = imagecreatefromgif($file_name);
			break;
		case 'png':
			$original_image_gd = imagecreatefrompng($file_name);
			break;
		default:
			exit();
			break;
	}
	$cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
	//$white = imagecolorallocate($cropped_image_gd, 255, 255, 255);
	//imagefill($cropped_image_gd, 0, 0, $white);

	// Generate new GD image
	// If it already fits, there's nothing to do
	if ($original_width <= $crop_width && $original_height <= $crop_height) {
		// no need to resize
		$cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
		imagecopyresampled($cropped_image_gd ,$original_image_gd ,0,0,0,0, $crop_width, $crop_height, $original_width , $original_height );
	}else{
		$cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
		// Determine aspect ratio
		$aspect_ratio = $original_height / $original_width;
		// Make width fit into new dimensions
		if ($original_width > $crop_width) {
			$width = $crop_width;
			$height = $width * $aspect_ratio;
		} else {
			$width = $original_width;
			$height = $original_height;
		}
		// Make height fit into new dimensions
		if ($height > $crop_height) {
			$height = $crop_height;
			$width = $height / $aspect_ratio;
		}
		$cropped_image_gd = imagecreatetruecolor($width, $height);
		// Resize
		imagecopyresampled($cropped_image_gd, $original_image_gd, 0, 0, 0, 0, $width, $height, $original_width , $original_height );
	}

	imagejpeg($cropped_image_gd, $savePath);
	imagedestroy($cropped_image_gd);
}