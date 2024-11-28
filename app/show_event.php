<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection

/**
 * Fetch the ID of the last event from the database
 * 
 * @global PDO $db The PDO database connection object
 * @return int The ID of the last event; 0 if no event found
 * @throws Exception If there is a failure in fetching data
 */
function get_last_event_id() {
    // Refer to the global PDO object
    global $db;
    
    try {
        $sql = "SELECT MAX(sec_ev_id) event_id FROM sec_events";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $last_event_id = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($last_event_id === null) {
            return 0;
        }
        
        $event_id = $last_event_id['event_id'];
        
        return $event_id;
    
    } catch (Exception $e) {
        error_log('Failed to check last event ID: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }
}

/**
 * Fetch details from the database of the teams participated in the specified event
 * 
 * @global PDO $db The PDO database connection object
 * @param int $sec_ev_id
 * @return array Teams details; empty if no teams found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_event_teams_details($sec_ev_id) {
    global $db;
    
    try {
        $sql_sec_teams = "
            SELECT t.* 
            FROM sec_teams t
            INNER JOIN sec_participants p ON t.sec_te_id = p.sec_pa_participant_id
            WHERE p.sec_pa_event_id = :event_id
        ";
        $stmt = $db->prepare($sql_sec_teams);
        $stmt->execute(['event_id' => $sec_ev_id]);
        $teams_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($teams_details) {
            // Replacing the keys for the frontend
            foreach ($teams_details as $key => $row) {
                if (isset($row['sec_te_short_name'])) {
                    $teams_details[$key]['event_team_short_name_' . ($key + 1)] = $row['sec_te_short_name'];
                    unset($teams_details[$key]['sec_te_short_name']);
                }
            }
        }
        
        return $teams_details;
    
    } catch (Exception $e) {
        error_log('Failed to get event teams details: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }
}

/**
 * Fetch country name from the database
 * 
 * @global PDO $db The PDO database connection object
 * @param int $country_id
 * @return string Country name; predefined error message (MSG_IF_NULL_RETURN) if no country found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_country_name($country_id) {
    global $db;
    
    try {
        $sql_sec_countries = "SELECT * FROM sec_countries WHERE sec_ct_id = :country_id";     
        $stmt = $db->prepare($sql_sec_countries);
        $stmt->execute(['country_id' => $country_id]);
        $country_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($country_details && isset($country_details[0]['sec_ct_name'])) {
            $country_name = $country_details[0]['sec_ct_name'];
            
            return $country_name;
        } else {
            return MSG_IF_NULL_RETURN;
        }
        
    } catch (Exception $e) {
        error_log('Failed to get country name: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }    
}

/**
 * Fetch sport name from the database
 * 
 * @global PDO $db The PDO database connection object
 * @param int $sport_id
 * @return string Sport name; predefined error message (MSG_IF_NULL_RETURN) if no sport found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_sport_name($sport_id) {
    global $db;
    
    try {
        $sql_sec_sports = "SELECT * FROM sec_sports WHERE sec_sp_id = :sport_id";     
        $stmt = $db->prepare($sql_sec_sports);
        $stmt->execute(['sport_id' => $sport_id]);  
        $sport_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($sport_details && isset($sport_details[0]['sec_sp_name'])) {
            $sport_name = $sport_details[0]['sec_sp_name'];
            
            return $sport_name;
        } else {
            return MSG_IF_NULL_RETURN;
        }
    
    } catch (Exception $e) {
        error_log('Failed to get sport name: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }    
}

/**
 * Fetch event type name from the database
 * 
 * @global PDO $db The PDO database connection object
 * @param int $event_type_id
 * @return string Event type name; predefined error message (MSG_IF_NULL_RETURN) if no event type found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_event_type_name($event_type_id) {
    global $db;
    
    try {
        $sql_sec_event_types = "SELECT * FROM sec_event_types WHERE sec_et_id = :event_type_id";     
        $stmt = $db->prepare($sql_sec_event_types);
        $stmt->execute(['event_type_id' => $event_type_id]);
        $event_type_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($event_type_details && isset($event_type_details[0]['sec_et_name'])) {
            $event_name = $event_type_details[0]['sec_et_name'];
            
            return $event_name;
        } else {
            return MSG_IF_NULL_RETURN;
        }        
        
    } catch (Exception $e) {
        error_log('Failed to get event type name: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }    
}

/**
 * Fetch venue name from the database
 * 
 * @global PDO $db The PDO database connection object
 * @param int $venue_id
 * @return string Venue name; predefined error message (MSG_IF_NULL_RETURN) if no venue found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_event_venue_name($venue_id) {
    global $db;
    
    try {
        $sql_sec_venues = "SELECT * FROM sec_venues WHERE sec_ve_id = :event_venue_id";     
        $stmt = $db->prepare($sql_sec_venues);
        $stmt->execute(['event_venue_id' => $venue_id]);
        $event_venue_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($event_venue_details && isset($event_venue_details[0]['sec_ve_name'])) {
            $venue_name = $event_venue_details[0]['sec_ve_name'];
            
            return $venue_name;
        } else {
            return MSG_IF_NULL_RETURN;
        }         
    
    } catch (Exception $e) {
        error_log('Failed to get venue name: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }    
}

/**
 * Fetch event details from the database, if $event_id is NULL then fetch last event details
 * 
 * @global PDO $db The PDO database connection object
 * @param int|null $event_id Optional parameter for specified event (default: null for last event)
 * @return array Event details; empty if no event found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
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
            'sec_ev_id' => 'id',
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
        
        if (!empty($event_teams) && count($event_teams) == 2) {
            $event_full_data[0]['event_team_short_name_1'] = $event_teams[0]['event_team_short_name_1'] ?? MSG_IF_NULL_RETURN;
            $event_full_data[0]['event_team_short_name_2'] = $event_teams[1]['event_team_short_name_2'] ?? MSG_IF_NULL_RETURN;
        }

        $event_full_data[0]['event_sport'] = !empty($event_full_data[0]['event_sport_id']) 
            ? get_sport_name($event_full_data[0]['event_sport_id']) 
            : MSG_IF_NULL_RETURN;

        $event_full_data[0]['event_type'] = !empty($event_full_data[0]['event_type_id']) 
            ? get_event_type_name($event_full_data[0]['event_type_id']) 
            : MSG_IF_NULL_RETURN;

        $event_full_data[0]['event_venue'] = !empty($event_full_data[0]['event_venue_id']) 
            ? get_event_venue_name($event_full_data[0]['event_venue_id']) 
            : MSG_IF_NULL_RETURN;
        
        return $event_full_data;
    
    } catch (Exception $e) {
        error_log('Failed to get last event details: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }
}
