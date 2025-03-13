<?php

namespace App\Enums;

enum EventResponseEnum: string
{
    //Success Responses
    case SUCCESS_REGISTERED = 'You have been successfully registered for this event.';
    case SUCCESS_UNREGISTERED = 'You have successfully unregistered from this event.';
    case SUCCESS_WAITLISTED = 'You have been added to the waitlist for this event.';
    case SUCCESS_PROMOTED = 'Waitlisted users promoted to active participants.';
    
    //Error Responses
    case ERROR_NOT_REGISTERED = 'You are currently not registered for this event.';
    case ERROR_NO_SLOTS = 'No available slots for waitlist promotion.';
    case ERROR_NO_WAITLIST = 'No users in the waitlist available for promotion.';
    case ERROR_WAITLIST_FULL = 'Waitlist is at full capacity.';
    case ERROR_ALREADY_JOINED = 'You have already joined this event.';
    case ERROR_SAME_DAY_EVENT = 'Unfortunately, you cannot join this event as you have another event on the same day.';
    case ERROR_EVENT_WAITLIST_FULL = 'This event and its waitlist are currently full. Please explore other available events.';
    case ERROR_NOT_PERMITTED = 'You are not permitted to perform this action.';
}
