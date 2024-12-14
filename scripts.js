document.getElementById('searchButton').addEventListener('click', function () {
    const patientId = document.getElementById('searchInput').value.trim();

    if (patientId === '') {
        alert('Please enter a PatientID');
        return;
    }

    fetch('search_patient.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `PatientID=${encodeURIComponent(patientId)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                document.getElementById('patientTableBody').innerHTML = '';
            } else {
                displayPatient(data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while searching for the patient');
        });
});

function displayPatient(patient) {
    const tableBody = document.getElementById('patientTableBody');
    tableBody.innerHTML = `
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
}
