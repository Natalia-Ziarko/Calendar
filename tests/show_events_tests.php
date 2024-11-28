<?php
require_once dirname(__FILE__) . '/../config.php';
require_once '../app/show_all_events.php';
require_once 'config_tests.php';

function show_all_events($sport_id = null) {
    echo_test_message('Start', __FUNCTION__);
    
    $events_list = get_all_events_details($sport_id);
    print_r($events_list);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
}

function test_all() {
    show_all_events();
    show_all_events(FOOTBALL_SPORT_ID);
    show_all_events(ICE_HOCKEY_SPORT_ID);
}



test_all();