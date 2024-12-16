$(document).ready(function () {
    const defaultStartDate = moment('2016-04-01');
    const defaultEndDate = moment('2016-07-01');

    $('#dateRange').daterangepicker({
        opens: 'right',
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: defaultStartDate,
        endDate: defaultEndDate
    });
});

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed.');

    let currentPage = 1;
    const limit = 10;

    const applyFiltersButton = document.getElementById('applyFilters');

    if (!applyFiltersButton) {
        console.error('Apply Filters button not found!');
        return;
    }

    const dateRange = document.getElementById('dateRange').value;
    const [startDate, endDate] = dateRange.split(' - ');

    applyFiltersButton.addEventListener('click', function () {
        currentPage = 1; // Reset to the first page when filters are applied
        fetchPatients(currentPage);
    });

    function fetchPatients(page = 1) {
        console.log('Apply Filters button clicked!');

        // Collect filter values
        const filters = {
            PatientId: document.getElementById('patientIdInput').value.trim(),
            AppointmentID: document.getElementById('appointmentIdInput').value.trim(),
            dateRange: document.getElementById('dateRange').value.trim(),
            ShowedUp: document.querySelector('input[name="showedUp"]:checked')?.value,
            smsReceived: document.querySelector('input[name="smsReceived"]:checked')?.value,
            dateMin: document.getElementById('dateMin').value,
            dateMax: document.getElementById('dateMax').value,
            limit: limit,
            page: page
        };

        console.log('Filters:', filters);

        // Send filters to the backend using fetch
        fetch('filter_appointments.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Filtered data:', data);
                displayAppointments(data.data);
                updatePaginationControls(data.totalCount, data.currentPage, data.limit);
                document.getElementById('resultCount').textContent = `Results: ${data.totalCount}`;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while applying filters.');
            });
    }



    // Function to display appointments (update this based on your table structure)
    function displayAppointments(appointments) {
        const tableBody = document.getElementById('appointmentsTableBody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (!appointments || appointments.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7">No appointments found</td></tr>';
            return;
        }

        appointments.forEach(appointment => {

            const row = `
                <tr>
                    <td>${appointment.Patient.PatientId}</td>
                    <td>${appointment.AppointmentID}</td>
                    <td>${appointment.ScheduledDay}</td>
                    <td>${appointment.AppointmentDay}</td>
                    <td>${appointment.DateDiff}</td>
                    <td>${appointment.SMS_received ? 'Yes' : 'No'}</td>
                    <td>${appointment.Showed_up ? 'Yes' : 'No'}</td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    function updatePaginationControls(totalCount, currentPage, limit) {
        const pagination = document.getElementById('paginationControls');
        const totalPages = Math.ceil(totalCount / limit);

        let buttons = '';

        if (totalPages <= 1) {
            pagination.innerHTML = ''; // No need for pagination if only one page
            return;
        }

        // Helper function to create a page button
        const createPageButton = (page) => {
            return `<button class="btn btn-sm btn-${page === currentPage ? 'primary' : 'light'} pagination-btn" data-page="${page}">${page}</button>`;
        };

        // First page button
        if (currentPage > 3) {
            buttons += createPageButton(1);
            if (currentPage > 4) {
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>';
            }
        }

        // Middle page buttons (current page and up to 2 pages before and after)
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
            buttons += createPageButton(i);
        }

        // Last page button
        if (currentPage < totalPages - 2) {
            if (currentPage < totalPages - 3) {
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>';
            }
            buttons += createPageButton(totalPages);
        }

        // Previous and Next buttons
        const prevButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.max(1, currentPage - 1)}">&laquo;</button>`;
        const nextButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.min(totalPages, currentPage + 1)}">&raquo;</button>`;

        pagination.innerHTML = prevButton + buttons + nextButton;

        // Add event listeners to the buttons
        document.querySelectorAll('.pagination-btn').forEach(button => {
            button.addEventListener('click', function () {
                currentPage = parseInt(this.getAttribute('data-page'));
                fetchPatients(currentPage);
            });
        });
    }

    // Initial fetch on page load
    fetchPatients(currentPage);

    // Reset button functionality
    document.getElementById('resetFilters').addEventListener('click', function () {
        // Reset showed-up radio buttons
        const showedUpRadios = document.querySelectorAll('input[name="showedUp"]');
        showedUpRadios.forEach(radio => radio.checked = false);

        const smsReceivedRadios = document.querySelectorAll('input[name="smsReceived"]');
        smsReceivedRadios.forEach(radio => radio.checked = false);

        document.getElementById('dateMin').value = '';
        document.getElementById('dateMax').value = '';

        const defaultStartDate = moment('2016-04-01');
        const defaultEndDate = moment('2016-07-01');

        $('#dateRange').data('daterangepicker').setStartDate(defaultStartDate);
        $('#dateRange').data('daterangepicker').setEndDate(defaultEndDate);
        $('#dateRange').val(`${defaultStartDate.format('YYYY-MM-DD')} - ${defaultEndDate.format('YYYY-MM-DD')}`);

        document.getElementById('appointmentIdInput').value = '';
        document.getElementById('appointmentIdInput').textContent = 'Enter Appointment ID';

        document.getElementById('patientIdInput').value = '';
        document.getElementById('patientIdInput').textContent = 'Enter Patient ID';

    });

});