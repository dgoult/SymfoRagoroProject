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

            let modal = $('#calendarModal');
            let form = modal.find('form');
            let listElement = document.getElementById('commentaire_liste');
            let ulElement = document.createElement('ul');

            // On récupère les commentaire associé au cours
            fetch(info.event.url)
                .then(response => response.json())
                .then(data => {
                    let comments;
                    comments = data.comments.map(comment => JSON.parse(comment));
                    console.log(comments);

                    comments.forEach(comment => {
                        const liElement = document.createElement('li');
                        liElement.textContent = "'" + comment.commentaire_text + "' - Envoyé le " + comment.date_creation.date + ' par ' + comment.author;
                        ulElement.appendChild(liElement);
                    });

                    listElement.appendChild(ulElement);
                })
                .catch(error => console.error(error));

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

            // A la fermeture de la modale, on retire la fonction du submit pour éviter les doublons d'envois)
            modal.on('hidden.bs.modal', function() {
                form.off('submit');
                listElement.removeChild(ulElement);
            });
            // show the modal window
            modal.modal('show');

        }

    });

    calendar.render();
});