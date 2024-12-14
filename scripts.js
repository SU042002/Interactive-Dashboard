document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed.');

    const applyFiltersButton = document.getElementById('applyFilters');

    if (!applyFiltersButton) {
        console.error('Apply Filters button not found!');
        return;
    }

    applyFiltersButton.addEventListener('click', function () {
        console.log('Apply Filters button clicked!');

        // Collect filter values
        const filters = {
            Diabetes: document.getElementById('diabetesCheckbox').checked,
            Hipertension: document.getElementById('hipertensionCheckbox').checked,
            Alcoholism: document.getElementById('alcoholismCheckbox').checked,
            Handcap: document.getElementById('handcapCheckbox').checked,
            AgeMin: document.getElementById('ageMin').value,
            AgeMax: document.getElementById('ageMax').value,
            Gender: document.querySelector('input[name="gender"]:checked')?.value,
            ScholarshipTrue: document.getElementById('scholarshipTrue').checked,
            ScholarshipFalse: document.getElementById('scholarshipFalse').checked,
            Neighbourhood: document.getElementById('neighbourhoodSelect').value
        };

        console.log('Filters:', filters);

        // Example: Send filters to the backend using fetch
        fetch('filter_patients.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(filters)
        })
            .then(response => response.json())
            .then(data => {
                console.log('Filtered data:', data);
                displayPatients(data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while applying filters.');
            });
    });

    // Function to display patients (update this based on your table structure)
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
});
