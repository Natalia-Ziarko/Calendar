<?php
require_once dirname(__FILE__) . '/../config.php';
require_once '../app/new_event.php';
require_once 'config_tests.php';

function fill_event_details_array(
        $type_id,
        $sport_id,
        $name,
        $description,
        $venue_id,
        $date_start,
        $date_end
        ) {
    
    $event_details = [
        'sec_ev_type_id' => $type_id,
        'sec_ev_sport_id' => $sport_id,
        'sec_ev_name' => $name,
        'sec_ev_description' => $description,
        'sec_ev_venue_id' => $venue_id,
        'sec_ev_date_start' => $date_start,
        'sec_ev_date_end' => $date_end
    ];

    return $event_details;
}

function fill_event_particip_array($team_1_id, $team_2_id) {
    
    $event_particip = [
        'sec_pa_participant_id_1' => $team_1_id,
        'sec_pa_participant_id_2' => $team_2_id
    ];

    return $event_particip;
}

function test_add_event_all_fields() {
    
    echo_test_message('Start', __FUNCTION__);

    $name = 'Test new event with all fields';
    $description = 'Charity event';
    $date_now = date("Y-m-d g:i:s");
    
    $event_details = fill_event_details_array(
            COMPET_GAME_EVENT_ID,
            FOOTBALL_SPORT_ID,
            $name,
            $description,
            VENUE_ID,
            $date_now,
            $date_now
            );
    
    $event_particip = fill_event_particip_array(TEAM_1_ID, TEAM_2_ID);
    
    $f_new_event_added = add_event($event_details, $event_particip);
    
    print('New event added to the database: ' . $f_new_event_added);
    
    echo_test_message('End', __FUNCTION__);
    print(LINE);
    
}

/* Calling the testing functions - adding a new event*/

test_add_event_all_fields();