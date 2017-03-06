<?php

include "class.upload.php";

$image = new Upload($_FILES["image"]);
if($image->uploaded){
	$image->Process("uploads/");
	if($image->processed){
		echo "Upload Success";
	}else{
		echo "Error: ".$image->error;
	}
}

?>