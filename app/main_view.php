<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="eng" lang="eng">
    
<head>
    <meta charset="utf-8" />
    <script src="main.js"></script> <!-- Link to the external JavaScript file -->
    
    <title>Sports Events Calendar</title>
    
    <style>
        .topnav {
            padding: 10px;
        }

        .header {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            padding: 10px;
        }

        .main-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
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
        
        /* Add space between the search bar and event list */
        .search-filter {
            margin: 0 10px 15px 10px;
            display: flex;
            justify-content: center;
            gap: 10px; /* gap between the search bar and the button */
        }

        .search-filter input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1;
        }

        .search-filter button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 20%;
        }        
    </style>
</head>

<body>
    <div class="topnav">
        <a>Home</a>
        <a>Events</a>
        <a>Players</a>
        <a>Teams</a>
        <a>Coaches</a>
    </div>

    <div class="header">
        Sports Events Calendar
    </div>

<div class="main-container">
    <!-- Events List -->
    <div class="events-list">
        <h2>Events</h2>

        <!-- Search Filter -->
        <div class="search-filter">
            <input type="text" id="searchInput" placeholder="Search event..." oninput="filterEvents()" />
            <button onclick="showNotWorkingMessage()">Search</button>
        </div>

        <!-- Event List -->
        <div id="eventList">
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

    <!-- Event Details -->
    <div class="event-details" id="event-details">
        <h2>Details</h2>
        <p>Select an event to see details.</p>
    </div>
</div>

    <div class="footer">
        Created by Natalia Ziarko, 2024
    </div>
    
    <div class="footer">
        Created by Natalia Ziarko, 2024
    </div>

</body>
</html>