<?php

class validator {

    public $errors = array();
    // make validation for email 
    function valid_email($email) {

        if (!preg_match('/^[a-z]([a-z0-9]+|[a-z0-9\._-]+[a-z0-9]+)*@[a-z0-9]+\.[a-z]{2,4}+$/', $email) || empty($email)) {
            return "please enter valid mail equal to example@exp.exp" . "<br/>";
        }
    }
    // make validation for password
    function valid_password($password, $confirm_password) {
        if ($password == $confirm_password) {
            return true;
        } else {
            return "invalid password type it again" . "<br>";
        }
    }
    // make validation for all data of user
    function empty_fields($data) {

        foreach ($data as $key => $value) {
            if (empty($value)) {

                $this->errors[] = "$key is required";
            }
        }
        if (count($this->errors)) {
            return $this->errors;
        } else {
            return true;
        }
    }
    // make validation for image
    function valid_image($image_error, $image_type) {

        if ($image_error > 0) {

            switch ($image_error) {
                case 1: return "File exceeded upload_max_filesize" . "<br/>";
                    break;
                case 2: return "File exceeded max_file_size" . "<br/>";
                    break;
                case 3: return "File only partially uploaded" . "<br/>";
                    break;
                case 4: return "No file uploaded" . "<br/>";
                    break;
                case 6: return "Cannot upload file: No temp directory specified" . "<br/>";
                    break;
                case 7: return "Upload failed: Cannot write to disk" . "<br/>";
                    break;
            }
        }
        // check on image type 
        if ($image_type != 'image/jpeg' && 'image/jpg') {
            return " Upload failed" . "<br/>";
        }
    }

}
