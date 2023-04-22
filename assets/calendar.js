import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
// import "./index.css"; // this will create a calendar.css file reachable to 'encore_entry_link_tags'

import jquery from 'jquery';
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

            var modal = $('#calendarModal');

            // var modal = $('<div>').addClass('modal fade').attr({
            //     id: 'calendarModal',
            //     tabindex: '-1',
            //     role: 'dialog',
            //     'aria-labelledby': 'calendarModalLabel',
            //     'aria-hidden': 'true'
            // }).appendTo('body');
            // var modalDialog = $('<div>').addClass('modal-dialog').attr('role', 'document').appendTo(modal);
            // var modalContent = $('<div>').addClass('modal-content').appendTo(modalDialog);

            console.log(info.event);

            var form = modal.find('form');
            form.attr('action', info.event.url);
            form.attr('method', 'POST');
            form.on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // handle successful form submission
                        calendar.refetchEvents();
                        modal.modal('hide');
                    },
                    error: function(response) {
                        // handle form submission errors
                        console.log(response);
                    }
                });
            });
            // show the modal window
            modal.modal('show');

        }

    });

    calendar.render();
});