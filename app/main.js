// Display an alert message indicating that the functionality is not working yet
function showNotWorkingMessage() {
    alert("The functionality is not working yet.");
}

// Redirect the user to the new event form page
function redirectToNewEventForm() {
    window.location.href = "http://localhost/calendar/app/new_event_form_view.php";
}

// Select an event from the list and display its details
function selectEvent(element, event) {
    // Debug
    console.log('1 selectEvent called with event:', event);

    // Remove 'active' class from previously selected event
    const activeEvent = document.querySelector('.event-item.active');

    if (activeEvent) {
        // Debug
        console.log('2R Removing active class from:', activeEvent);
        activeEvent.classList.remove('active');
    }

    // Add 'active' class to the clicked event
    element.classList.add('active');

    // Debug
    console.log('2A Adding active class to:', event);

    // Update the details section
    showEventDetails(event);
}

// Display the details of the selected event in the event details section
function showEventDetails(event) {
    // Debug
    console.log('3 showEventDetails called with event:', event);

    const detailsDiv = document.getElementById('event-details');

    // Ensure valid event data
    if (!event) {
        console.error('No event data available.');
        return;
    }

    // Clear existing content and add new event details
    detailsDiv.innerHTML = `
        <h2>Details</h2>
        <table>
            <tr><th>Name</th><td>${event.event_name ?? 'N/A'}</td></tr>
            <tr><th>Description</th><td>${event.event_description ?? 'N/A'}</td></tr>
            <tr><th>Event Type</th><td>${event.event_type ?? 'N/A'}</td></tr>
            <tr><th>Sport</th><td>${event.event_sport ?? 'N/A'}</td></tr>
            <tr><th>Time</th><td>${event.event_start_date ?? 'N/A'}</td></tr>
            <tr><th>Place</th><td>${event.event_venue ?? 'N/A'}</td></tr>
            <tr><th>Teams</th><td>${(event.event_team_short_name_1 ?? 'N/A') + ' - ' + (event.event_team_short_name_2 ?? 'N/A')}</td></tr>
        </table>
    `;
}

document.addEventListener('DOMContentLoaded', function() {
    const fetchButton = document.getElementById('fetch-filtered-events-btn');

    // Action after searching by sport
    fetchButton.addEventListener('click', function() {
        // Debug
        console.log('Search by sport button clicked');

        const sportId = document.getElementById('search_sport').value;

        if (!sportId) {
            alert('Please select a sport.');
            return;
        }

        fetchFilteredEvents(sportId);
    });
});

// Fetch and display events based on the selected sport filter
function fetchFilteredEvents(sportId) {
    // Debug
    console.log('Fetching events for sport ID:', sportId);

    // Clear the event details before fetching new events
    const detailsDiv = document.getElementById('event-details');
    if (detailsDiv) {
        detailsDiv.innerHTML = `<h2>Details</h2><p>Select an event to see details.</p>`;
    }

    // Remove the 'active' class from any selected event
    const activeEvent = document.querySelector('.event-item.active');
    if (activeEvent) {
        activeEvent.classList.remove('active');
    }

    // Fetch events based on the selected sport
    fetch('show_all_events.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'filter_sport=' + sportId
    })
    .then(response => response.json())
    .then(data => {
        // Get the event list container
        const eventListDiv = document.getElementById('event_list');

        // Clear the existing event list
        eventListDiv.innerHTML = '';

        // Check if events were received
        if (data && data.length > 0) {
            // Loop through the new events and create event list items
            data.forEach(item => {
                const event = Array.isArray(item) ? item[0] : item;
                // Debug
                console.log('Fetched event:', event);

                const eventItem = document.createElement('div');
                eventItem.classList.add('event-item');
                eventItem.innerHTML = `${event.event_name ?? 'Unnamed Event'}`;

                // Add the click event to each event item
                eventItem.onclick = function() {
                    // Debug
                    console.log('Event clicked:', event);

                    // Pass the correct event to selectEvent
                    selectEvent(this, event);
                };

                // Append the new event item to the event list container
                eventListDiv.appendChild(eventItem);
            });
        } else {
            // If no events found show a message
            eventListDiv.innerHTML = '<div>No events available</div>';
        }
    })
    .catch(error => {
        console.error('Error fetching events:', error);
    });
}

// Update the event list in the DOM
function updateEventList(events) {
    // Debug
    console.log('Updating event list with events:', events);

    const eventListDiv = document.getElementById('event_list');

    // Clear the current event list
    eventListDiv.innerHTML = '';

    // If no events found, show a message
    if (events.length === 0) {
        eventListDiv.innerHTML = '<div>No events available for the selected sport.</div>';
    } else {
        // Loop through the events and create new event items
        events.forEach(event => {
            // Debug
            console.log('Creating event item for:', event);

            const eventItem = document.createElement('div');
            eventItem.classList.add('event-item');
            eventItem.innerHTML = event.event_name;

            // Add the click event to each event item
            eventItem.onclick = function() {
                // Debug
                console.log('Event clicked:', event);

                selectEvent(this, event);
            };

            eventListDiv.appendChild(eventItem);
        });
    }
}
