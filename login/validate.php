<?php

class validator{
	public  $errors = array();

	function valid_email($email){

		if(!preg_match('/^[a-z]([a-z0-9]+|[a-z0-9\._-]+[a-z0-9]+)*@[a-z0-9]+\.[a-z]{2,4}+$/',$email) || empty($email)){
		 return "please enter valid mail equal to example@exp.exp"."<br/>";
		}

	}
        
       


	function empty_fields($data){
		
		foreach($data as $key =>$value)
		{
			if(empty($value)){
			
				$this->errors[]="$key is required";
			}
		}
		if(count($this->errors)){
			return $this->errors;
		} else {
			return true;
		}
		
	}

}