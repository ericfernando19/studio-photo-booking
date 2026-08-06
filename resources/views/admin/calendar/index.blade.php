@extends('layouts.admin')

@section('title', 'Kalender Booking')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    .fc {
        font-family: 'Inter', sans-serif !important;
    }
    .fc .fc-toolbar-title {
        font-size: 1.125rem !important;
        font-weight: 600 !important;
    }
    .fc .fc-button {
        background: #4F46E5 !important;
        border-color: #4F46E5 !important;
        border-radius: 8px !important;
        font-size: 0.8125rem !important;
        font-weight: 500 !important;
        padding: 0.4rem 0.75rem !important;
    }
    .fc .fc-button:hover {
        background: #4338CA !important;
        border-color: #4338CA !important;
    }
    .fc .fc-button-active {
        background: #3730A3 !important;
        border-color: #3730A3 !important;
    }
    .fc .fc-daygrid-day {
        border-color: #E2E8F0 !important;
    }
    .fc .fc-col-header-cell {
        background: #F8FAFC;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #64748B;
    }
    .fc-event {
        cursor: pointer;
        border-radius: 6px !important;
        padding: 2px 6px !important;
        font-size: 0.75rem !important;
        font-weight: 500 !important;
    }
</style>
@endpush

@section('content')
<div class="card-admin">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:none;">
            <div class="modal-header" style="border-bottom:1px solid #E2E8F0;">
                <h5 class="modal-title" style="font-weight:600;">Detail Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2"><span style="color:#64748B;font-size:0.8125rem;">Kode</span><br><span id="modal-booking-code" style="font-family:'JetBrains Mono',monospace;font-weight:500;"></span></div>
                <div class="mb-2"><span style="color:#64748B;font-size:0.8125rem;">Customer</span><br><span id="modal-customer-name" style="font-weight:500;"></span></div>
                <div class="mb-2"><span style="color:#64748B;font-size:0.8125rem;">Status</span><br><span id="modal-status"></span></div>
                <div><span style="color:#64748B;font-size:0.8125rem;">Tanggal</span><br><span id="modal-date" style="font-weight:500;"></span></div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #E2E8F0;">
                <a href="#" id="modal-link" class="btn btn-admin btn-admin-primary">Lihat Detail</a>
                <button type="button" class="btn btn-admin" style="background:#F1F5F9;border:none;color:#64748B;" data-bs-dismiss="modal">Tutup</button>
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
                document.getElementById('modal-booking-code').textContent = info.event.title;
                document.getElementById('modal-date').textContent = info.event.startStr;
                document.getElementById('modal-status').textContent = (info.event.extendedProps.status || '');
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
