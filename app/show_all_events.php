<?php
require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection
require_once '../app/show_event.php';

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

function get_all_events_details() {
    global $db;
    
    try {
        $sql_sec_events = "SELECT sec_ev_id FROM sec_events";     
        $stmt = $db->prepare($sql_sec_events);
        $stmt->execute();
        $events_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($events_ids as $event) {
            $event_id = $event['sec_ev_id'];
            
            $all_events_full_data[] = get_event_details($event_id);
        }
        
        return $all_events_full_data;
    
    } catch (Exception $e) {
        echo 'Failed to get all events details ' . $e->getMessage();
    }
}