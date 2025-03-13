document.addEventListener("alpine:init", () => {
    Alpine.store("event", {
        name: "",
        description: "",
        date: "",
        duration: "",
        location: "",
        capacity: "",
        waitlist_capacity: "",
        participants_count: "",
        waitlist_count: "",
    });

    Alpine.store("showEventModal", false);
    Alpine.store("loading", false);
    Alpine.store("groupBy", "month");
});
