<?php
    require_once dirname(__FILE__) . '/../config.php'; // Include config.php to access $db connection
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
    <meta charset="utf-8" />
    
    <title>Sports Events Calendar</title>
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        .topnav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #0d3b66;
            font-size: 1.0rem;
            color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .topnav .logo {
            font-size: 1.2rem;
            font-weight: bold;
            color: #e0e0e0;
            text-transform: uppercase;
        }

        .topnav a {
            text-decoration: none;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
        }        

        .dropdown-content a {
            color: #0d3b66;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s, color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #007bff;
            color: white;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .header {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom: 3px solid #0d3b66;
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .main-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
            flex-grow: 1;
            margin-bottom: 50px;
        }

        .events-list {
            width: 40%;
            border-right: 1px solid #ccc;
        }

        .event-details {
            width: 60%;
        }
        
        .events-list h2,
        .event-details h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .event-item {
            cursor: pointer;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .event-item:hover {
            background-color: #f0f0f0;
        }

        .event-item.active {
            background-color: #d1ecf1;
            border-color: #bee5eb;
        }

        .new-event,
        .search-filter {
            margin: 10px 10px 15px 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
            background-color: #f8f9fa;
            align-items: center;
        }
        
        .search-filter {
            flex-direction: column;
        }

        .search-filter input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1;
        }
        
        .filter-item {
            display: flex;
            gap: 5px;
        }

        .search-filter button,
        .new-event button{
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 140px;
            height: 40px;
        }
        
        .search-filter button {
            width: 100px;
            height: 30px;            
        }

        .footer {
            background-color: #0d3b66;
            color: #ffffff;
            text-align: center;
            font-size: 1rem;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
            padding: 10px 0;
            box-sizing: border-box;
            position: relative;
            bottom: 0;
        } 
    </style>
</head>

<body>
    <div class="topnav">
        <div class="logo">Sports Events Calendar</div>
        <a href="#">Home</a>
        <div class="dropdown">
            <a href="#">Events</a>
            <div class="dropdown-content">
                <a href="#">Football</a>
                <a href="#">Ice Hockey</a>
            </div>
        </div>
        <a href="#">Players</a>
        <a href="#">Teams</a>
        <a href="#">Coaches</a>
    </div>

    <div class="header">
        <a>Sports Events Calendar</a>
    </div>
    
    <div class="new-event">
        <h2> New event is coming? </h2>
        <button onclick="redirectToNewEventForm()">Add a new event</button>
    </div>

    <div class="main-container">
        <!-- Events List -->
        <div class="events-list">
            <h2>Events</h2>

            <!-- Search filter -->
            <div class="search-filter">
                <div class="filter-item">
                    <input type="date" id="search_date" />
                    <button onclick="showNotWorkingMessage()">Search</button>
                </div>
                <div class="filter-item">
                    <select id="search_sport" >
                        <option value="">Choose sport...</option>
                        <option value="1">Football</option>
                        <option value="2">Ice hockey</option>
                    </select>
                    <button id="fetch-filtered-events-btn">Search</button>
                </div>
            </div>
            
            <!-- Event list -->
            <div id="event_list">
                <?php if (!empty($all_events_details)): ?>
                    <?php foreach ($all_events_details as $event_array): ?>
                        <?php 
                        $event = $event_array[0]; // Access the actual event data row
                        ?>
                        <div class="event-item" 
                             onclick="selectEvent(this, <?= htmlspecialchars(json_encode($event, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)">
                            <?= htmlspecialchars($event['event_name'] ?? 'Unnamed Event') ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>No events available</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Event details -->
        <div class="event-details" id="event-details">
            <h2>Details</h2>
            <p>Select an event to see details.</p>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <a>Created by Natalia Ziarko, 2024</a>
        </div>
    </div>
    
    <!-- Calling an external JavaScript file for client actions -->
    <script src="main.js"></script>

</body>
</html>
