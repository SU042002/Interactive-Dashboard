document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed.');

    let currentPage = 1;
    const limit = 10;

    const applyFiltersButton = document.getElementById('applyFilters');

    if (!applyFiltersButton) {
        console.error('Apply Filters button not found!');
        return;
    }

    applyFiltersButton.addEventListener('click', function () {
        currentPage = 1; // Reset to the first page when filters are applied
        fetchPatients(currentPage);
    });

    function fetchPatients(page = 1) {
        console.log('Fetching patients for page:', page);

        // Collect filter values
        const filters = {
            PatientId: document.getElementById('patientIdInput').value.trim(),
            Diabetes: document.getElementById('diabetesCheckbox').checked,
            Hipertension: document.getElementById('hypertensionCheckbox').checked,
            Alcoholism: document.getElementById('alcoholismCheckbox').checked,
            Handcap: document.getElementById('handcapCheckbox').checked,
            AgeMin: document.getElementById('ageMin').value,
            AgeMax: document.getElementById('ageMax').value,
            Gender: document.querySelector('input[name="gender"]:checked')?.value,
            ScholarshipTrue: document.getElementById('scholarshipTrue').checked,
            ScholarshipFalse: document.getElementById('scholarshipFalse').checked,
            Neighbourhood: document.getElementById('neighbourhoodSelect').value,
            limit: limit,
            page: page
        };

        console.log('Filters:', filters);

        // Send filters to the backend using fetch
        fetch('filter_patients.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Filtered data:', data);
                displayPatients(data.data);
                updatePaginationControls(data.totalCount, data.currentPage, data.limit);
                document.getElementById('resultCount').textContent = `Results: ${data.totalCount}`;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while applying filters.');
            });
    }

    function displayPatients(patients) {
        const tableBody = document.getElementById('patientTableBody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (!patients || patients.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="9">No patients found</td></tr>';
            return;
        }

        patients.forEach(patient => {
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
            tableBody.innerHTML += row;
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

    document.getElementById('resetFilters').addEventListener('click', function () {
        // Reset checkboxes for medical conditions
        document.getElementById('diabetesCheckbox').checked = false;
        document.getElementById('hypertensionCheckbox').checked = false;
        document.getElementById('alcoholismCheckbox').checked = false;
        document.getElementById('handcapCheckbox').checked = false;

        // Reset age inputs
        document.getElementById('ageMin').value = '1';
        document.getElementById('ageMax').value = '1000';

        // Reset gender radio buttons
        const genderRadios = document.querySelectorAll('input[name="gender"]');
        genderRadios.forEach(radio => radio.checked = false);

        // Reset scholarship checkboxes
        document.getElementById('scholarshipTrue').checked = false;
        document.getElementById('scholarshipFalse').checked = false;

        // Reset neighbourhood dropdown to default (All)
        document.getElementById('neighbourhoodSelect').value = '';

        document.getElementById('patientIdInput').value = '';
        document.getElementById('patientIdInput').textContent = 'Enter Patient ID';

    });

});
