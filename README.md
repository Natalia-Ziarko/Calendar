# Project Name: Calendar

## Overview

This is a web application designed to help sports fans keep track of events.
It allows users to add new sports events to the database, view a list of all events, and filter events by their sport type. Users can also click on individual events to see detailed information, such as the date, time, location, and a description of the event.

## Table of Contents

- [Project Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Setup Instructions](#setup-instructions)
- [Running the Web App](#running-the-web-app)
- [Assumptions and Decisions](#assumptions-and-decisions)

## Features

1. **Add New Sports Events**
   - Users can easily add new events by entering event details.
   - Events are stored in a database for easy management and future reference.

2. **Filter Events by Sport**
   - Users can select a specific sport type (e.g., Football, Ice Hockey) to display only events related to that sport.
   - The filtering feature provides a convenient way to focus on a user’s sport of interest.

3. **List of Events**
   - Displays all upcoming sports events in a clear, chronological list format.
   - Each event is summarized with key details such as its name, sport, and date.

4. **Event Details**
   - Clicking on an event provides a detailed view, including:
     - Name
     - Description
     - Event type
     - Sport type
     - Date and time
     - Venue

## Technology Stack

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Environment: XAMPP (local server with Apache and MySQL)

## Setup Instructions

Follow these steps to set up and run the application locally.

### Prerequisites

Ensure you have the following tools installed:
- [XAMPP](https://www.apachefriends.org/index.html) (or an equivalent local server environment)
- [Git](https://git-scm.com/) (to clone the repository)

### Installation Steps

1. **Clone the repository**

    ```bash
    git clone https://github.com/Natalia-Ziarko/Calendar.git
    cd Calendar
    mv Calendar path/to/xampp/htdocs
    
    ```

3. **Start XAMPP**

    - Open the XAMPP Control Panel.
    - Start the **Apache** and **MySQL** services.


4. **Set up the Database**

    - Access phpMyAdmin by navigating to `http://localhost/phpmyadmin/` in your browser.
    - Create new sports_events_calendar database.
    - Import sports_events_calendar.sql file.

    Make sure to update your PHP code (in `.env` or config files) with the correct database credentials, such as:
    - `DB_SERVER = localhost`
    - `DB_USER = root`
    - `DB_PASS = root`
    - `DB_NAME = sports_events_calendar`

5. **Access the app**

    Open your web browser and navigate to:

    ```bash
    http://localhost/calendar/app/main.php
    ```

    The app should now be running locally on XAMPP.

## Assumptions and Decisions

- **Assumption 1**: The project assumes that the user is running the app locally using XAMPP or similar environments, which provides Apache and MySQL services for PHP development.
  
- **Assumption 2**: The project relies on MySQL for database storage (via XAMPP).

- **Technology Decision**: PHP is used for the backend to keep the app simple and compatible with most local server environments. JavaScript is used for client-side interactions, and the app is styled using basic CSS.

- **Database Decision**: MySQL was chosen as the database, using XAMPP’s built-in MySQL service, making it easier to set up and test locally.
