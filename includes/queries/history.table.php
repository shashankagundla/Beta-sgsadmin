<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../init.php" );
include( "../dt/DataTables.php" );

// Alias Editor classes so they are easy to use
use
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'admin_jobs' )
    ->fields(
        Field::inst( 'admin_jobs.sgs_num' ),
        Field::inst( 'admin_jobs.site_name' ),
        Field::inst( 'admin_jobs.site_num' ),
        Field::inst( 'admin_jobs.job_type' ),
        Field::inst( 'admin_jobs.overall_status' ),
        Field::inst( 'admin_jobs.district' ),
        Field::inst( 'admin_jobs.closeout_missing' ),
        Field::inst( 'admin_jobs.inspection_missing' ),
        Field::inst( 'admin_jobs.report_status' ),
        Field::inst( 'admin_jobs.closeout_status' ),
        Field::inst( 'admin_jobs.inspection_status' ),
        Field::inst( 'admin_jobs.status_notes' ),
        Field::inst( 'admin_jobs.atc_origin' ),
        Field::inst( 'admin_jobs.client_contact_email' ),
        Field::inst( 'admin_jobs.contractor_contact_email' ),
        Field::inst( 'admin_jobs.updated' ),
        Field::inst( 'admin_jobs.updated_by' ),
        Field::inst( 'client.display_name' ),
        Field::inst( 'contractor.display_name' ),
        Field::inst( 'crew.display_name' ),
        Field::inst( 'assigned.display_name' ),
        Field::inst( 'admin_jobs.date_due' ),
        Field::inst( 'admin_jobs.wo_num' ),
        Field::inst( 'admin_jobs.jde_num' ),
        Field::inst( 'admin_jobs.po_num' ),
        Field::inst( 'admin_jobs.po_line' ),
        Field::inst( 'admin_jobs.budget' ),
        Field::inst( 'admin_jobs.latitude' ),
        Field::inst( 'admin_jobs.longitude' ),
        Field::inst( 'admin_jobs.state' ),
        Field::inst( 'admin_jobs.city' ),
        Field::inst( 'admin_jobs.county' ),
        Field::inst( 'admin_jobs.tower_type' ),
        Field::inst( 'admin_jobs.tower_height' ),
        Field::inst( 'admin_jobs.tower_man' ),
        Field::inst( 'admin_jobs.tower_owner' )
    )
    ->leftJoin( 'wp_8kndgu_users as client',   'admin_jobs.client_contact_email',   '=', 'client.ID' )
    ->leftJoin( 'wp_8kndgu_users as contractor', 'admin_jobs.contractor_contact_email', '=', 'contractor.ID' )
    ->leftJoin( 'employee as crew', 'admin_jobs.crew_1', '=', 'crew.id' )
    ->leftJoin( 'employee as assigned', 'admin_jobs.eng_assigned', '=', 'assigned.id' )
    ->where( 'overall_status', 'Pending', '!=' )
    ->where( 'overall_status', 'PO', '!=' )
    ->where( 'overall_status', 'Go', '!=' )
    ->where( 'overall_status', 'FWC', '!=' )
    ->where( 'overall_status', 'BILL', '!=' )
    ->process( $_POST )
    ->json();
