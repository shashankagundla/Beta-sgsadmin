<?php
class db_wrapper{
    public function __construct(){
    //database configuration
                $dbServer = 'sgsdb.cxdcv7nlogaf.us-east-1.rds.amazonaws.com'; //Define database server host
                $dbUsername = 'sgsadmin'; //Define database username
                $dbPassword = '8UWGozkMw3mpak'; //Define database password
                $dbName = 'sgsadmin_beta'; //Define database name

                //connect databse
                $con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
                if(mysqli_connect_errno()){
                        die("Failed to connect with MySQL: ".mysqli_connect_error());
                }else{
                        $this->connect = $con;
                }
    }; #connect to db
    public function escape($string);
    public function query($sql);
    public function get_results();
}

class Users {
	public $tableName = 'users';
	function checkUser($oauth_provider,$oauth_uid,$fname,$lname,$email,$gender,$locale,$link,$picture){
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0){
			$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}else{
			$insert = mysqli_query($this->connect,"INSERT INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', fname = '".$fname."', lname = '".$lname."', email = '".$email."', gender = '".$gender."', locale = '".$locale."', picture = '".$picture."', gpluslink = '".$link."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}
}
?>
