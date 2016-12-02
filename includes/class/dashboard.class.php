<?php
session_start();
require_once("mysql.class.php");


class Dashboard
{
    private $jobTable = 'admin_jobs';
    private $revTable = 'admin_revisions_current';
    private $empTable = 'employee';

    public function dashATC(){
        /*
         * Dash Totals
         */
        $queryTotals = "SELECT overall_status, COUNT(id) AS num FROM `admin_jobs` WHERE (job_type = 'TIA' || job_type = 'SI') GROUP BY overall_status";
        $totals = $this->specialQuery($queryTotals);
        $result['poTotal'] = $totals[6][1];
        $result['goTotal'] = $totals[3][1];
        $result['fwcTotal'] = $totals[2][1];
        /*
         *FWC Column
         */
        //columns needed for this column
        unset($select);
        $select[] = 'overall_status_date';
        $select[] = 'tower_type';
        $select[] = 'fname';
        $select[] = 'lname';

        /*
         * FWC Table
         */

        //build where
        $where = 'overall_status = "FWC" AND report_status = "-" AND inspection_status = "-" AND 
                (job_type = "TIA" OR job_type = "SI") ORDER BY overall_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.overall_status_id = employee.id';
        //build query
        $result['fwc'] = $this->runQuery($where,$select,$join);

        /*
         * Report Status Table
         */
        //build where
        $where = 'overall_status = "FWC" AND report_status = "-" AND inspection_status != "-" AND 
            (job_type = "TIA" OR job_type = "SI") ORDER BY overall_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.overall_status_id = employee.id';
        //build query
        $result['reportNotStarted'] = $this->runQuery($where,$select,$join);


        /*
         * Reports in progress column
         */
        //columns needed for these queries
        unset($select);
        $select[] = 'report_status';
        $select[] = 'report_status_date';
        $select[] = 'fname';
        $select[] = 'lname';
        $select[] = 'tower_type';

        /*
         * Report Status Table
         */
        //build where
        $where = '(report_status = "Writing Report") AND (job_type = "TIA" OR job_type = "SI") AND (overall_status = "FWC") ORDER BY report_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.report_status_id = employee.id';
        //build query
        $result['reportWritten'] = $this->runQuery($where,$select,$join);

        /*
         * Report Review Table
         */
        //build where
        //columns needed for these queries
        unset($select);
        $select[] = 'report_status';
        $select[] = 'report_status_date';
        $select[] = 'tower_type';
        $where = '(report_status = "Initial Review" OR report_status = "Final Review" OR report_status = "Reviewing") AND (job_type = "TIA" OR job_type = "SI") ORDER BY report_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result['reportReview'] = $this->runQuery($where,$select,$join);

        /*
         * Report Started Table
         */
        //build where
        $where = '(report_status = "Report Started") AND (job_type = "TIA" OR job_type = "SI") AND (overall_status = "FWC") ORDER BY report_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result['reportStarted'] = $this->runQuery($where,$select,$join);

        /*
        * Reports Complete Column
        */
        //columns needed for these queries
        unset($select);
        $select[] = 'state';
        $select[] = 'site_num';
        $select[] = 'tower_type';

        /*
         * Ready for Seal Table
         */
        //build where
        $where = '(report_status = "Ready for Seal") AND (job_type = "TIA" OR job_type = "SI") ORDER BY job_type ASC';
        //build query
        $result['sealReady'] = $this->runQuery($where,$select);

        /*
         * Sealed in Box Table
         */
        //build where
        $where = '(report_status = "Initial Review" OR report_status = "Final Review" OR report_status = "Reviewing") AND (job_type = "TIA" OR job_type = "SI") ORDER BY job_type ASC';
        //build query
        $result['sealed'] = $this->runQuery($where,$select);


        return $result;

    }

    public function dashInspections(){
        /*
         * Dash Totals
         */
        $queryTotals = "SELECT overall_status, COUNT(id) AS num FROM `admin_jobs` WHERE (job_type = 'MI' || job_type = 'Legacy MI' || job_type = 'CWI' || job_type = 'NDE' || job_type = 'Pull Test' || job_type = 'Foundation') GROUP BY overall_status";
        $totals = $this->specialQuery($queryTotals);
        $result['poTotal'] = $totals[6][1];
        $result['goTotal'] = $totals[3][1];
        $result['fwcTotal'] = $totals[2][1];

        /*
         * Closeouts Column
         */
        //columns needed for this query
        $select[] = 'closeout_status';
        $select[] = 'closeout_status_date';
        $select[] = 'closeout_missing';

        /*
         * Received Table
         */
        //build where
        $where = 'closeout_status = "Received" ORDER BY closeout_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result['closeoutReceived'] = $this->runQuery($where,$select,$join);

        /*
         * In Review Table
         */
        unset($select);
        $select[] = 'closeout_status';
        $select[] = 'closeout_missing';
        $select[] = 'fname';
        $select[] = 'lname';
        //build where
        $where = '(closeout_status = "Reviewing" OR closeout_status = "Training Review") ORDER BY closeout_status_date DESC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.closeout_status_id = employee.id';
        //build query
        $result['closeoutReview'] = $this->runQuery($where,$select,$join);

        /*
         * Punch column
         */
        //columns needed for these queries
        unset($select);
        $select[] = 'inspection_status';
        $select[] = 'inspection_missing';
        /*
         * Received Table
         */
        //build where
        $where = 'inspection_status = "Received" ORDER BY inspection_status_date';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result['punchReceived'] = $this->runQuery($where,$select,$join);

        /*
         * In Review Table
         */
        //columns needed for this query
        unset($select);
        $select[] = 'inspection_status';
        $select[] = 'inspection_missing';
        $select[] = 'fname';
        $select[] = 'lname';
        //build where
        $where = 'inspection_status = "Reviewing" OR inspection_status = "Training Review" ORDER BY inspection_status_date DESC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.inspection_status_id = employee.id';
        //build query
        $result['punchReview'] = $this->runQuery($where,$select,$join);

        /*
         * Needs Punch List Table
         */
        //columns needed for this query
        unset($select);
        $select[] = 'overall_status_date';

        //build where
        $where = '(job_type = "MI" OR job_type = "CWI" OR job_type = "Legacy MI") AND (inspection_status = "-" AND overall_status = "FWC") ORDER BY overall_status_date ASC';
        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';
        //build query
        $result['needsPunch'] = $this->runQuery($where,$select,$join);


        /*
        * Reports Column
        */
        //columns needed for these queries
        unset($select);
        $select[] = 'closeout_status_date';
        $select[] = 'inspection_status_date';
        $select[] = 'report_status';
        $select[] = 'report_level';
        $select[] = 'fname';
        $select[] = 'lname';


        /*
        * Reports Being Written
        */
        //build where
        $where = '(report_status = "Writing Report") AND (job_type = "MI" OR job_type = "Legacy MI" OR job_type = "CWI" OR job_type = "NDE") ORDER BY CASE WHEN closeout_status_date > inspection_status_date THEN closeout_status_date ELSE inspection_status_date END';

        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_revisions_current.report_status_id = employee.id';

        //build query
        $result['reportWritten'] = $this->runQuery($where,$select,$join);

        /*
        * Closeout & Punch Approved Table
        */
        //columns needed for these queries
        unset($select);
        $select[] = 'closeout_status_date';
        $select[] = 'inspection_status_date';
        $select[] = 'report_status';
        $select[] = 'report_level';
        //build where
        $where = '(inspection_status = "Approved" AND closeout_status = "Approved" AND report_status != "Sealed in Box" AND report_status != "Writing Report" AND report_status != "Ready for Seal" AND overall_status = "FWC") ORDER BY CASE WHEN closeout_status_date > inspection_status_date THEN closeout_status_date ELSE inspection_status_date END';

        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';

        //build query
        $result['approved'] = $this->runQuery($where,$select,$join);

        /*
         * Ready for Seal Table
         */
        //columns needed for these queries
        unset($select);
        $select[] = 'state';
        $select[] = 'site_num';

        //build where
        $where = '(report_status = "Ready for Seal") AND (job_type = "MI" OR job_type = "Legacy MI" OR job_type = "CWI" OR job_type = "NDE") ORDER BY CASE WHEN closeout_status_date > inspection_status_date THEN closeout_status_date ELSE inspection_status_date END';

        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id';

        //build query
        $result['sealReady'] = $this->runQuery($where,$select,$join);

        /*
         * Sealed in Box Table
         */
        //build where
        $where = '(report_status = "Sealed in Box") AND (overall_status != "Pending" AND overall_status != "Paid" AND overall_status != "BILL" AND overall_status != "Cancel" AND (job_type = "MI" || job_type = "Legacy MI" || job_type = "CWI" || job_type = "NDE" || job_type = "Pull Test" || job_type = "Foundation")) ORDER BY job_type ASC';

        //build query
        $result['sealed'] = $this->runQuery($where,$select);

        return $result;

    }

    public function dashEngineering(){
        /*
         * Dash Totals
         */
        $queryTotals = "SELECT overall_status, COUNT(id) AS num FROM `admin_jobs` WHERE (job_type = \"Premod\" OR job_type = \"Rigging\" OR job_type = \"Structural\" OR job_type = \"T Mapping\" OR job_type = \"F Mapping\" OR job_type = \"Residential\") GROUP BY overall_status";
        $totals = $this->specialQuery($queryTotals);
        $result['poTotal'] = $totals[6][1];
        $result['goTotal'] = $totals[3][1];
        $result['fwcTotal'] = $totals[2][1];

        /*
         * Go Column
         */
        //columns needed for this query
        $select[] = 'fname';
        $select[] = 'lname';
        $select[] = 'overall_status_date';

        //build where
        $where = 'overall_status = "Go" AND (job_type = "Premod" OR job_type = "Rigging" OR job_type = "Structural" OR 
        job_type = "T Mapping" OR job_type = "F Mapping" OR job_type = "Residential") ORDER BY overall_status_date ASC';

        //add join
        $join = ' LEFT JOIN ' .$this->revTable . ' ON admin_jobs.id = admin_revisions_current.admin_id LEFT JOIN ' .$this->empTable . ' ON admin_jobs.crew_1 = employee.id';

        //build query
        $result['go'] = $this->runQuery($where,$select,$join);

        /*
         * FWC column
         */
        //columns needed for these queries
        unset($select);
        $select[] = 'fname';
        $select[] = 'lname';
        $select[] = 'date_due';

        //build where
        $where = 'overall_status = "FWC" AND report_status = "-" AND (job_type = "Premod" OR job_type = "Rigging" OR 
        job_type = "Structural" OR job_type = "T Mapping" OR job_type = "F Mapping" OR job_type = "Residential") 
        ORDER BY date_due ASC';
        $join = ' LEFT JOIN ' .$this->empTable . ' ON admin_jobs.eng_assigned = employee.id';
        //build query
        $result['fwc'] = $this->runQuery($where,$select,$join);


        /*
        * Reports Column
        */
        //columns needed for these queries
        unset($select);
        $select[] = 'date_due';
        $select[] = 'state';
        $select[] = 'site_num';
        $select[] = 'fname';
        $select[] = 'lname';

        /*
        * Reports Being Written
        */
        //build where
        $where = '(report_status = "Writing Report" OR report_status = "Report Started") AND (job_type = "Premod" OR 
        job_type = "Rigging" OR job_type = "Structural" OR job_type = "T Mapping" OR job_type = "F Mapping" OR 
        job_type = "Residential") ORDER BY job_type ASC';

        //add join
        $join = ' LEFT JOIN ' .$this->empTable . ' ON admin_jobs.eng_assigned = employee.id';

        //build query
        $result['reportsWritten'] = $this->runQuery($where,$select,$join);

        /*
         * Reports in Review
         */

        //build where
        $where = '(report_status = "Initial Review" OR report_status = "Final Review") AND (job_type = "Premod" OR 
        job_type = "Rigging" OR job_type = "Structural" OR job_type = "T Mapping" OR job_type = "F Mapping" OR 
        job_type = "Residential") ORDER BY job_type ASC';

        //add join
        $join = ' LEFT JOIN ' .$this->empTable . ' ON admin_jobs.eng_assigned = employee.id';

        //build query
        $result['reportsReview'] = $this->runQuery($where,$select,$join);


        /*
         * Sealed in Box Table
         */
        //build where
        $where = '(report_status = "Sealed in Box") AND (overall_status != "Pending" AND overall_status != "Paid" AND 
        overall_status != "BILL" AND overall_status != "Cancel" AND job_type != "MI" AND job_type != "Legacy MI" AND 
        job_type != "SI" AND job_type != "CWI" AND job_type != "NDE" AND job_type != "Pulltest" AND 
        job_type != "Foundation") ORDER BY job_type ASC';

        //add join
        $join = ' LEFT JOIN ' .$this->empTable . ' ON admin_jobs.eng_assigned = employee.id';

        //build query
        $result['sealed'] = $this->runQuery($where,$select,$join);

        /*
         * Ready for Seal Table
         */
        unset($select);
        $select[] = 'date_due';
        $select[] = 'state';
        $select[] = 'site_num';

        //build where
        $where = '(report_status = "Ready for Seal") ORDER BY job_type ASC';

        //build query
        $result['sealReady'] = $this->runQuery($where,$select,$join);



        return $result;

    }

    private function runQuery($w, $s = null,$j = null){
        //New Mysql Connection
        $db = New MySQL();

        //selects needed for all .... most queries
        $select[] = 'sgs_num';
        $select[] = 'site_name';
        $select[] = 'priority';
        $select[] = 'job_type';

        //merge arrays if select is input
        if ($s){
            $s = array_merge($select,$s);
        }else{
            $s = $select;
        }

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

    private function specialQuery($q){
        //New Mysql Connection
        $db = New MySQL();

        //Run Query
        $result = $db->QueryArray($q);

        $db->Close();

        return $result;
    }

}

?>
