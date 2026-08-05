@extends('layouts.admin')

@section('title', 'Kalender Booking')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    .fc-event { cursor: pointer; }
    .fc-toolbar-title { font-size: 1.2rem; }
</style>
@endpush

@section('content')
<h4 class="mb-4">Kalender Booking</h4>

<div class="card shadow-sm">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="modal-booking-code"></p>
                <p id="modal-customer-name"></p>
                <p id="modal-status"></p>
                <p id="modal-date"></p>
            </div>
            <div class="modal-footer">
                <a href="#" id="modal-link" class="btn btn-primary">Lihat Detail</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locale/id.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("admin.calendar.events") }}',
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                document.getElementById('modal-booking-code').textContent = 'Kode: ' + info.event.title;
                document.getElementById('modal-date').textContent = 'Tanggal: ' + info.event.startStr;
                document.getElementById('modal-status').textContent = 'Status: ' + (info.event.extendedProps.status || '');
                document.getElementById('modal-link').href = info.event.url;
                new bootstrap.Modal(document.getElementById('bookingModal')).show();
            },
            eventDidMount: function(info) {
                var tooltip = info.event.extendedProps.status || '';
                info.el.setAttribute('title', tooltip);
            }
        });

        calendar.render();
    });
</script>
@endpush
