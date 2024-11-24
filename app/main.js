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

function showNotWorkingMessage() {
    alert("The search functionality is not working yet.");
}