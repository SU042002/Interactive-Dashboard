$(document).ready(function () {
    $('#dateRange').daterangepicker({
        opens: 'right',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed.');

    const applyFiltersButton = document.getElementById('applyFilters');

    if (!applyFiltersButton) {
        console.error('Apply Filters button not found!');
        return;
    }

    const dateRange = document.getElementById('dateRange').value;
    const [startDate, endDate] = dateRange.split(' - ');

    applyFiltersButton.addEventListener('click', function () {
        console.log('Apply Filters button clicked!');

        // Collect filter values
        const filters = {
            dateRange: document.getElementById('dateRange').value.trim(),
            ShowedUp: document.querySelector('input[name="showedUp"]:checked')?.value,
            smsReceived: document.querySelector('input[name="smsReceived"]:checked')?.value,
            dateMin: document.getElementById('dateMin').value,
            dateMax: document.getElementById('dateMax').value,
            limit: parseInt(document.getElementById('resultLimitRange').value, 10)
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
                displayAppointments(data);
                document.getElementById('resultCount').textContent = `Results: ${data.length}`;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while applying filters.');
            });
    });

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

    // Reset button functionality
    document.getElementById('resetFilters').addEventListener('click', function () {
        // Reset showed-up radio buttons
        const showedUpRadios = document.querySelectorAll('input[name="showedUp"]');
        showedUpRadios.forEach(radio => radio.checked = false);

        // Reset result limit range
        document.getElementById('resultLimitRange').value = 1;
        document.getElementById('resultLimitValue').textContent = '1';
    });

    document.getElementById('resultLimitRange').addEventListener('input', function () {
        document.getElementById('resultLimitValue').textContent = this.value;
    });
});
