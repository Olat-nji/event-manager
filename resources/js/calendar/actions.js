import { calendar } from "../all-events";
import { showAlert, toggleLoading } from "./utils";

export function fetchEvents(fetchInfo, successCallback, failureCallback) {
    const startDate = new Date(fetchInfo.startStr)
        .toISOString()
        .replace("T", " ")
        .substring(0, 19);
    const endDate = new Date(fetchInfo.endStr)
        .toISOString()
        .replace("T", " ")
        .substring(0, 19);

    fetch(`${baseUrl}/?start=${startDate}&end=${endDate}&calendar=1`, {
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    })
        .then((response) => response.json())
        .then((events) => successCallback(events.data))
        .catch((error) => {
            console.error("Error fetching events:", error);
            failureCallback(error);
        });
}

export function handleEventClick(info) {
    info.jsEvent.preventDefault();

    Alpine.store("event", {
        name: info.event.title,
        id: info.event.id,
        ...info.event.extendedProps.data,
    });

    Alpine.store("showEventModal", true);
}

export function eventAction(type, eventId) {
    toggleLoading();
    fetch(`${baseUrl}/${eventId}/${type}`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({}),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Adjust event properties based on user action
                if (type === "join") {
                    const willBeWaitlisted =
                        data.data.participants_count + 1 >= data.data.capacity;

                    data.data.is_joined = !willBeWaitlisted;
                    data.data.is_waitlisted = willBeWaitlisted;

                    if (!willBeWaitlisted) {
                        data.data.participants_count++;
                    } else {
                        data.data.waitlist_count++;
                    }
                } else if (type === "leave" && data.data.waitlist_count > 0) {
                    // Promote a waitlisted user when a participant leaves
                    data.data.participants_count++;
                    data.data.waitlist_count--;
                }

                // Update Alpine.js store
                Alpine.store("event", data.data);

                // Update FullCalendar event properties
                let event = calendar.getEventById(data.data.id);
                if (event) {
                    event.setExtendedProp("data", data.data);
                }
            }

            showAlert(data);
        })
        .catch((error) => {
            console.error("Event action error:", error);
            showAlert({ success: false, message: "An error occurred." });
        });
}

export function JoinEvent(eventId) {
    eventAction("join", eventId);
}

export function LeaveEvent(eventId) {
    eventAction("leave", eventId);
}
