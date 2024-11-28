<?php
require_once dirname(__FILE__).'/../config.php'; // Include config.php to access $db connection
require_once '../app/show_event.php';
require_once '../app/show_all_events.php';

// Call the get_all_events_details function and initialize $all_events_details with a result array
$all_events_details = get_all_events_details();

/**
 * Render main page with $all_events_details array
 * 
 * @param array All events details
 */
function render_main_view($all_events_details) {
    include 'main_view.php';
}

// Call the render_main_view function with 
render_main_view($all_events_details);