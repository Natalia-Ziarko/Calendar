<?php
require_once dirname(__FILE__) . '/../config.php';
require_once '../app/show_event.php';
require_once 'config_tests.php';

function show_last_event_id() {
    echo_test_message('Start', __FUNCTION__);
    
    $last_event_id = get_last_event_id();
    print($last_event_id);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_event_teams_details($EVENT_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $event_teams_details = get_event_teams_details($EVENT_ID);
    print_r($event_teams_details);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_country_name($COUNTRY_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $country_name = get_country_name($COUNTRY_ID);
    print($country_name);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_sport_name($sport_id) {
    echo_test_message('Start', __FUNCTION__);
    
    $sport_name = get_sport_name($sport_id);
    print($sport_name);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_event_type_name($EVENT_TYPE_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $event_type_name = get_event_type_name($EVENT_TYPE_ID);
    print($event_type_name);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_venue_name($VENUE_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $venue_name = get_venue_name($VENUE_ID);
    print($venue_name);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_last_event_details() {
    echo_test_message('Start', __FUNCTION__);
    
    $last_event_details = get_event_details();
    print_r($last_event_details);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function show_spec_event_details($EVENT_ID) {
    echo_test_message('Start', __FUNCTION__);
    
    $spec_event_details = get_event_details($EVENT_ID);
    print_r($spec_event_details);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function test_all() {
    show_last_event_id();
    show_country_name(AT_COUNTRY_ID);
    show_sport_name(FOOTBALL_SPORT_ID);
    show_event_type_name(COMPET_GAME_EVENT_ID);
    show_sport_name(VENUE_ID);
    show_last_event_details();

    show_spec_event_details(TESTING_EVENT_ID);    
    show_event_teams_details(TESTING_EVENT_ID);

    show_spec_event_details(NOT_EXISTING_EVENT_ID);
    show_event_teams_details(NOT_EXISTING_EVENT_ID);

    show_spec_event_details(get_last_event_id());
    show_event_teams_details(get_last_event_id());
}



test_all();