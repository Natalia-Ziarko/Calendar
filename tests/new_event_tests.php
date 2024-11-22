<?php
require_once dirname(__FILE__) . '/../config.php';
require_once '../app/new_event.php';

//global $type_id, $sport_id, $name, $description, $venue_id, $date_start, $date_end, $team_1_id, $team_2_id;

function fill_event_details_array($type_id, $sport_id, $name, $description, $venue_id, $date_start, $date_end) {
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

function test_all_fields() {
    echo 'Start test_all_fields() [' . date("Y-m-d g:i:s:u") . ']<br><br>&emsp;';
    
    $type_id = 1;
    $sport_id = 1;
    $name = 'Test event with all fields';
    $description = 'Charity event';
    $venue_id = 1;
    $date_start = date("Y-m-d g:i:s");
    $date_end = date("Y-m-d g:i:s");
    $team_1_id = 1;
    $team_2_id = 2;
    
    $event_details = fill_event_details_array($type_id, $sport_id, $name, $description, $venue_id, $date_start, $date_end);
    
    $event_particip = fill_event_particip_array($team_1_id, $team_2_id);
    
    add_event($event_details, $event_particip);
    
    echo '<br><br>End test_all_fields() [' . date("Y-m-d g:i:s:u") . ']<br><br>';
}

/* Calling the testing functions */

test_all_fields();