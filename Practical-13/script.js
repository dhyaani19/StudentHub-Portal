
const eventForm = document.getElementById("eventForm");
const eventId = document.getElementById("eventId");
const eventName = document.getElementById("eventName");
const eventDate = document.getElementById("eventDate");
const eventVenue = document.getElementById("eventVenue");
const submitBtn = document.getElementById("submitBtn");
const cancelBtn = document.getElementById("cancelBtn");
const eventList = document.getElementById("eventList");
const loading = document.getElementById("loading");
const message = document.getElementById("message");

function showMessage(text, type) {
    message.textContent = text;
    message.className = type;
}

async function loadEvents() {
    loading.hidden = false;
    loading.textContent = "Loading events...";
    eventList.replaceChildren();

    try {
        const response = await fetch("fetch_events.php");
        const result = await response.json();

        if (!response.ok || result.status !== "success") {
            throw new Error(result.message || "Unable to load events.");
        }

        loading.hidden = true;

        if (result.data.length === 0) {
            eventList.textContent = "No events found.";
            return;
        }

        result.data.forEach(event => {
            const card = document.createElement("div");
            card.className = "event-item";

            const title = document.createElement("h3");
            title.textContent = event.event_name;

            const date = document.createElement("p");
            date.textContent = "Date: " + event.event_date;

            const venue = document.createElement("p");
            venue.textContent = "Venue: " + event.venue;

            const actions = document.createElement("div");
            actions.className = "event-actions";

            const editBtn = document.createElement("button");
            editBtn.type = "button";
            editBtn.className = "edit-btn";
            editBtn.textContent = "Edit";
            editBtn.addEventListener("click", () => editEvent(event));

            const deleteBtn = document.createElement("button");
            deleteBtn.type = "button";
            deleteBtn.className = "delete-btn";
            deleteBtn.textContent = "Delete";
            deleteBtn.addEventListener("click", () => deleteEvent(event.id));

            actions.append(editBtn, deleteBtn);
            card.append(title, date, venue, actions);
            eventList.appendChild(card);
        });
    } catch (error) {
        loading.hidden = false;
        loading.textContent = "Failed to load events.";
        showMessage(error.message, "error");
    }
}

function editEvent(event) {
    eventId.value = event.id;
    eventName.value = event.event_name;
    eventDate.value = event.event_date;
    eventVenue.value = event.venue;

    submitBtn.textContent = "Update Event";
    cancelBtn.hidden = false;

    showMessage("Editing event: " + event.event_name, "success");
    eventForm.scrollIntoView({ behavior: "smooth" });
}

function resetForm() {
    eventForm.reset();
    eventId.value = "";
    submitBtn.textContent = "Add Event";
    cancelBtn.hidden = true;
}

cancelBtn.addEventListener("click", () => {
    resetForm();
    showMessage("Edit cancelled.", "success");
});

eventForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    const name = eventName.value.trim();
    const date = eventDate.value;
    const venue = eventVenue.value.trim();

    if (!name || !date || !venue) {
        showMessage("Please fill in all fields.", "error");
        return;
    }

    const isEditing = eventId.value !== "";

    const formData = new FormData();
    formData.append("event_name", name);
    formData.append("event_date", date);
    formData.append("venue", venue);

    let url = "add_event.php";

    if (isEditing) {
        url = "update_event.php";
        formData.append("id", eventId.value);
    }

    submitBtn.disabled = true;
    showMessage(isEditing ? "Updating event..." : "Adding event...", "success");

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok || result.status !== "success") {
            throw new Error(result.message || "Operation failed.");
        }

        resetForm();
        showMessage(result.message, "success");
        await loadEvents();
    } catch (error) {
        showMessage(error.message || "Something went wrong.", "error");
    } finally {
        submitBtn.disabled = false;
    }
});

async function deleteEvent(id) {
    if (!confirm("Are you sure you want to delete this event?")) {
        return;
    }

    showMessage("Deleting event...", "success");

    const formData = new FormData();
    formData.append("id", id);

    try {
        const response = await fetch("delete_event.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok || result.status !== "success") {
            throw new Error(result.message || "Unable to delete event.");
        }

        showMessage(result.message, "success");
        await loadEvents();
    } catch (error) {
        showMessage(error.message || "Something went wrong.", "error");
    }
}

loadEvents();
