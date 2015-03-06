<?php

class validator{
	public  $errors = array();

	function valid_email($email){

		if(!preg_match('/^[a-zA-Z]([a-zA-Z 0-9]+|[a-zA-Z 0-9]+\.[a-zA-Z 0-9]+)+@[a-zA-Z]+\.((com)|(org)|(net))*$/',$email) || empty($email)){
		 return "please enter valid mail equal to example@exp.exp"."<br/>";
		}

	}
        
        function check_email($emaildb, $postemail) {
        if ($emaildb== $postemail) {
            return true;
        } else {
            return "invalid email please check your email" . "<br>";
        }
    }
    
     
        function check_question($questiondb, $question) {
        if ($questiondb== $question) {
            return true;
        } else {
            return "your question is incorrect please check it" . "<br>";
        }
    }
    
    function check_answer($answerdb, $answer) {
        if ($answerdb== $answer) {
            header("location: ../user/user_home.php");
        } else {
            return "" . "<br>";
        }
    }
    
     function valid_password($password, $confirm_password) {
        if ($password == $confirm_password) {
            return true;
        } else {
            return "not match password type it again" . "<br>";
        }
    }
    
    // check the password that user enter equal the password saved in databaser
   
    


	function empty_fields($data){
		
		foreach($data as $key =>$value)
		{
			if(empty($value)){
			
				$this->errors[$key]="$key is required";
			}
		}
		if(count($this->errors)){
			return $this->errors;
		} else {
			return true;
		}
		
	}

}