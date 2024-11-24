<?php
require_once dirname(__FILE__).'/../config.php';
require_once '../app/show_event.php';
require_once '../app/show_all_events.php';

$last_event_details = get_event_details();

$all_events_details = get_all_events_details();

function render_main_view($last_event_details, $all_events_details) {
    include 'main_view.php';
}

render_main_view($last_event_details, $all_events_details);