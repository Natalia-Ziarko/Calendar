<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection
require_once '../app/show_event.php';

/**
 * Handle event filtering and return the filtered events as JSON
 */
function filter_events_by_sport() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter_sport'])) {
        $filter_sport = $_POST['filter_sport'] ?? null;

        // Fetch events based on the selected sport
        $all_events_details = get_all_events_details($filter_sport);

        // Return the events as a JSON response
        echo json_encode($all_events_details);

        // Exit after sending the response to avoid any further output
        exit;
    }
}

// Call the function to filter events
filter_events_by_sport();

/**
 * Fetch all events or filtered by the specified parameter and return the events as an array
 *
 * @global PDO $db The PDO database connection object
 * @param string|null $filter Optional filter parameter for event selection (default: null for all events)
 * @return array Returns an array of events if found; an empty array if no events are found
 *              If an error occurs, returns a predefined error message (MSG_IF_ERROR)
 * @throws Exception If there is a failure in fetching data
 */
function get_all_events_details($filter_sport = null) {
    global $db;

    // Initialize an empty array for event details
    $all_events_full_data = [];
    
    try {
        $sql_sec_events = "SELECT sec_ev_id FROM sec_events";
        
        // Add filtering condition if sport filter is provided
        if ($filter_sport !== null) {
            $sql_sec_events .= " WHERE sec_ev_sport_id = :filter_sport_id";
        }
        
        $sql_sec_events .= " ORDER BY sec_ev_date_start DESC";
        
        // Prepare the SQL statement
        $stmt = $db->prepare($sql_sec_events);
        
        if ($filter_sport !== null) {
            $stmt->bindParam(':filter_sport_id', $filter_sport, PDO::PARAM_INT);
        }
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all the event ids
        $events_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return an empty array if no events are found
        if (empty($events_ids)) {
            return [];
        }
        
        foreach ($events_ids as $event) {
            $event_id = $event['sec_ev_id'];
            
            $all_events_full_data[] = get_event_details($event_id);
        }
        
        return $all_events_full_data;
    
    } catch (Exception $e) {
        error_log('Failed to get all events details: ' . $e->getMessage());
        
        return MSG_IF_ERROR;
    }
}
