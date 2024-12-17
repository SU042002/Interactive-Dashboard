// This file contains the functions to create the charts using Chart.js
// Stored all charts in separate functions to make the code more readable and in one place
function createGenderChart(maleCount, femaleCount) { // Function to create a doughnut chart
    const ctx = document.getElementById('genderChart').getContext('2d'); // Get the canvas element by its ID
    const doughnutChart = new Chart(ctx, { // Create a new Chart object
        type: 'doughnut', // Set the chart type to 'doughnut'
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [maleCount, femaleCount], // Data for the chart taken from the parameters
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)', // Background color for the first data point
                    'rgba(255, 99, 132, 0.5)' // Background color for the second data point
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)', // Border color for the first data point
                    'rgba(255, 99, 132, 1)' // Border color for the second data point
                ],
                borderWidth: 1 // Border width for the data points
            }]
        },
        options: {
            responsive: true, // Make the chart responsive
            plugins: { // Add plugins to the chart
                legend: {
                    position: 'top' // Set the position of the legend to the top
                },
                title: {
                    display: true, // Display the title of the chart
                    text: 'Gender Distribution' // Set the title of the chart
                }
            }
        }
    });
}

function createAppointmentChart(noShowCount, showCount) { // Function to create a doughnut chart
    const ctx = document.getElementById('appointmentChart').getContext('2d'); // Get the canvas element by its ID
    const doughnutChart = new Chart(ctx, { // Create a new Chart object
        type: 'doughnut', // Set the chart type to 'doughnut'
        data: {
            labels: ['No-Show', 'Show'], // Labels for the data points
            datasets: [{
                data: [noShowCount, showCount], // Data for the chart taken from the parameters
                // Setting colours for the data points
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
            responsive: true, // Make the chart responsive
            plugins: {
                legend: {
                    position: 'top' // Set the position of the legend to the top
                },
                title: {
                    display: true, // Display the title of the chart
                    text: 'Appointment Status' // Set the title of the chart
                }
            }
        }
    });
}

function createTop5NoShowsByNeighbourhoodChart(neighbourhoods, noShows) { // Function to create a doughnut chart
    const ctx = document.getElementById('getTop5NoShowsByNeighbourhood').getContext('2d'); // Get the canvas element by its ID
    const doughnutChart = new Chart(ctx, { // Create a new Chart object
        type: 'doughnut', // Set the chart type to 'doughnut'
        data: {
            labels: neighbourhoods, // Labels for the data points taken from the parameters
            datasets: [{
                data: noShows,
                // Setting colours for the data points
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
            responsive: true, // Make the chart responsive
            plugins: {
                legend: {
                    position: 'top' // Set the position of the legend to the top
                },
                title: {
                    display: true, // Display the title of the chart
                    text: 'Top 5 No-Shows by Neighbourhood' // Set the title of the chart
                }
            }
        }
    });
}

// Function to create a horizontal bar chart
function getTotalPatientsWithConditionsChart(diabetes, hypertension, alcoholism, handicap) { // Function to create a horizontal bar chart
    const ctx = document.getElementById('totalPatientsWithConditions').getContext('2d'); // Get the canvas element by its ID
    new Chart(ctx, {
        type: 'bar', // Set the chart type to 'bar'
        data: {
            labels: ['Diabetes', 'Hypertension', 'Alcoholism', 'Handicap'], // Labels for the data points
            datasets: [{
                label: 'Number of Patients',
                data: [diabetes, hypertension, alcoholism, handicap], // Data for the chart taken from the parameters
                // Setting colours for the data points
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Make the chart responsive
            indexAxis: 'y', // Makes the bar chart horizontal
            scales: {
                x: {
                    beginAtZero: true, // Start the x-axis at 0
                    title: {
                        display: true, // Display the title of the x-axis
                        text: 'Number of Patients' // Set the title of the x-axis
                    }
                },
                y: {
                    title: {
                        display: true, // Display the title of the y-axis
                        text: 'Condition' // Set the title of the y-axis
                    }
                }
            },
            plugins: {
                title: {
                    display: true, // Display the title of the chart
                    text: 'Patients with Conditions' // Set the title of the chart
                },
                legend: {
                    display: false // Hide the legend
                }
            }
        }
    });
}

function getAppointmentsOverMonthsCharts(months, totals) {
    const ctx = document.getElementById('appointmentsChart').getContext('2d'); // Get the canvas element by its ID
    new Chart(ctx, {
        type: 'line', // Set the chart type to 'line'
        data: {
            labels: months,
            datasets: [{
                data: totals,
                // Setting colours for the data points
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Appointments'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Appointments Over Months'
                },
                legend: {
                    display: false,
                }
            }
        }
    });
}

function getAppointmentsByAgeGroupCharts(neighborhoods, PopulationCount) {
    const ctx = document.getElementById('ageGroupChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: neighborhoods,
            datasets: [{
                data: PopulationCount,
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
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Appointments'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Age Group'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Appointments by Patient Age Group'
                },
                legend: {
                    display: false,
                }
            }
        }
    });
}

function getNoShowRatesByGenderCharts(gender, rate) {
    const ctx = document.getElementById('getNoShowRatesByGenderChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: gender,
            datasets: [{
                label: 'Total Appointments',
                data: rate,
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
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'No-Shows Rate (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Age Group'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'No-Show Rates between Males and Females'
                },
                legend: {
                    display: false,
                }
            }
        }
    });
}
function createShowUpRateChart(smsCategories, showUpRatesData) {
    const ctx = document.getElementById('getShowUpRatesBySMSCharts').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: smsCategories,
            datasets: [{
                data: showUpRatesData,
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Show-Ups Rate (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'SMS Reminder'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Show-Up Rates for Patients by SMS Reminder'
                },
                legend: {
                    display: false,
                }
            }
        }
    });
}

function createNoShowScholarshipChart(categories, rates) {
    const ctx = document.getElementById('noShowScholarshipChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'No-Show Rate (%)',
                data: rates,
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'No-Show Rate (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Scholarship Status'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'No-Show Rates for Patients with and without Scholarships'
                }
            }
        }
    });
}

function createTopNeighborhoodsChart(categories, counts) {
    const ctx = document.getElementById('topNeighborhoodsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Population Count',
                data: counts,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
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
                    'rgba(153, 102, 255, 1)',
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
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Population Count'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Neighborhoods'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Top 10 Neighborhoods by Population Count'
                }
            }
        }
    });
}

function createTopShowRatesChart(categories, rates) {
    const ctx = document.getElementById('topShowRatesChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut', // Change chart type to 'doughnut'
        data: {
            labels: categories,
            datasets: [{
                label: 'Show Rate (%)',
                data: rates,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(199, 199, 199, 0.6)',
                    'rgba(83, 102, 255, 0.6)',
                    'rgba(255, 99, 64, 0.6)',
                    'rgba(102, 255, 204, 0.6)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(255, 99, 64, 1)',
                    'rgba(102, 255, 204, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 Show-Ups by Neighborhood'
                },
                legend: {
                    position: 'top'
                },
            }
        }
    });
}

function createScholarshipChart(categories, counts) {
    const ctx = document.getElementById('scholarshipChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: categories,
            datasets: [{
                label: 'Patients by Scholarship Status',
                data: counts,
                backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Patients with and without Scholarships'
                },
                legend: {
                    position: 'top'
                }
            }
        }
    });
}







