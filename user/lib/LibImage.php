<?php
	function getFileLimit($l) {
		if ($l > 1000000000) {
			$limit_size = (int)($l/1000000000) . " GB";
		} elseif ($l > 1000000) {
			$limit_size = (int)($l/1000000) . " MB";
		} elseif ($l > 1000) {
			$limit_size = (int)($l/1000) . " KB";
		}
		
		return $limit_size;
	}
	
function uploadfile($file, $path, $type, $limit=3150000){

	//global $$file;
	$uf  = $_FILES[$file]['tmp_name'];
	$ufn = $_FILES[$file]['name'];
	$ufs = $_FILES[$file]['size'];
	$uft = strtolower(strrchr($ufn,"."));
	$ufe = $_FILES[$file]["error"];

	//echo $_FILES[$file]['name'];
	//print_r($_FILES[$file]);
	if($ufe > 0){
		switch($ufe){
			case UPLOAD_ERR_INI_SIZE:
				return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			case UPLOAD_ERR_FORM_SIZE:
				return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			case UPLOAD_ERR_PARTIAL:
				return 'The uploaded file was only partially uploaded';
			case UPLOAD_ERR_NO_FILE:
				return 'No file was uploaded';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'Missing a temporary folder';
			case UPLOAD_ERR_CANT_WRITE:
				return 'Failed to write file to disk';
			case UPLOAD_ERR_EXTENSION:
				return 'File upload stopped by extension';
			default:
				return 'Unknown upload error';
		}
	}else{
		if(empty($type)){
			$con = true;
		}else{
			$con = in_array($uft,$type);

			
			/*echo $uft;
			
			if (in_array($uft,$type))
			{
				echo "Match found";
			}
				else
			{
			echo "Match not found";
			}
			*/
			
		}
		if($con){
			if ($ufs > $limit) {
					return 'File was not uploaded because it exceeds the size limit of ' & Int($limit/(1024*1024)) & 'MB';
			}else{
				
					$$file = date('Ymd')."_".$ufn;
					echo $$file;
					copy($uf, $path.$$file);
					unlink($uf);
					return $$file;
					//return 'Uploaded';
			}
		}else{
			return 'File was not uploaded because it not a supported file type.';
		}
	}
}

	function uploadmultiple_file($file, $path, $type, $limit=3150000){

		/************************Test Code*****************************/
		/*for($i=0; $i<count($_FILES[$file]['name']); $i++) {
			echo $_FILES[$file]['name'][$i];
		}*/
		/*************************************************************/
		for($i=0; $i<count($_FILES[$file]['name']); $i++) {
			$uf  = $_FILES[$file]['tmp_name'][$i];
			$ufn = $_FILES[$file]['name'][$i];
			$ufs = $_FILES[$file]['size'][$i];
			$uft = strtolower(strrchr($ufn,"."));
			$ufe = $_FILES[$file]["error"][$i];

			
			//print_r($_FILES[$file]);
			if($ufe > 0){
				switch($ufe){
					case UPLOAD_ERR_INI_SIZE:
						return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					case UPLOAD_ERR_FORM_SIZE:
						return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					case UPLOAD_ERR_PARTIAL:
						return 'The uploaded file was only partially uploaded';
					case UPLOAD_ERR_NO_FILE:
						return 'No file was uploaded';
					case UPLOAD_ERR_NO_TMP_DIR:
						return 'Missing a temporary folder';
					case UPLOAD_ERR_CANT_WRITE:
						return 'Failed to write file to disk';
					case UPLOAD_ERR_EXTENSION:
						return 'File upload stopped by extension';
					default:
						return 'Unknown upload error';
				}
			}else{
				if(empty($type)){
					$con = true;
				}else{
					$con = in_array($uft,$type);

					
					/*echo $uft;
					
					if (in_array($uft,$type))
					{
						echo "Match found";
					}
						else
					{
					echo "Match not found";
					}
					*/
					
				}
				if($con){
					if ($ufs > $limit) {
							return 'File was not uploaded because it exceeds the size limit of ' & Int($limit/(1024*1024)) & 'MB';
					}else{
						
							$$file = date('Ymd')."_".$ufn;
							//echo $$file;
							copy($uf, $path.$$file);
							unlink($uf);
							//return $$file;
							//return 'Uploaded';
					}
				}else{
					func_setErrMsg("-File ".$_FILES[$file]['name'][$i]." was not uploaded because it not a supported file type.<br/>");
				}
			}
		
		}
		
	}

	
	function ResizeImage($pathToImages, $pathToThumbs, $thumbWidth, $thumbHeight, $thumbWH='A') {
		ini_set("memory_limit", "200M");
		$info = array();
		$thumbExt = strtolower(strrchr($pathToImages,"."));
		//$img = imagecreatefromjpeg($pathToImages); 
		if($thumbExt=='.jpg' || $thumbExt=='.jpeg') $img = imagecreatefromjpeg($pathToImages); 
		if($thumbExt=='.gif') $img = imagecreatefromgif($pathToImages); 
		if($thumbExt=='.png') $img = imagecreatefrompng($pathToImages); 
		
		$width = imagesx( $img );
		$height = imagesy( $img );
		
		if($thumbWH == 'F') {
			$condition = true;
			$new_width = $thumbWidth;
			$new_height = $thumbHeight;
		}elseif($thumbWH == 'A') {
			$condition = $width > $thumbWidth || $height > $thumbHeight;
			$new_width = $thumbWidth;
			$new_height = floor($height*($thumbWidth/$width));
			if ($new_height > $thumbHeight) {
				$new_height = $thumbHeight;
				$new_width = floor($width*($thumbHeight/$height));
			}
		}elseif($thumbWH == 'W') {
			$condition = $width > $thumbWidth;
			$new_width = $thumbWidth;
			$new_height = floor($height*($thumbWidth/$width));
		}else{
			$condition = $height > $thumbHeight;
			$new_height = $thumbHeight;
			$new_width = floor($width*($thumbHeight/$height));
		}
		
		if($condition){
			$tmp_img = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($tmp_img, true);
			imagesavealpha($tmp_img, true);
			imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			//imagejpeg($tmp_img,$pathToThumbs,100); 
			if($thumbExt=='.jpg' || $thumbExt=='.jpeg') imagejpeg($tmp_img,$pathToThumbs,100); 
			if($thumbExt=='.gif') imagegif($tmp_img,$pathToThumbs,100); 
			if($thumbExt=='.png') imagepng($tmp_img,$pathToThumbs,9,PNG_ALL_FILTERS);
			$info = array($new_width,$new_height,filesize($pathToImages));
			imagedestroy($tmp_img);
			return $info;
		}else{
			copy($pathToImages,$pathToThumbs);
			$info = array($width,$height,filesize($pathToImages));
			return $info;
		}
	}

	function getPopWidth($img) {
		list($w, $h) = getimagesize($img);
		if ($w > 900) $w = 900;
		return ($w+30);
	}
	
	function getPopHeight($img) {
		list($w, $h) = getimagesize($img);
		if ($h > 600) $h = 600;
		return ($h+30);
	}
	
	function getPopSize($img) {
		list($w, $h) = getimagesize($img);
		if ($w > 900) $w = 900;
		if ($h > 600) $h = 600;
		return array(($w+30),($h+30));
	}
	
	function getThumbSize($pathToImages, $thumbWidth, $thumbHeight) {
		if (file_exists($pathToImages)) {
			list($width, $height) = getimagesize($pathToImages);
			$new_width = $width;
			$new_height = $height;			
			
			if ($thumbWidth !=0 && $thumbHeight !=0) {
				if($width > $thumbWidth) {
					$new_width = $thumbWidth;
					$new_height = floor( $height * ( $thumbWidth / $width ) );
				}
					
				if ($new_height > $thumbHeight) {
					$new_height = $thumbHeight;
					$new_width = floor( $width * ( $thumbHeight / $height ) );
				}
			}
			
			return array($new_width,$new_height);
		}	else {
			return array(0,0);
		}
	}
	
?>