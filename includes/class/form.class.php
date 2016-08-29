<?php
session_start();
require_once("mysql.class.php");

if(isset($_POST['submit']))
{
    $form = New Form;
    $form->submit();
}

class Form
{

    /**
     * For testing purposes
     * @param $array
     */
    private function displayArray($array)
    {
        echo '<pre>' . var_export($array, true) . '</pre>';
    }

    /**
     * For testing purposes
     * @param $table
     * @param $array
     */
    private function displayStatements($table, $array)
    {
        $db = New MySQL();

        echo "<pre>" . "\n";
        echo MySQL::BuildSQLDelete($table, $array) . "\n<br />\n";
        echo MySQL::BuildSQLInsert($table, $array) . "\n<br />\n";
        echo MySQL::BuildSQLSelect($table, $array) . "\n<br />\n";
        echo MySQL::BuildSQLUpdate($table, $array, $array) . "\n<br />\n";
        echo MySQL::BuildSQLWhereClause($array) . "\n<br />\n";
        echo "</pre>" . "\n";
    }


    /**
     * Get all select files and values from the select_fields table
     * @return object|Records
     */
    public function allSelectFields()
    {
        $db = New MySQL();
        $result = $db->Query("SELECT * FROM select_fields");
        if (!$result) {
            $this->dbError($db->Kill());
        }
        $result = $db->RecordsArray();
        $db->Close();
        return $result;
    }

    /**
     * Get a client list from the wordpress tables
     *
     *TODO:Convert this DB
     */
    public function selectClients()
    {
        $db = New MySQL();
        $result = $db->Query("
        SELECT u.ID, u.display_name FROM `wp_8kndgu_users` u
        INNER JOIN `wp_8kndgu_usermeta` m ON m.user_id = u.ID
        WHERE m.meta_key = 'wp_8kndgu_capabilities'
        AND m.meta_value LIKE '%client%'
        ORDER BY u.display_name
        ");
        if (!$result) {
            $this->dbError($db->Kill());
        }
        $result = $db->RecordsArray();
        $db->Close();
        return $result;
    }

    /**
     * Get a contractor list from the wordpress tables
     *
     *TODO:Convert this DB
     */
    public function selectContractors()
    {
        $db = New MySQL();
        $result = $db->Query("
        SELECT u.ID, u.display_name FROM `wp_8kndgu_users` u
        INNER JOIN `wp_8kndgu_usermeta` m ON m.user_id = u.ID
        WHERE m.meta_key = 'wp_8kndgu_capabilities'
        AND m.meta_value LIKE '%contractor%'
        ORDER BY u.display_name
        ");
        if (!$result) {
            $this->dbError($db->Kill());
        }
        $result = $db->RecordsArray();
        $db->Close();

        return $result;
    }

    /**
     * Get selectData out of array, array in an array
     * @return array
     */
    public function selectArray()
    {
        $selectTable = $this->allSelectFields();
        $selectArray = [];
        foreach ($selectTable as $select) {
            $selectArray[] = $select->field;
            $selectArray[] = $select->selectID;
            $selectArray[] = $select->selectField;
        }
        return $selectArray;
    }

    /**
     *After submit, determine what function add job goes to
     */
    public function submit()
    {
        if ($_POST['submit'] === 'addJob') {
            $this->addJob();
        }

        if ($_POST['submit'] === 'addBid') {
            $this->addBid();
        }
    }


    /**
     *Add job to table admin_jobs
     */
    private function addJob()
    {
        //new-up SQL connection
        $db = New MySQL();

        //prep _POST for SQL insert
        $insertPrepared = $this->adminJobPrep();

        //insert row in DB
        $result = $db->InsertRow('admin_jobs', $insertPrepared);

        //check status of row insert
        if (!$result) {
            //notify end-user of failure
            $_SESSION['notify']['message'] = 'Your Job Was Not Created! <br> Database Error: ';
            $_SESSION['notify']['message'] .= $db->Kill();
            $_SESSION['notify']['type'] = 'danger';
            //redirect back & exit
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        //create job comment
        if ($_POST['comment']){
            $this->addComment($result, 'job');
        }
        //notify end-user fo success
        $_SESSION['notify']['message'] = 'SGS#: '.$_POST['sgs']. ' Was Successfully Added!';
        $_SESSION['notify']['type'] = 'success';

        $db->Close();

        //redirect back
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     *Prep data to be inserted into admin_jobs
     */
    private function adminJobPrep()
    {

        //Prep for Insert
        $insert['sgs_num'] = MySQL::SQLValue(trim($_POST['sgs']));
        $insert['revisit_num'] = MySQL::SQLValue(trim($_POST['visit']));
        $insert['site_num'] = MySQL::SQLValue(trim($_POST['siteNumber']));
        $insert['wo_num'] = MySQL::SQLValue(trim($_POST['wo']));
        $insert['po_num'] = MySQL::SQLValue(trim($_POST['po']));
        $insert['po_line'] = MySQL::SQLValue(trim($_POST['poLine']));
        $insert['site_name'] = MySQL::SQLValue(trim($_POST['siteName']));
        $insert['budget'] = MySQL::SQLValue(trim($_POST['budget']));
        $insert['jde_num'] = MySQL::SQLValue(trim($_POST['jde']));
        $insert['job_type'] = MySQL::SQLValue(trim($_POST['jobType']));
        $insert['client_company'] = MySQL::SQLValue(trim($_POST['clientCompany']));
        $insert['client_contact_email'] = MySQL::SQLValue(trim($_POST['clientContact']));
        $insert['district'] = MySQL::SQLValue(trim($_POST['district']));
        $insert['contractor_contact_email'] = MySQL::SQLValue(trim($_POST['contractor']));
        $insert['latitude'] = MySQL::SQLValue(trim($_POST['latitude']));
        $insert['longitude'] = MySQL::SQLValue(trim($_POST['longitude']));
        $insert['state'] = MySQL::SQLValue(trim($_POST['state']));
        $insert['city'] = MySQL::SQLValue(trim($_POST['city']));
        $insert['tower_height'] = MySQL::SQLValue(trim($_POST['towerHeight']));
        $insert['tower_man'] = MySQL::SQLValue(trim($_POST['towerManufacturer']));
        $insert['tower_owner'] = MySQL::SQLValue(trim($_POST['towerOwner']));
        $insert['overall_status'] = MySQL::SQLValue(trim($_POST['overallStatus']));
        $insert['field_status'] = MySQL::SQLValue("-");
        $insert['crew_1'] = MySQL::SQLValue("-");
        $insert['closeout_status'] = MySQL::SQLValue("-");
        $insert['inspection_status'] = MySQL::SQLValue("-");
        $insert['report_status'] = MySQL::SQLValue("-");
        $insert['wp_id'] = MySQL::SQLValue(NULL);
        $insert['priority'] = MySQL::SQLValue(0);
        $insert['date_eos'] = MySQL::SQLValue(NULL);
        $insert['report_level'] = MySQL::SQLValue(NULL);
        $insert['soe'] = MySQL::SQLValue(0);
        $insert['eng_assigned'] = MySQL::SQLValue(NULL);
        $insert['date_due'] = MySQL::SQLValue($_POST['dateDue']);

        //These fields should be null when a job is being added
        $insert['closeout_missing'] = MySQL::SQLValue(NULL);
        $insert['inspection_missing'] = MySQL::SQLValue(NULL);
        $insert['status_notes'] = MySQL::SQLValue(NULL);
        $insert['atc_origin'] = MySQL::SQLValue("-");

        /*
         * Todo: Remove these columns from job table
         */
        $insert['client_contact'] = MySQL::SQLValue(NULL);
        $insert['crew_2'] = MySQL::SQLValue(NULL);
        $insert['report_type'] = MySQL::SQLValue(NULL);
        $insert['box_link'] = MySQL::SQLValue(NULL);
        $insert['status_update_history'] = MySQL::SQLValue(NULL);

        /*
         * Todo: Need to create a better date table for jobs
         * Then remove this
         */
        $insert['go_date'] = MySQL::SQLValue(NULL);
        $insert['waiting_time_history'] = MySQL::SQLValue(NULL);

        /*
         * Add created rows, and updated rows
         */
        $insert = $this->addCreated($insert);

        return $insert;

    }

    private function addBid(){
        $db = New MySQL();

        //create new bid ID
        $newBidID = $this->nextBidNum();

        //prep _POST for SQL insert
        $insertPrepared = $this->addBidPrep($newBidID);

        //insert row in DB
        $result = $db->InsertRow('bids', $insertPrepared);

        //check result of row insert
        if (!$result) {

            //notify user
            $_SESSION['notify']['message'] = 'Your Bid Was Not Created! <br> Database Error: ';
            $_SESSION['notify']['message'] .= $db->Kill();
            $_SESSION['notify']['type'] = 'danger';

            //redirect back & exit
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        //create bid comment
        if ($_POST['comment']){
            $this->addComment($result,'bid');
        }
        //notify end-user
        $_SESSION['notify']['message'] = 'Bid ID: B16-'.$newBidID.' was successfully added!';
        $_SESSION['notify']['type'] = 'success';

        $db->Close();


        //redirect back
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }

    private function addBidPrep($newBidID)
    {
        //Prep for Insert
        $insert['bid_id'] = MySQL::SQLValue($newBidID);
        $insert['bid_yr'] = MySQL::SQLValue(16);
        $insert['bid_appid'] = MySQL::SQLValue(trim($_POST['appID']));
        $insert['bid_status'] = MySQL::SQLValue(trim($_POST['bidStatus']));
        $insert['budget'] = MySQL::SQLValue(trim($_POST['budget']));
        $insert['site_name'] = MySQL::SQLValue(trim($_POST['siteName']));
        $insert['site_num'] = MySQL::SQLValue(trim($_POST['siteNumber']));
        $insert['state'] = MySQL::SQLValue(trim($_POST['state']));
        $insert['city'] = MySQL::SQLValue(trim($_POST['city']));
        $insert['job_type'] = MySQL::SQLValue(trim($_POST['jobType']));
        $insert['client'] = MySQL::SQLValue(trim($_POST['clientContact']));
        $insert['tower_type'] = MySQL::SQLValue(trim($_POST['towerType']));
        $insert['tower_height'] = MySQL::SQLValue(trim($_POST['towerHeight']));
        $insert['tower_owner'] = MySQL::SQLValue(trim($_POST['towerOwner']));
        $insert['tower_man'] = MySQL::SQLValue(trim($_POST['towerManufacturer']));
        $insert['district'] = MySQL::SQLValue(trim($_POST['district']));
        $insert['latitude'] = MySQL::SQLValue(trim($_POST['latitude']));
        $insert['longitude'] = MySQL::SQLValue(trim($_POST['longitude']));
        $insert['drawing_num'] = MySQL::SQLValue(trim($_POST['drawing']));
        $insert = $this->addCreated($insert);

        return $insert;

    }

    public function nextBidNum()
    {
        $db = New MySQL();
        $bid_id = $db->QuerySingleValue("SELECT bid_id FROM bids ORDER BY bid_id DESC");
        $bid_id = sprintf('%04u', ($bid_id + 1));

        $db->Close();


        return $bid_id;

    }

    public function nextSGSNum()
    {
        $db = New MySQL();
        $nextSGSNum = $db->QuerySingleValue("SELECT sgs_num FROM admin_jobs ORDER BY sgs_num DESC");
        $nextSGSNum = floatval(($nextSGSNum + 1));

        $db->Close();


        return $nextSGSNum;

    }

    private function addCreated($insert){
        $insert['created'] = MySQL::SQLValue(date("Y-m-d H:i:s"));
        $insert['created_by'] = MySQL::SQLValue($_SESSION['user']['id']);
        $insert = $this->addUpdated($insert);
        return $insert;
    }

    private function addUpdated($insert){
        $insert['updated'] = MySQL::SQLValue(date("Y-m-d H:i:s"));
        $insert['updated_by'] = MySQL::SQLValue($_SESSION['user']['id']);
        return $insert;
    }

    /*
     *TODO: Update the admin_comments table to have user_id when we go live, also add columns for addCreated, addUpdated
     *
     * This function will create a new comment for a job or bid
     */
    private function addComment($id,$type){
        //create db connection
        $db = New MySQL();

        //clear $insert array so it can be reused
        unset($insert);

        //Add Job Comment
        if ($type === 'job'){
            $insert['admin_id'] = MySQL::SQLValue($id);
            $insert['user'] = MySQL::SQLValue($_SESSION['user']['fname'] . ' ' . $_SESSION['user']['lname']);
            $insert['date'] = MySQL::SQLValue(date("Y-m-d H:i:s"));
            $insert['comment'] = MySQL::SQLValue($_POST['comment']);
            $insert = $this->addCreated($insert);
            $result = $db->InsertRow('admin_comments', $insert);
            if (!$result) {
                $_SESSION['notify']['message'] = 'Your job was added. However, your comment was not added.  <br> Database Error: ';
                $_SESSION['notify']['message'] .= $db->Kill();
                $_SESSION['notify']['type'] = 'danger';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        //Add Bid Comment
        if ($type === 'bid'){
            $insert['bidID'] = MySQL::SQLValue($id);
            $insert['comment'] = MySQL::SQLValue($_POST['comment']);
            $insert = $this->addCreated($insert);
            $result = $db->InsertRow('bid_comments', $insert);
            if (!$result) {
                $_SESSION['notify']['message'] = 'Your bid was added. However, your comment was not added.  <br> Database Error: ';
                $_SESSION['notify']['message'] .= $db->Kill();
                $_SESSION['notify']['type'] = 'danger';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

        return;
    }

    /*
     * TODO: Fix General dbError
     */

    private function dbError($message){
        $_SESSION['notify']['message'] = $message;
        $_SESSION['notify']['type'] = 'danger';
        header('Location: /');
        exit;
    }

}

?>
