<?php
require_once dirname(__FILE__).'/../config.php';
require_once '../app/show_event.php';

$last_event_details = get_event_details();

//print('DEBUG $last_event_details:<br>'); // DEBUG
//print_r($last_event_details); // DEBUG

function render_main_view($last_event_details) {
    include 'main_view.php';
}

render_main_view($last_event_details);