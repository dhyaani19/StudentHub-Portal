
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Event Management System</h1>
        <p>Manage your events easily with PHP JSON API</p>
    </header>

    <main class="container">
        <section class="card">
            <h2>Add New Event</h2>

            <form id="eventForm">
                <input type="hidden" id="eventId">

                <label for="eventName">Event Name</label>
                <input type="text" id="eventName" placeholder="Enter event name" required>

                <label for="eventDate">Event Date</label>
                <input type="date" id="eventDate" required>

                <label for="eventVenue">Venue</label>
                <input type="text" id="eventVenue" placeholder="Enter venue" required>

                <button type="submit" id="submitBtn">Add Event</button>
                <button type="button" id="cancelBtn" class="secondary" hidden>Cancel Edit</button>
            </form>

            <p id="message" role="status" aria-live="polite"></p>
        </section>

        <section class="card">
            <h2>All Events</h2>

            <p id="loading">Loading events...</p>

            <div id="eventList"></div>
        </section>
    </main>

    <footer>
        <p>Practical 13 | PHP, MySQL, JSON API & Fetch API</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
