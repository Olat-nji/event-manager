import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";

import {
    fetchEvents,
    handleEventClick,
    JoinEvent,
    LeaveEvent,
} from "./calendar/actions";

import { renderEventContent, changeCalendarView } from "./calendar/ui";

var calendar;

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    if (!calendarEl || calendarEl.hasAttribute("data-initialized")) {
        return; // Prevent reinitialization
    }

    calendarEl.setAttribute("data-initialized", "true"); // Mark as initialized

    calendar = new Calendar(calendarEl, {
        dayMaxEventRows: true,
        headerToolbar: {
            start: "title",
            end: "prev,next",
        },
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        events: fetchEvents,
        datesSet: () => calendar.refetchEvents(),
        eventClick: handleEventClick,
        eventContent: renderEventContent,
    });

    calendar.render();
});

window.changeCalendarView = changeCalendarView;
window.JoinEvent = JoinEvent;
window.LeaveEvent = LeaveEvent;

export { calendar };
