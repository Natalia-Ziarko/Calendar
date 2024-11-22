<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection

// Initialize the database connection
Database::init($conf);  // Initialize with the configuration
$db = Database::connectDB();  // Establish the database connection

// Check if $db is null
if ($db === null) {
    die("Database connection failed");
}

const SYMBOL_COACH = "C";
const SYMBOL_PLAYER = "P";
const SYMBOL_TEAM = "T";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_data = $_POST['form_data']; // Access the form data

    /* Form validation */
    
    // Not null attributes
    $required_fields = [
        'event_type', 
        'event_sport', 
        'event_name', 
        'event_venue', 
        'event_start_date', 
        'event_team_1', 
        'event_team_2'
    ];
    
    $missing_fields = [];
    
    // Check for missing fields
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            $missing_fields[] = $field;
        }
    }
    
    // Return an error with the missing fields and exit
    if (!empty($missing_fields)) {
        http_response_code(400); // Set HTTP response code to 400 (Bad Request)
        
        echo 'The following fields were not provided: ' . implode(', ', $missing_fields);
        
        exit;
    }    
    
    /* Map form fields to the database column names */
    
    $event_details = [
        'sec_ev_type_id' => $form_data['event_type'],
        'sec_ev_sport_id' => $form_data['event_sport'],
        'sec_ev_name' => $form_data['event_name'],
        'sec_ev_description' => $form_data['event_description'],
        'sec_ev_venue_id' => $form_data['event_venue'],
        'sec_ev_date_start' => $form_data['event_start_date'],
        'sec_ev_date_end' => $form_data['event_end_date']
    ];
    
    $event_particip = [
        'sec_pa_participant_id_1' => $form_data['event_team_1'],
        'sec_pa_participant_id_2' => $form_data['event_team_2']
    ];
    
    /* Call the function to add the event to the database */
  
    add_event($event_details, $event_particip);
}

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
        $db->rollback(); // Rollback the transaction if an error occurs
        
        echo 'Failed to add event participant ' . $e->getMessage();
    }
}

function add_event($event_details, $event_particip) {
    global $db;
    
    try {
        $db->beginTransaction(); // Begin the transaction
        
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

        $event_id = $db->lastInsertId(); // Retrieve the ID of the last inserted row

        if (!$event_id) {
            $db->rollback(); // Rollback the transaction if no event ID is returned
            
            echo 'Failed to add a new event';
            
            return; // Exit after rollback
            
        } else {
            /* Add teams to the event */
            
            add_team_to_event($event_id, $event_particip['sec_pa_participant_id_1']);
            add_team_to_event($event_id, $event_particip['sec_pa_participant_id_2']);
            
            $db->commit();
            
            echo 'Event added successfully';
        }
    
    } catch (Exception $e) {
        $db->rollback();
        
        echo 'Failed to add a new event ' . $e->getMessage();        
    }
}