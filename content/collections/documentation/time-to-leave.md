---
id: 18722929-02d6-490f-8572-5892294441d3
blueprint: documentation
title: 'Triggers: Time To Leave'
parent: c46aafa5-b49b-4019-a55d-2074ae56570d
updated_by: 1
updated_at: 1683696540
short_content: 'Receive a notification 15 min before departure time to arrive at your destination on time.'
---
Never be late to your destination, receive a notification 15 minutes before departure time so you can leave and arrive at your destination on time.

Also, this notification is configurable. You can use any of the next parameters inside the title or content to make it yours.


### Available data

- **{origin}** Departure address
- **{destination}** Address where you want to go
- **{travel_mode}** It could be: `driving`, `walking`, `transit` or `bicycling`.
- **{arrival_time}** Time you want to arrive at destination in HH:MM format 
- **{distance}** Distance in a readable format, example `15 km`.
- **{meters}** Distance in meters, example `15000`.
- **{duration}** Duration in a readable format, example `15 min`.
- **{seconds}** Duration in seconds, example `900`.


---

[← More about triggers](/documentation/triggers/)