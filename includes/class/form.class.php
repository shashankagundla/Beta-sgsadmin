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
    }


    /**
     *Add job to table admin_jobs
     */
    private function addJob()
    {
        //$this->displayArray($_POST);

        $db = New MySQL();

        $insertPrepared = $this->adminJobPrep();
        //insert row in DB
        $result = $db->InsertRow('admin_jobs', $insertPrepared);
        if (!$result) {
            $_SESSION['notify']['message'] = 'Your Job Was Not Created! <br> Database Error: ';
            $_SESSION['notify']['message'] .= $db->Kill();
            $_SESSION['notify']['type'] = 'danger';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $this->addJobComment($result);

        $_SESSION['notify']['message'] = 'SGS#: '.$_POST['sgs']. ' Was Successfully Added!';
        $_SESSION['notify']['type'] = 'success';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     *Prep data to be inserted into admin_jobs
     */
    private function adminJobPrep()
    {

        //Prep for Insert
        $insert['sgs_num'] = MySQL::SQLValue($_POST['sgs']);
        $insert['revisit_num'] = MySQL::SQLValue($_POST['visit']);
        $insert['site_num'] = MySQL::SQLValue($_POST['siteNumber']);
        $insert['wo_num'] = MySQL::SQLValue($_POST['wo']);
        $insert['po_num'] = MySQL::SQLValue($_POST['po']);
        $insert['po_line'] = MySQL::SQLValue($_POST['poLine']);
        $insert['site_name'] = MySQL::SQLValue($_POST['siteName']);
        $insert['budget'] = MySQL::SQLValue($_POST['budget']);
        $insert['jde_num'] = MySQL::SQLValue($_POST['jde']);
        $insert['job_type'] = MySQL::SQLValue($_POST['jobType']);
        $insert['client_company'] = MySQL::SQLValue($_POST['clientCompany']);
        $insert['client_contact_email'] = MySQL::SQLValue($_POST['clientContact']);
        $insert['district'] = MySQL::SQLValue($_POST['district']);
        $insert['contractor_contact_email'] = MySQL::SQLValue($_POST['contractor']);
        $insert['latitude'] = MySQL::SQLValue($_POST['latitude']);
        $insert['longitude'] = MySQL::SQLValue($_POST['longitude']);
        $insert['state'] = MySQL::SQLValue($_POST['state']);
        $insert['city'] = MySQL::SQLValue($_POST['city']);
        $insert['tower_height'] = MySQL::SQLValue($_POST['towerHeight']);
        $insert['tower_man'] = MySQL::SQLValue($_POST['towerManufacturer']);
        $insert['tower_owner'] = MySQL::SQLValue($_POST['towerOwner']);
        $insert['overall_status'] = MySQL::SQLValue($_POST['overallStatus']);
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

    private function getUserID(){

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
     */
    private function addJobComment($adminID){
        $db = New MySQL();

        unset($insert);
        $insert['admin_id'] = MySQL::SQLValue($adminID);
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
