<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection

const SYMBOL_COACH = "C";
const SYMBOL_PLAYER = "P";
const SYMBOL_TEAM = "T";

/**
 * Handle submitted new event form
 */
function process_submitted_form() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'new_event_form') {
        // Extract form data
        $f_event_name = filter_input(INPUT_POST, 'event_name', FILTER_SANITIZE_STRING);
        $f_event_description = filter_input(INPUT_POST, 'event_description', FILTER_SANITIZE_STRING);
        $f_event_type = filter_input(INPUT_POST, 'event_type', FILTER_SANITIZE_STRING);
        $f_event_sport = filter_input(INPUT_POST, 'event_sport', FILTER_SANITIZE_STRING);
        $f_event_venue = filter_input(INPUT_POST, 'event_venue', FILTER_SANITIZE_STRING);
        $f_event_start_date = filter_input(INPUT_POST, 'event_start_date', FILTER_SANITIZE_STRING);
        /*
         * Unused field for the new event form
         * $f_event_end_date = filter_input(INPUT_POST, 'event_end_date', FILTER_SANITIZE_STRING);
         */
        $f_event_team_1 = filter_input(INPUT_POST, 'event_team_1', FILTER_SANITIZE_STRING);
        $f_event_team_2 = filter_input(INPUT_POST, 'event_team_2', FILTER_SANITIZE_STRING);

        // Package the data into an array
        $form_data = [
            'event_name' => $f_event_name,
            'event_description' => $f_event_description,
            'event_type' => $f_event_type,
            'event_sport' => $f_event_sport,
            'event_venue' => $f_event_venue,
            'event_start_date' => $f_event_start_date,
            'event_end_date' => $f_event_end_date,
            'event_team_1' => $f_event_team_1,
            'event_team_2' => $f_event_team_2,
        ];

        // Call the PHP function and pass the form data
        $result = process_new_event_request($form_data);

        // Redirect to main.php with the result message
        header("Location: /calendar/app/new_event_form_view.php?message=" . urlencode($result));

        exit();
    }
}

// Call the process_submitted_form function to process submitted new event form
process_submitted_form();

/**
 * Process a new event request
 *
 * @param array $form_data
 * @return string Returns an add event return message
 */
function process_new_event_request($form_data) {
    // Map form fields to the sec_events column names
    $event_details = [
        'sec_ev_type_id' => $form_data['event_type'],
        'sec_ev_sport_id' => $form_data['event_sport'],
        'sec_ev_name' => $form_data['event_name'],
        'sec_ev_description' => $form_data['event_description'],
        'sec_ev_venue_id' => $form_data['event_venue'],
        'sec_ev_date_start' => $form_data['event_start_date'],
        'sec_ev_date_end' => $form_data['event_end_date']
    ];
    
    // Map form fields to the sec_participants column names
    $event_particip = [
        'sec_pa_participant_id_1' => $form_data['event_team_1'],
        'sec_pa_participant_id_2' => $form_data['event_team_2']
    ];
    
    // Call the PHP function to add the event to the database
    $result = add_event($event_details, $event_particip);

    return $result;
}

/**
 * Add event team to the database
 *
 * @global PDO $db The PDO database connection object
 * @param int $event_id
 * @param int $event_team
 * @return string If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function add_team_to_event($event_id, $event_team) {
    global $db;
    
    try {
        $sql = "INSERT INTO sec_participants (
            sec_pa_event_id, 
            sec_pa_participant_id, 
            sec_pa_participant_type
        ) VALUES (
            :event_id, 
            :event_team, 
            :symbol_team
        )";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'event_id' => $event_id,
            'event_team' => $event_team,
            'symbol_team' => SYMBOL_TEAM
        ]);
    
    } catch (Exception $e) {
        // Rollback the transaction if an error occurs
        $db->rollback();
        
        error_log('Failed to add event participant: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }
}

/**
 * Add event to the database
 *
 * @global PDO $db The PDO database connection object
 * @param array $event_details
 * @param array $event_particip
 * @return string Predefined success message (MSG_IF_DONE) or an error message (MSG_IF_ERROR)
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function add_event($event_details, $event_particip) {
    global $db;
    
    try {
        // Begin the transaction
        $db->beginTransaction();
        
        $sql = "INSERT INTO sec_events (
            sec_ev_type_id, 
            sec_ev_sport_id, 
            sec_ev_name, 
            sec_ev_description, 
            sec_ev_venue_id, 
            sec_ev_date_start, 
            sec_ev_date_end
        ) VALUES (
            :sec_ev_type_id, 
            :sec_ev_sport_id, 
            :sec_ev_name, 
            :sec_ev_description, 
            :sec_ev_venue_id, 
            :sec_ev_date_start, 
            :sec_ev_date_end
        )";

        $stmt = $db->prepare($sql);
        $stmt->execute($event_details);
        
        // Retrieve the ID of the last inserted row
        $event_id = $db->lastInsertId(); 

        if (!$event_id) {
            // Rollback the transaction if no event ID is returned
            $db->rollback();
            
            return MSG_IF_ERROR;   
            
        } else {
            ///Add teams to the event
            add_team_to_event($event_id, $event_particip['sec_pa_participant_id_1']);
            add_team_to_event($event_id, $event_particip['sec_pa_participant_id_2']);
            
            $db->commit();
            
            return MSG_IF_DONE;
        }
    
    } catch (Exception $e) {
        $db->rollback();
        
        error_log('Failed to add a new event: ' . $e->getMessage());
        
        return MSG_IF_ERROR;        
    }
}