<?php
session_start();
require_once("mysql.class.php");

class Job {
    public $jobTable = 'admin_jobs';
    public $commentTable = 'admin_comments';

    public function queryJob($sgs){
        $db = New MySQL();
        $sgs = MySQL::SQLValue($sgs);
        $result = $db->QueryArray("SELECT * FROM $this->jobTable WHERE sgs_num = $sgs");
        $db->Close();

        return $result;
    }

    public function queryJobComments($adminID){
        $db = New MySQL();
        $adminID = MySQL::SQLValue($adminID);
        $result = $db->QueryArray("select * from $this->commentTable where admin_id = ".$adminID." ORDER BY date DESC");
        $db->Close();

        return $result;
    }
}

?>