<div>
  <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'timeGridDay' : 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events),
                eventClick: function(info) {    
                    if (info.event.url) {
                        window.open(info.event.url, '_self');
                        return false;
                    }
                },  
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },
                slotMinTime: '01:00:00',
                slotMaxTime: '25:00:00',
                nowIndicator: true,
                navLinks: true,
                editable: false,
                dayMaxEvents: true,
                height: 'auto'
            });
            
            calendar.render();
        });
    </script>
</div>
