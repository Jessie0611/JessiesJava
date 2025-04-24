# JessiesJava
Full stack website with PHP and MySQL
All pages use security features: 
Sanitization: Uses htmlspecialchars() to avoid XSS by escaping special characters.
Prepared statements: Prevents SQL injection in MySQL queries.
** database.php ** connects to a MySQL database using MySQLi (MySQL Improved) in PHP. It also sets up some configurations for debugging &character encoding.

** reservation.php ** processes reservation form submission, handles form data securely, validates inputs (including time & date), checks if the user exists, then inserts proper info into users/reservations into the database. 
-session_start() allows you to use session variables (like saving user info across pages).
-Ensures the code only runs if the form is submitted via POST (a secure way to send data).
-Uses filter_input() to sanitize data which prevents harmful input, makes sure email & number formats are safe, & protects against basic XSS & injection attacks.
-Ensures all form fields are filled in, if not, shows an alert and redirects back.
-Helper function to convert 24-hr time to 12-hr with AM/PM (used in alerts).
-Gets the current date & time then rejects reservations in the past (either wrong date or earlier today).
-Business hr validation determines which day of the week the reservation is for & ensures the reservation time falls within business hrs.
-Redirects to a confirmation page, passing the user ID for personalized messaging -- If something goes wrong, alert the user & redirects back if the reservation fails to save.
function convertTo12Hour($time) {
    return date("g:i A", strtotime($time));
}
Character | Meaning | Example Output
g | Hour in 12-hour format (1–12) | 1 to 12
i | Minutes with leading zero | 00, 01, 59
A | AM or PM in uppercase | AM, PM

** confirmation.php ** reservation confirmation handler prepares a secure SQL query to fetch user details based on their ID, uses prepared statements to avoid SQL injection. Only grabs the most recent reservation for this user using ORDER BY resID DESC LIMIT 1.
-Page Displays: Confirmation number, User’s name, email, phone, Reservation type, price, date, time, JJ Address and contact info
--User can print or save this page.
-Send a Confirmation Email with PHPMailer
-The $emailBody includes name, date, time, reservation type, and price.

** search.php **  lets users search for a reservation by confirmation number (i.e., resID), and then view, edit, or cancel it. It connects to the database, fetches details if a match is found, and displays the results in a table.
-Ensure data is submitted via POST
-Query DB & join these 3 tables: reservations (r), users (u) → to get user info, restype (rt) → to get the type of reservation
-Binds the resID (must be an integer) securely, adds each result to the $reservations array.
-Displays results in a table with Edit and Cancel options.
--Edit → form sends resID via GET to edit.php
--Cancel → form sends resID via POST to cancel.php with confirmation
-Handles cases where no match is found.

** edit.php ** allows a user to edit an existing reservation by updating the date and time of a reservation, while validating the input against business hours.
-Reservation time is checked to ensure it is within the correct business hours, which vary depending on the day of the week.
-If the time is not within business hours, the user is shown an alert and redirected.
-After validation, the reservation is updated in the database and feedback is given to the user.

**cancel.php **  handles reservation cancellation. It updates a reservation's status in the database to “Canceled” then redirects the user to a confirmation page.
-Ensures that the resID (reservation ID) is actually included in the POST data. This ensures only valid cancellation requests go through.
-Receives a reservation ID from a form, ensures form was submitted via POST (secure method).
-Cancels that reservation by updating the database then redirects the user to a cancellation confirmation page.
-Shows an error if accessed incorrectly.

** cancelConfirm.php ** fetches and shows the user's name and reservation ID if the cancellation was successful.
-Retrieves the resID from the URL query string, like cancelConfirm.php?resID=42.

** script.js **  JavaScript code implementing a variety of interactive features for a website
-Menu Display(): The menu object contains arrays of drinks (such as hot lattes, iced lattes, etc.), each with a name, price, and description.
-Calendar Events(): Renders a calendar with clickable dates that show events. 
--Displays the current month and year. Users can navigate between months using "prev" and "next" buttons.
--The calendar cells are dynamically created, displaying the day of the month.
--Each date cell is checked against a list of events, and if there’s an event on that day, the date cell is styled with a background color and tooltip containing the event title.
--Clicking on a date will show a list of events for that day.
-Upcoming Events List(): The function filters the events array to get all events occurring after the current date.
--Upcoming events are displayed as a list in a specific HTML element (events-list). A list of future events, shown after the page is loaded.
-AI Chatbot(): Toggles the visibility of a chatbot container.
-Time Validation(): reservation date and time input fields are adjusted based on the current date, ensuring users can only select times within business hours. The code listens for changes to both the date and time fields.
--If the user selects a time outside of the allowed range, an alert is triggered. The date is limited to today or future dates, and the time is adjusted according to the selected day of the week.
--Users are prevented from making reservations outside business hours.
-Disclosure Accordion(): Implements an accordion-style collapsible section for displaying disclosure agreement.

** composer.json ** used by Composer, the dependency manager for PHP. It defines metadata, dependencies, autoloading, and scripts for the PHP project — in this case, PHPMailer, a widely used library for sending emails from PHP applications. Lists the original authors/maintainers of the project with contact info 
-Allows specific Composer plugins.
-Specifies required PHP version and extensions needed to run PHPMailer.
-Uses PSR-4 autoloading to load classes from the src/ directory.
-PHPMailer is licensed under LGPL 2.1, a free software license that allows use in proprietary software under certain conditions.