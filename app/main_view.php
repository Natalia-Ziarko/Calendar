<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    
<head>
    <meta charset="utf-8" />
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
            <?php if (!empty($all_events_details)): ?>
                <?php foreach ($all_events_details as $eventWrapper): ?>
                    <?php 
                        $event = $eventWrapper[0]; // Access the actual event data
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

        <!-- Event Details -->
        <div class="event-details" id="event-details">
            <h2>Details</h2>
            <p>Select an event to see details.</p>
        </div>
    </div>

    <div class="footer">
        Created by Natalia Ziarko, 2024
    </div>

    <script>
        function selectEvent(element, event) {
            // Remove 'active' class from previously selected event
            const activeEvent = document.querySelector('.event-item.active');
            if (activeEvent) {
                activeEvent.classList.remove('active');
            }

            // Add 'active' class to the clicked event
            element.classList.add('active');

            // Update the details section
            showEventDetails(event);
        }
    
        function showEventDetails(event) {
            const detailsDiv = document.getElementById('event-details');
            detailsDiv.innerHTML = `
                <h2>Details</h2>
                <table>
                    <tr><th>Name</th><td>${event.event_name ?? 'N/A'}</td></tr>
                    <tr><th>Description</th><td>${event.event_description ?? 'N/A'}</td></tr>
                    <tr><th>Event type</th><td>${event.event_type ?? 'N/A'}</td></tr>
                    <tr><th>Sport</th><td>${event.event_sport ?? 'N/A'}</td></tr>
                    <tr><th>Time</th><td>${event.event_start_date ?? 'N/A'}</td></tr>
                    <tr><th>Place</th><td>${event.event_venue ?? 'N/A'}</td></tr>
                    <tr><th>Teams</th><td>${(event.event_team_short_name_1 ?? 'N/A') + ' - ' + (event.event_team_short_name_2 ?? 'N/A')}</td></tr>
                </table>
            `;
        }
    </script>
    
    <div class="footer">
        Created by Natalia Ziarko, 2024
    </div>

</body>
</html>