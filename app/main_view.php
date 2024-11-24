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
        Sports events calendar
    </div>
    
    <table>
        <?php if (!empty($last_event_details)): ?>
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th>Event type</th>
              <th>Sport</th>
              <th>Time</th>
              <th>Place</th>
              <th>Teams</th>
            </tr>
        
            <?php foreach ($last_event_details as $event): ?>
                <tr>
                  <td><?= htmlspecialchars($event['event_name'] ?? '') ?></td>
                  <td><?= htmlspecialchars($event['event_description'] ?? '') ?></td>
                  <td><?= htmlspecialchars($event['event_type'] ?? '') ?></td>
                  <td><?= htmlspecialchars($event['event_sport'] ?? '') ?></td>
                  <td><?= htmlspecialchars($event['event_start_date'] ?? '') ?></td>
                  <td><?= htmlspecialchars($event['event_venue'] ?? '') ?></td>
                  <td><?= htmlspecialchars(
                          ($event['event_team_short_name_1'] ?? 'N/A')
                          . ' - ' 
                          . ($event['event_team_short_name_2'] ?? 'N/A')) ?>
                  </td>
                </tr>
            <?php endforeach; ?>        
        <?php else: ?>
            <tr>
                <td colspan="7">No event found</td>
            </tr>
        <?php endif; ?>
    </table>
    
    <div class="footer">
        Created by Natalia Ziarko, 2024
    </div>

</body>
</html>