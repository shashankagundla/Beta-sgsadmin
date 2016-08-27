<?php
require_once("mysql.class.php");

class Users {
    public $oAuthTable = 'oAuth';
    public $employeeTable = 'employee';

    function auth($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
        //first check if oauth is sgs hd
        if ($_SESSION['google_data']['hd'] != "sgstowers.com") {
            header("location: /error/oauth_domain/");
            exit;
        }

        $db = new MySQL();
        // Create an array that holds the google information
        $oauthData["oauth_provider"] = MySQL::SQLValue($oauth_provider);
        $oauthData["oauth_uid"] = MySQL::SQLValue($oauth_uid);
        $oauthData["fname"] = MySQL::SQLValue($fname);
        $oauthData["lname"] = MySQL::SQLValue($lname);
        $oauthData["email"] = MySQL::SQLValue($email);
        $oauthData["gender"] = MySQL::SQLValue($gender);
        $oauthData["locale"] = MySQL::SQLValue($locale);
        $oauthData["picture"] = MySQL::SQLValue($picture);
        $oauthData["gpluslink"] = MySQL::SQLValue($link);
        $oauthData["modified"] = MySQL::SQLValue(date("Y-m-d H:i:s"));

        //Check for authenticating user in oauth table
        $result = $db->Query("SELECT * FROM $this->oAuthTable WHERE oauth_uid = '".$oauth_uid."'");
        if (! $result) { $db->Kill(); }

        //If user already has oAuth update oAuth table
        if($db->RowCount() == 1){
            // Create a filter array the determines which record(s) to process
            $where["oauth_provider"] = MySQL::SQLValue($oauth_provider);
            $where["oauth_uid"] = MySQL::SQLValue($oauth_uid);

            // Update oAuth Data
            $result = $db->UpdateRows($this->oAuthTable, $oauthData, $where);
            if (! $result) { $db->Kill(); }

        }else{

            //create oAuth record
            $oauthData["created"] = MySQL::SQLValue(date("Y-m-d H:i:s"));
            $result = $db->InsertRow($this->oAuthTable, $oauthData);
            if (! $result) { $db->Kill(); }

            //check if user e-mail is in employee table
            $result = $db->Query("SELECT email FROM $this->employeeTable WHERE email = '".$email."'");
            if (! $result) { $db->Kill(); }

            if ($db->RowCount() == 0){
                //if no create new employee
                $employeeData["o_id"] = MySQL::SQLValue($oauth_uid);
                $employeeData["fname"] = MySQL::SQLValue($fname);
                $employeeData["lname"] = MySQL::SQLValue($lname);
                $employeeData["email"] = MySQL::SQLValue($email);
                $employeeData["picture"] = MySQL::SQLValue($picture);
                $employeeData["theme"] = MySQL::SQLValue(1);
                $employeeData["created"] = MySQL::SQLValue(date("Y-m-d H:i:s"));
                $employeeData["modified"] = MySQL::SQLValue(date("Y-m-d H:i:s"));
                $employeeData["login"] = MySQL::SQLValue(date("Y-m-d H:i:s"));
                $result = $db->InsertRow($this->employeeTable, $employeeData);
                if (! $result) { $db->Kill(); }

            }else{

                //if yes update employee
                $employeeData["picture"] = MySQL::SQLValue($picture);
                $employeeData["login"] = MySQL::SQLValue(date("Y-m-d H:i:s"));
                $result = $db->UpdateRows($this->oAuthTable, $oauthData, $where);
                if (! $result) { $db->Kill(); }

            }
        }

        // Finally Lets Login!
        $result = $db->QuerySingleRowArray("SELECT * FROM $this->employeeTable WHERE email = '".$email."'");
        if (! $result) { $db->Kill(); }
        $_SESSION['user'] = $result;

        //Successful login, now redirect
        header("location: /account/");

        return;
	}


	function checkAuth(){
        /*
         * TODO: Research how secure this really is.
         */
	    session_start();
        if(!isset($_SESSION['google_data'])):header("Location:/");endif;
    }
}
?>
