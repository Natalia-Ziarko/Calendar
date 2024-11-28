<?php
require_once dirname(__FILE__) . '/../config.php';
require_once '../app/show_event.php';

const EVENT_ID = 2;
const COUNTRY_ID = 1;
const SPORT_ID = 1;
const EVENT_TYPE_ID = 1;
const VENUE_ID = 1;

function echo_test_message($test, $function_name) {
    echo '<br><br>' . $test . ' <b>' . $function_name . '()</b> [' . date("Y-m-d g:i:s:u") . ']<br><br>&emsp;';
}

function show_last_event_id() {
    echo_test_message('Start', __FUNCTION__);
    
    $last_event_id = get_last_event_id();
    print($last_event_id);
    
    echo_test_message('End', __FUNCTION__);
}

function show_event_teams_details($EVENT_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $event_teams_details = get_event_teams_details($EVENT_ID);
    print_r($event_teams_details);
    
    echo_test_message('End', __FUNCTION__);
}

function show_country_name($COUNTRY_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $country_name = get_country_name($COUNTRY_ID);
    print($country_name);
    
    echo_test_message('End', __FUNCTION__);
}

function show_sport_name($SPORT_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $sport_name = get_sport_name($SPORT_ID);
    print($sport_name);
    
    echo_test_message('End', __FUNCTION__);
}

function show_event_type_name($EVENT_TYPE_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $event_type_name = get_event_type_name($EVENT_TYPE_ID);
    print($event_type_name);
    
    echo_test_message('End', __FUNCTION__);
}

function show_venue_name($VENUE_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $venue_name = get_venue_name($VENUE_ID);
    print($venue_name);
    
    echo_test_message('End', __FUNCTION__);
}

function show_last_event_details() {
    echo_test_message('Start', __FUNCTION__);
    
    $last_event_details = get_event_details();
    print_r($last_event_details);
    
    echo_test_message('End', __FUNCTION__);
}

function show_spec_event_details($EVENT_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $spec_event_details = get_event_details($EVENT_ID);
    print_r($spec_event_details);
    
    echo_test_message('End', __FUNCTION__);
}

function test_all() {
    show_last_event_id();
    show_event_teams_details(EVENT_ID);
    show_country_name(COUNTRY_ID);
    show_sport_name(SPORT_ID);
    show_event_type_name(EVENT_TYPE_ID);
    show_sport_name(VENUE_ID);
    show_last_event_details();
    show_spec_event_details(EVENT_ID);
}



test_all();