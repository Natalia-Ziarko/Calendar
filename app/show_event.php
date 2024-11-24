<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection

/* Database connection connection */

// Initialize with the configuration
Database::init($conf);

// Establish the database connection
$db = Database::connectDB();

// Check the database connection - if null then die
if ($db === null) {
    die("Database connection failed");
}

/* */

function get_last_event_id() {
    // Refer to the global PDO object
    global $db;
    
    try {
        $sql = "SELECT sec_ev_id FROM sec_events WHERE sec_ev_id = (SELECT MAX(sec_ev_id) FROM sec_events)";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $last_event_id = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($last_event_id === null) {
            echo "No events found.";

            exit;
        }
        
        return $last_event_id['sec_ev_id'];
    
    } catch (Exception $e) {
        echo 'Failed to check last event ID ' . $e->getMessage();
        
        exit;
    }
}

function get_event_teams_details($sec_ev_id) {
    global $db; 
    
    try {
        $sql_sec_teams = "SELECT * FROM sec_teams WHERE sec_te_id IN("
                . "SELECT sec_pa_participant_id FROM sec_participants WHERE sec_pa_event_id = :event_id"
                . ")";     
        $stmt = $db->prepare($sql_sec_teams);
        $stmt->execute(['event_id' => $sec_ev_id]);
        $teams_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Replacing the keys for the frontend
        foreach ($teams_details as $key => $row) {
            if (isset($row['sec_te_short_name'])) {
                $teams_details[$key]['event_team_short_name_' . ($key + 1)] = $row['sec_te_short_name'];
                unset($teams_details[$key]['sec_te_short_name']);
            }
        }
        
        return $teams_details;
    
    } catch (Exception $e) {
        echo 'Failed to get event teams details ' . $e->getMessage();
    }
}

function get_country_name($country_id) {
    global $db;
    
    try {
        $sql_sec_countries = "SELECT * FROM sec_countries WHERE sec_ct_id = :country_id";     
        $stmt = $db->prepare($sql_sec_countries);
        $stmt->execute(['country_id' => $country_id]);
        $country_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $country_details[0]['sec_ct_name'];
    
    } catch (Exception $e) {
        echo 'Failed to get country name ' . $e->getMessage();
    }    
}

function get_sport_name($sport_id) {
    global $db;
    
    try {
        $sql_sec_sports = "SELECT * FROM sec_sports WHERE sec_sp_id = :sport_id";     
        $stmt = $db->prepare($sql_sec_sports);
        $stmt->execute(['sport_id' => $sport_id]);  
        $sport_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $sport_details[0]['sec_sp_name'];
    
    } catch (Exception $e) {
        echo 'Failed to get sport name ' . $e->getMessage();
    }    
}

function get_event_type_name($event_type_id) {
    global $db;
    
    try {
        $sql_sec_event_types = "SELECT * FROM sec_event_types WHERE sec_et_id = :event_type_id";     
        $stmt = $db->prepare($sql_sec_event_types);
        $stmt->execute(['event_type_id' => $event_type_id]);
        $event_type_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $event_type_details[0]['sec_et_name'];
    
    } catch (Exception $e) {
        echo 'Failed to get event type name ' . $e->getMessage();
    }    
}

function get_event_venue_name($event_venue_id) {
    global $db;
    
    try {
        $sql_sec_venues = "SELECT * FROM sec_venues WHERE sec_ve_id = :event_venue_id";     
        $stmt = $db->prepare($sql_sec_venues);
        $stmt->execute(['event_venue_id' => $event_venue_id]);
        $event_venue_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $event_venue_details[0]['sec_ve_name'];
    
    } catch (Exception $e) {
        echo 'Failed to get venue name ' . $e->getMessage();
    }    
}

function get_event_details($event_id = null) {
    global $db;

    $sec_ev_id = $event_id ?? get_last_event_id();
    
    try {
        $sql_sec_events = "SELECT * FROM sec_events WHERE sec_ev_id = :event_id";     
        $stmt = $db->prepare($sql_sec_events);
        $stmt->execute(['event_id' => $sec_ev_id]);
        $event_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Mapping database column names to frontend keys
        $column_mapping = [
            'sec_ev_name' => 'event_name',
            'sec_ev_description' => 'event_description',
            'sec_ev_type_id' => 'event_type_id',
            'sec_ev_sport_id' => 'event_sport_id',
            'sec_ev_date_start' => 'event_start_date',
            'sec_ev_date_end' => 'event_end_date',
            'sec_ev_venue_id' => 'event_venue_id'
        ];

        // Replacing the keys using the mapping
        foreach ($event_details as $key => $row) {
            foreach ($column_mapping as $db_column => $frontend_column) {
                if (isset($row[$db_column])) {
                    $event_details[$key][$frontend_column] = $row[$db_column];
                    unset($event_details[$key][$db_column]);
                }
            }
        }

        $event_teams = get_event_teams_details($sec_ev_id);

        $event_full_data = $event_details;
        
        if ($event_teams) {
            $event_full_data[0]['event_team_short_name_1'] = $event_teams[0]['event_team_short_name_1'];
            $event_full_data[0]['event_team_short_name_2'] = $event_teams[1]['event_team_short_name_2'];
        }

        $event_full_data[0]['event_sport'] = get_sport_name($event_full_data[0]['event_sport_id']);

        $event_full_data[0]['event_type'] = get_event_type_name($event_full_data[0]['event_type_id']);

        $event_full_data[0]['event_venue'] = get_event_venue_name($event_full_data[0]['event_venue_id']);
        
        return $event_full_data;
    
    } catch (Exception $e) {
        echo 'Failed to get last event details ' . $e->getMessage();
    }
}