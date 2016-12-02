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
Editor::inst( $db, 'employee' )
    ->fields(
        Field::inst( 'employee.display_name' ),
        Field::inst( 'employee.color' )
    )
    ->where( 'climber', '0', '!=' )
    ->process( $_POST )
    ->json();
