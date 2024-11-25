<?php
    require_once dirname(__FILE__) .'/../config.php';

    const ERROR_CLIENT_MSG = 'An error occurred while processing your request';
    const DONE_CLIENT_MSG = 'Your request was processed succesfully';
    
    $message_get = filter_input(INPUT_GET, 'message');
    if ($message_get !== null) {
        if ($message_get === 'true') {
            header("Location: /calendar/app/main.php");
            
            exit();
        } else {
            $message = ERROR_CLIENT_MSG;
        }
    }
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
    <meta charset="utf-8" />
    <script src="main.js"></script> <!-- Link to the external JavaScript file -->
    
    <title>New sport event</title>
    
    <style>
        body {
            justify-content: center;  /* Center the container horizontally */
        }

        .header h2 {
            text-align: center;
        }
        
        .table-container {
            width: 100%;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
            border: 1px solid #007bff;
        }
        
        .table {
            width: 100%;
        }
        
        .label {
            font-weight: bold;
        }
        
        .field {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        
        .button-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .button {
            padding: 12px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 16%;
        } 
    </style>
</head>  
    
<body>
    <div class="header">
        <h2>New sport event</h2>
    </div>
    
    <form id="new_event_form" action="new_event.php?action=new_event_form" method="POST">
        <!-- Container for the table and the button -->
        <div class="table-container">    
            <table class="table">
                <tr>
                    <td><div class="label">Name</div></td>
                    <td><input class="field" type="text" name="event_name" placeholder="Name..." required=""></input></td>
                </tr>
                <tr>
                    <td><div class="label">Description</div></td>
                    <td><input class="field" type="text" id="event_description" placeholder="Description..."></input></td>
                </tr>
                <tr>
                    <td><div class="label">Event type</div></td>
                    <td>
                        <select class="field" name="event_type" required="">
                            <option value="">Select event type...</option>
                            <option value="1">Competitive match</option>
                            <option value="2">Friendly match</option>
                        </select>
                    </td>    
                </tr>
                <tr>
                    <td><div class="label">Sport</div></td>
                    <td>
                        <select class="field" name="event_sport" required="">
                            <option value="">Select sport...</option>
                            <option value="1">Football</option>
                            <option value="2">Ice Hockey</option>
                        </select>
                    </td> 
                </tr>
                <tr>
                    <td><div class="label">Venue</div></td>
                    <td>
                        <select class="field" name="event_venue" required="">
                            <option value="">Select venue...</option>
                            <option value="1">Red Bull Arena</option>
                            <option value="2">Merkur Arena</option>
                            <option value="3">Stadthalle</option>
                            <option value="4">Steffl Arena</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><div class="label">Start date</div></td>
                    <td><input class="field" type="datetime-local" name="event_start_date" required=""></input></td>
                </tr>
                <tr>
                    <td><div class="label">Team 1</div></td>
                    <td>
                        <select class="field" name="event_team_1" required="">
                            <option value="">Select team 1...</option>
                            <option value="1">Red Bull Salzburg</option>
                            <option value="2">SK Sturm Graz</option>
                            <option value="3">EC KAC</option>
                            <option value="4">Vienna Capitals</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><div class="label">Team 2</div></td>
                    <td>
                        <select class="field" name="event_team_2" required="">
                            <option value="">Select team 2...</option>
                            <option value="1">Red Bull Salzburg</option>
                            <option value="2">SK Sturm Graz</option>
                            <option value="3">EC KAC</option>
                            <option value="4">Vienna Capitals</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="button-container">
            <button class="button" type="submit">Add new event</button>
        </div>  
    </form>
    
    <!-- Show alert based on the 'message' URL parameter -->
    <script>
        <?php if ($message != ''): ?>
            alert('Message: <?php echo $message; ?>');
        <?php endif; ?>
    </script>
</body>