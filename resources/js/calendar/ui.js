import { calendar } from "../all-events";

export function renderEventContent(info) {
    let statusIcon = "";
    let classes = "";
    const eventData = info.event.extendedProps.data;

    // Determine status icons based on user participation
    if (eventData.is_joined) {
        statusIcon = `<span class="inline-flex items-center bg-green-600 dark:bg-green-300 text-xs font-semibold px-1.5 py-1.5 rounded-full"></span>`;
    } else if (eventData.is_waitlisted) {
        statusIcon = `<span class="inline-flex items-center bg-orange-600 dark:bg-orange-300 text-xs font-semibold px-1.5 py-1.5 rounded-full"></span>`;
    }

    // Determine event background color based on availability
    if (eventData.participants_count < eventData.capacity) {
        classes = "bg-green-300 dark:bg-green-700"; // Available
    } else if (eventData.waitlist_count < eventData.waitlist_capacity) {
        classes = "bg-yellow-300 dark:bg-yellow-600"; // Waitlist open
    } else {
        classes = "bg-gray-500 dark:bg-gray-600"; // Fully booked
    }

    return {
        html: `
    <div class="p-1 px-3 flex align-center justify-between w-full space-x-2 cursor-pointer ${classes} rounded-full shadow-md">
        <span class="truncate-text">${info.event.title}</span>
        <div>${statusIcon}</div>
    </div>`,
    };
}

export function changeCalendarView(view) {
    const views = {
        month: "dayGridMonth",
        week: "timeGridWeek",
        day: "timeGridDay",
    };
    calendar.changeView(views[view] || "dayGridMonth");
    Alpine.store("groupBy", view);
}
