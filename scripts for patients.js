document.addEventListener('DOMContentLoaded', function () { // Wait for the DOM to load
    console.log('DOM fully loaded and parsed.'); // Log a message to the console

    let currentPage = 1; // Current page number
    const limit = 10; // Number of records to fetch per page

    const applyFiltersButton = document.getElementById('applyFilters'); // Get the Apply Filters button

    if (!applyFiltersButton) { // If the button is not found, log an error and return
        console.error('Apply Filters button not found!'); // Log an error message to the console
        return; // Return early
    }

    applyFiltersButton.addEventListener('click', function () { // Add a click event listener to the button
        currentPage = 1; // Reset to the first page when filters are applied
        fetchPatients(currentPage); // Call the fetchPatients function with the current page number
    });

    function fetchPatients(page = 1) { // Define a function to fetch patients
        console.log('Fetching patients for page:', page); // Log a message to the console

        // Collect filter values
        const filters = { // Create an object with filter values
            PatientId: document.getElementById('patientIdInput').value.trim(), // Get the Patient ID input value
            Diabetes: document.getElementById('diabetesCheckbox').checked, // Get the Diabetes checkbox value
            Hipertension: document.getElementById('hypertensionCheckbox').checked, // Get the Hypertension checkbox value
            Alcoholism: document.getElementById('alcoholismCheckbox').checked, // Get the Alcoholism checkbox value
            Handcap: document.getElementById('handcapCheckbox').checked, // Get the Handicap checkbox value
            AgeMin: document.getElementById('ageMin').value, // Get the minimum age input value
            AgeMax: document.getElementById('ageMax').value, // Get the maximum age input value
            Gender: document.querySelector('input[name="gender"]:checked')?.value, // Get the gender radio button value
            ScholarshipTrue: document.getElementById('scholarshipTrue').checked, // Get the Scholarship True checkbox value
            ScholarshipFalse: document.getElementById('scholarshipFalse').checked, // Get the Scholarship False checkbox value
            Neighbourhood: document.getElementById('neighbourhoodSelect').value, // Get the neighbourhood dropdown value
            limit: limit, // Set the limit
            page: page // Set the page
        };

        console.log('Filters:', filters); // Log the filters to the console

        // Send filters to the backend using fetch
        fetch('filter_patients.php', { // Fetch the filter_patients.php file
            method: 'POST', // Use the POST method
            headers: { 'Content-Type': 'application/json' }, // Set the Content-Type header
            body: JSON.stringify(filters) // Set the body to the filters object as a JSON string
        })
            .then(response => response.json()) // Parse the response as JSON
            .then(data => { // Handle the parsed data
                console.log('Filtered data:', data); // Log the data to the console
                displayPatients(data.data); // Call the displayPatients function with the data
                updatePaginationControls(data.totalCount, data.currentPage, data.limit); // Call the updatePaginationControls function with the total count, current page, and limit
                document.getElementById('resultCount').textContent = `Results: ${data.totalCount}`; // Set the result count text content
            })
            .catch(error => { // Handle any errors
                console.error('Error:', error); // Log the error to the console
                alert('An error occurred while applying filters.'); // Show an alert to the user
            });
    }

    function displayPatients(patients) { // Define a function to display patients
        const tableBody = document.getElementById('patientTableBody'); // Get the patient table body element
        tableBody.innerHTML = ''; // Clear existing rows from the table

        if (!patients || patients.length === 0) { // If there are no patients
            tableBody.innerHTML = '<tr><td colspan="9">No patients found</td></tr>'; // Display a message in the table
            return; // Return early
        } // End if statement

        patients.forEach(patient => { // Loop through each patient
            const row = `
                <tr>
                    <td>${patient.PatientId}</td>
                    <td>${patient.Age}</td>
                    <td>${patient.Gender}</td>
                    <td>${patient.Neighbourhood}</td>
                    <td>${patient.Alcoholism ? 'Yes' : 'No'}</td>
                    <td>${patient.Handcap ? 'Yes' : 'No'}</td>
                    <td>${patient.Hipertension ? 'Yes' : 'No'}</td>
                    <td>${patient.Diabetes ? 'Yes' : 'No'}</td>
                    <td>${patient.Scholarship ? 'Yes' : 'No'}</td>
                </tr>
            `;
            tableBody.innerHTML += row; // Append the row to the table body
        });
    }

    function updatePaginationControls(totalCount, currentPage, limit) { // Define a function to update pagination controls
        const pagination = document.getElementById('paginationControls'); // Get the pagination controls element
        const totalPages = Math.ceil(totalCount / limit); // Calculate the total number of pages

        let buttons = ''; // Initialize a variable to store the page buttons

        if (totalPages <= 1) { // If there is only one page
            pagination.innerHTML = ''; // No need for pagination if only one page
            return;
        }

        // Helper function to create a page button
        const createPageButton = (page) => { // Define a function to create a page button
            return `<button class="btn btn-sm btn-${page === currentPage ? 'primary' : 'light'} pagination-btn" data-page="${page}">${page}</button>`; // Return a button element
        }; // End function

        // First page button
        if (currentPage > 3) { // If the current page is greater than 3
            buttons += createPageButton(1); // Add a button for the first page
            if (currentPage > 4) { // If the current page is greater than 4
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>'; // Add an ellipsis
            } // End if statement
        } // End if statement

        // Middle page buttons (current page and up to 2 pages before and after)
        for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) { // Loop through the middle pages
            buttons += createPageButton(i); // Add a button for each page
        } // End for loop

        // Last page button
        if (currentPage < totalPages - 2) { // If the current page is less than 2 pages before the last page
            if (currentPage < totalPages - 3) { // If the current page is less than 3 pages before the last page
                buttons += '<span class="btn btn-sm btn-light disabled">...</span>'; // Add an ellipsis
            }
            buttons += createPageButton(totalPages); // Add a button for the last page
        }

        // Previous and Next buttons
        const prevButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.max(1, currentPage - 1)}">&laquo;</button>`; // Create a previous button
        const nextButton = `<button class="btn btn-sm btn-light pagination-btn" data-page="${Math.min(totalPages, currentPage + 1)}">&raquo;</button>`; // Create a next button

        pagination.innerHTML = prevButton + buttons + nextButton; // Set the pagination controls to the buttons

        // Add event listeners to the buttons
        document.querySelectorAll('.pagination-btn').forEach(button => { // Loop through each pagination button
            button.addEventListener('click', function () { // Add a click event listener to the button
                currentPage = parseInt(this.getAttribute('data-page')); // Set the current page to the button's data-page attribute
                fetchPatients(currentPage); // Call the fetchPatients function with the current page
            });
        });
    }

    // Initial fetch on page load
    fetchPatients(currentPage);

    document.getElementById('resetFilters').addEventListener('click', function () { // Add a click event listener to the Reset Filters button
        // Reset checkboxes for medical conditions
        document.getElementById('diabetesCheckbox').checked = false; // Uncheck the Diabetes checkbox
        document.getElementById('hypertensionCheckbox').checked = false; // Uncheck the Hypertension checkbox
        document.getElementById('alcoholismCheckbox').checked = false; // Uncheck the Alcoholism checkbox
        document.getElementById('handcapCheckbox').checked = false; // Uncheck the Handicap checkbox

        // Reset age inputs
        document.getElementById('ageMin').value = '1'; // Set the minimum age input value to 1
        document.getElementById('ageMax').value = '1000'; // Set the maximum age input value to

        // Reset gender radio buttons
        const genderRadios = document.querySelectorAll('input[name="gender"]'); // Get all gender radio buttons
        genderRadios.forEach(radio => radio.checked = false); // Uncheck all gender radio buttons

        // Reset scholarship checkboxes
        document.getElementById('scholarshipTrue').checked = false; // Uncheck the Scholarship True checkbox
        document.getElementById('scholarshipFalse').checked = false; // Uncheck the Scholarship False checkbox

        // Reset neighbourhood dropdown to default (All)
        document.getElementById('neighbourhoodSelect').value = ''; // Set the neighbourhood dropdown value to an empty string

        document.getElementById('patientIdInput').value = ''; // Clear the Patient ID input value when filters are reset to empty string
        document.getElementById('patientIdInput').textContent = 'Enter Patient ID'; // Set the Patient ID input placeholder text

    });

});
