<?php
session_start();
require_once("mysql.class.php");


class Schedule
{
    private $jobTable = 'admin_jobs';
    private $revTable = 'admin_revisions_current';

    public function mainTable(){
        /*
         * Main Schedule Table
         */
        //build where
        $where = 'overall_status = "GO" AND job_type != "TIA" ORDER BY crew_1 ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result = $this->runQuery($where);

        return $result;

    }

    private function runQuery($w, $s = null,$j = null){
        //New Mysql Connection
        $db = New MySQL();

        //selects needed for all .... most queries
        $select[] = 'id';
        $select[] = 'sgs_num';
        $select[] = 'site_name';
        $select[] = 'site_num';
        $select[] = 'job_type';
        $select[] = 'overall_status';
        $select[] = 'field_status';
        $select[] = 'state';
        $select[] = 'latitude';
        $select[] = 'longitude';
        $select[] = 'date_eos';
        $select[] = 'crew_1';
        $select[] = 'priority';
        $s = $select;

        //build select
        $s = $db->BuildSQLColumns($s);

        if ($j){
            //build query string
            $q = 'SELECT ' . $s . ' FROM ' . $this->jobTable . $j . ' WHERE ' . $w;
        }else{
            //build query string
            $q = 'SELECT ' . $s . ' FROM ' . $this->jobTable . ' WHERE ' . $w;
        }

        //Run Query
        $result = $db->QueryArray($q);

        $db->Close();

        return $result;
    }

}

?>
