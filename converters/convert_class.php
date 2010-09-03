<?php

class Converter{
	
	function Base64Decode($input){
		$input = base64_decode($input);
		return $input;	
	}
	
	function Base64Encode($input){
		$input = base64_encode($input);
		return $input;
	}
	
}
?>
