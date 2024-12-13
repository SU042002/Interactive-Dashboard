// Function to create Gender Distribution Chart
function createGenderChart(maleCount, femaleCount) {
    const ctx = document.getElementById('genderChart').getContext('2d');
    const doughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [maleCount, femaleCount],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Gender Distribution'
            }
        }
        }
    });
}

function createAppointmentChart(noShowCount, showCount) {
    const ctx = document.getElementById('appointmentChart').getContext('2d');
    const doughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['No-Show', 'Show'],
            datasets: [{
                data: [noShowCount, showCount],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Appointment Status'
                }
            }
        }
    });
}

function createTop5NoShowsByNeighbourhoodChart(neighbourhoods, noShows) {
    const ctx = document.getElementById('getTop5NoShowsByNeighbourhood').getContext('2d');
    const doughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: neighbourhoods,
            datasets: [{
                data: noShows,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Top 5 No-Shows by Neighbourhood'
                }
            }
        }
    });
}