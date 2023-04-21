import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
// import "./index.css"; // this will create a calendar.css file reachable to 'encore_entry_link_tags'

import jquery from 'jquery';
import * as calEvent from "@popperjs/core";
window.$ = window.jQuery = jquery;

document.addEventListener("DOMContentLoaded", () => {
    let calendarEl = document.getElementById("calendar-holder");

    let { eventsUrl } = calendarEl.dataset;

    let calendar = new Calendar(calendarEl, {
        editable: true,
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({}) // pass your parameters to the subscriber
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
        },
        initialView: "timeGridWeek",
        locale: 'fr',
        //navLinks: true, // can click day/week names to navigate views
        plugins: [ interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin ],
        timeZone: "UTC",
        weekends: false,

        eventClick: function(info) {
            // permet d'empêcher l'ouverture du lien dans la property 'url'
            info.jsEvent.preventDefault();
            let calEvent = info.event;

            $('#calendarModal .modal-body').html('<p><strong>Cours:</strong> ' + calEvent.title + '</p>' +
                '<p><strong>Début:</strong> ' + calEvent.start + '</p>' +
                '<p><strong>Fin:</strong> ' + calEvent.end + '</p>' +
                '<p><strong>Description:</strong> ' + calEvent.extendedProps.description + '</p>' +
                '<p>Voir les <a href="' + calEvent.url + '">détails</a></p>'
            );
            $('#calendarModal').modal('show');
        }
    });

    calendar.render();
});