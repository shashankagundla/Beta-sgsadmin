<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
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
        Field::inst( 'admin_jobs.contractor_contact_email' )
    )
    ->where( 'overall_status', 'Paid', '!=' )
    ->where( 'overall_status', 'Pending', '!=' )
    ->where( 'overall_status', 'Cancel', '!=' )
    ->where( 'job_type', 'CON - Mods', '!=' )
    ->where( 'job_type', 'CON - Maint', '!=' )
    ->where( 'job_type', 'Residential', '!=' )
    ->where( 'job_type', 'Structural', '!=' )
    ->where( 'job_type', 'Rigging', '!=' )
    ->where( 'job_type', 'F Mapping', '!=' )
    ->where( 'job_type', 'T Mapping', '!=' )
    ->where( 'job_type', 'Mapping', '!=' )
    ->process( $_POST )
    ->json();