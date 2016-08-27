<?php

include("mysql.class.php");

if ($db->Error()) $db->Kill();

class Users {
	public $tableName = 'users';

    function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
        // Create an array that holds the update information
        // $arrayVariable["column name"] = formatted SQL value
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

        //Check if User table exists
        if (! $db->Query("SELECT * FROM $this->tableName")) $db->Kill();

        //Check for user in db
        $prevQuery = $db->Query("SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'");

        //If users is in db then update
        if($db->RowCount() > 0){

            // Create a filter array the determines which record(s) to process
            // (you can specify more than one column if needed)
            $where["oauth_provider"] = MySQL::SQLValue($oauth_provider);
            $where["oauth_uid"] = MySQL::SQLValue($oauth_uid);

            // Execute the update
            $result = $db->UpdateRows($this->tableName, $oauthData, $where);

		}else{

            // Insert New User to DB
            $result = $db->InsertRow($this->tableName, $oauthData);

		}
        // If we have an error display & kill
        if (! $result) { $db->Kill(); }

        //Finally requery db for user data
        $authUser = $db->Query("SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'");

        return $authUser;
	}
}
?>
