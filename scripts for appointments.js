$(document).ready(function () { // Wait for the document to be fully loaded
    const defaultStartDate = moment('2016-04-01'); // Default start date
    const defaultEndDate = moment('2016-07-01'); // Default end date

    $('#dateRange').daterangepicker({ // Initialize daterangepicker
        opens: 'right',  // Set the calendar to open on the right side
        locale: { // Set the locale
            format: 'YYYY-MM-DD' // Set the date format
        },
        startDate: defaultStartDate, // Set the start date
        endDate: defaultEndDate // Set the end date
    });
});

// Ensure that the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function () { // Wait for the DOM to be fully loaded
    console.log('DOM fully loaded and parsed.'); // Log a message to the console to confirm that the DOM is fully loaded

    let currentPage = 1; // Current page number
    const limit = 10; // Number of records per page

    const applyFiltersButton = document.getElementById('applyFilters'); // Get the Apply Filters button

    if (!applyFiltersButton) { // If the Apply Filters button is not found
        console.error('Apply Filters button not found!'); // Log an error message to the console
        return; // Exit the function
    } // End of if statement

    const dateRange = document.getElementById('dateRange').value; // Get the date range input value
    const [startDate, endDate] = dateRange.split(' - '); // Split the date range into start and end dates

    applyFiltersButton.addEventListener('click', function () { // Add a click event listener to the Apply Filters button
        currentPage = 1; // Reset to the first page when filters are applied
        fetchPatients(currentPage); // Fetch patients with the current page number
    });

    function fetchPatients(page = 1) { // Define a function to fetch patients
        console.log('Apply Filters button clicked!'); // Log a message to the console when the Apply Filters button is clicked

        // Collect filter values
        const filters = { // Define an object to store the filter values
            PatientId: document.getElementById('patientIdInput').value.trim(), // Get the patient ID input value and trim any leading or trailing whitespace
            AppointmentID: document.getElementById('appointmentIdInput').value.trim(), // Get the appointment ID input value and trim any leading or trailing whitespace
            dateRange: document.getElementById('dateRange').value.trim(), // Get the date range input value and trim any leading or trailing whitespace
            ShowedUp: document.querySelector('input[name="showedUp"]:checked')?.value, // Get the value of the checked radio button for showed up
            smsReceived: document.querySelector('input[name="smsReceived"]:checked')?.value, // Get the value of the checked radio button for SMS received
            dateMin: document.getElementById('dateMin').value, // Get the minimum date value
            dateMax: document.getElementById('dateMax').value, // Get the maximum date value
            limit: limit, // Set the limit
            page: page // Set the page number
        };

        console.log('Filters:', filters); // Log the filter values to the console

        // Send filters to the backend using fetch
        fetch('filter_appointments.php', { // Fetch the data from the filter_appointments.php file
            method: 'POST', // Use the POST method
            headers: { 'Content-Type': 'application/json' }, // Set the content type to JSON
            body: JSON.stringify(filters) // Convert the filters object to a JSON string and send it in the body of the request
        })
            .then(response => response.json()) // Parse the JSON response
            .then(data => { // Handle the data
                console.log('Filtered data:', data); // Log the filtered data to the console
                displayAppointments(data.data); // Display the appointments
                updatePaginationControls(data.totalCount, data.currentPage, data.limit); // Update the pagination controls
                document.getElementById('resultCount').textContent = `Results: ${data.totalCount}`; // Display the total count of results
            })
            .catch(error => { // Handle any errors
                console.error('Error:', error); // Log the error to the console
                alert('An error occurred while applying filters.'); // Show an alert to the user
            });
    }



    // Function to display appointments (update this based on your table structure)
    function displayAppointments(appointments) { // Define a function to display appointments
        const tableBody = document.getElementById('appointmentsTableBody'); // Get the table body element
        tableBody.innerHTML = ''; // Clear existing rows from the table

        if (!appointments || appointments.length === 0) { // If there are no appointments
            tableBody.innerHTML = '<tr><td colspan="7">No appointments found</td></tr>'; // Display a message in the table
            return; // Exit the function
        } // End of if statement

        appointments.forEach(appointment => { // Loop through each appointment
            // Create a row for the appointment
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
            tableBody.insertAdjacentHTML('beforeend', row); // Add the row to the table
        });
    }

    function updatePaginationControls(totalCount, currentPage, limit) { // Define a function to update the pagination controls
        const pagination = document.getElementById('paginationControls');
        const totalPages = Math.ceil(totalCount / limit);

        let buttons = ''; // Initialize the buttons variable

        if (totalPages <= 1) {
            pagination.innerHTML = ''; // No need for pagination if only one page
            return;
        }

        // Helper function to create a page button
        const createPageButton = (page) => { // Define a function to create a page button
            return `<button class="btn btn-sm btn-${page === currentPage ? 'primary' : 'light'} pagination-btn" data-page="${page}">${page}</button>`; // Return the button HTML
        };

        // First page button
        if (currentPage > 3) { // If the current page is greater than 3
            buttons += createPageButton(1); // Add the first page button
            if (currentPage > 4) { // If the current page is greater than 4
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>';
            } // End of if statement
        }

        // Middle page buttons (current page and up to 2 pages before and after)
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) { // Loop through the pages
            buttons += createPageButton(i); // Add the page button
        }

        // Last page button
        if (currentPage < totalPages - 2) { // If the current page is less than 2 pages before the last page
            if (currentPage < totalPages - 3) { // If the current page is less than 3 pages before the last page
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>'; // Add an ellipsis
            }
            buttons += createPageButton(totalPages); // Add the last page button
        }

        // Previous and Next buttons
        const prevButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.max(1, currentPage - 1)}">&laquo;</button>`; // Create the previous button
        const nextButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.min(totalPages, currentPage + 1)}">&raquo;</button>`; // Create the next button

        pagination.innerHTML = prevButton + buttons + nextButton; // Set the pagination controls

        // Add event listeners to the buttons
        document.querySelectorAll('.pagination-btn').forEach(button => { // Select all pagination buttons and loop through them
            button.addEventListener('click', function () { // Add a click event listener to the button
                currentPage = parseInt(this.getAttribute('data-page')); // Get the page number from the button
                fetchPatients(currentPage); // Fetch patients for the selected page
            });
        });
    }

    // Initial fetch on page load
    fetchPatients(currentPage);

    // Reset button functionality
    document.getElementById('resetFilters').addEventListener('click', function () { // Add a click event listener to the Reset Filters button
        // Reset showed-up radio buttons
        const showedUpRadios = document.querySelectorAll('input[name="showedUp"]'); // Select all showed-up radio buttons
        showedUpRadios.forEach(radio => radio.checked = false); // Uncheck all showed-up radio buttons

        const smsReceivedRadios = document.querySelectorAll('input[name="smsReceived"]'); // Select all SMS received radio buttons
        smsReceivedRadios.forEach(radio => radio.checked = false); // Uncheck all SMS received radio buttons

        document.getElementById('dateMin').value = ''; // Clear the minimum date input
        document.getElementById('dateMax').value = ''; // Clear the maximum date input

        const defaultStartDate = moment('2016-04-01'); // Default start date to encompass all data
        const defaultEndDate = moment('2016-07-01'); // Default end date to encompass all data

        $('#dateRange').data('daterangepicker').setStartDate(defaultStartDate); // Set the start date in the date range picker
        $('#dateRange').data('daterangepicker').setEndDate(defaultEndDate); // Set the end date in the date range picker
        $('#dateRange').val(`${defaultStartDate.format('YYYY-MM-DD')} - ${defaultEndDate.format('YYYY-MM-DD')}`); // Set the value of the date range input

        document.getElementById('appointmentIdInput').value = ''; // Clear the appointment ID input
        document.getElementById('appointmentIdInput').textContent = 'Enter Appointment ID'; // Set the placeholder text for the appointment ID input

        document.getElementById('patientIdInput').value = ''; // Clear the patient ID input
        document.getElementById('patientIdInput').textContent = 'Enter Patient ID'; // Set the placeholder text for the patient ID input

    });

});