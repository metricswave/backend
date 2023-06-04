---
id: bccc9735-801b-4900-b815-6dd49081a8bc
blueprint: documentation
title: 'Triggers: Calendar Time To Leave'
parent: 3826e861-c213-4482-8ab7-0e3add2a4d7f
updated_by: 1
updated_at: 1685870859
short_content: 'This trigger will send you a notification at departure time so that you arrive on time to all the events in your calendar.'
---
Receive a Time To Leave notification for each event with a location in your calendar.

**You will need to connect your Google Calendar service before enabling this trigger.**

In the trigger you can configure the default location and also the travel mode.

### Available data

- **{origin}** Departure address
- **{destination}** Address where you want to go
- **{travel_mode}** It could be: `driving`, `walking`, `transit` or `bicycling`.
- **{arrival_time}** Time you want to arrive at destination in HH:MM format 
- **{distance}** Distance in a readable format, example `15 km`.
- **{meters}** Distance in meters, example `15000`.
- **{duration}** Duration in a readable format, example `15 min`.
- **{seconds}** Duration in seconds, example `900`.
- **event.title** Title of the current event.
- **event.date** Date of the event in format `DD-MM-YYYY`.
- **event.time** Time of the event in format `HH:MM`.

---

[← More about triggers](/documentation/triggers/)