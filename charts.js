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

// Function to create a horizontal bar chart
function getTotalPatientsWithConditionsChart(diabetes, hypertension, alcoholism, handicap) {
    const ctx = document.getElementById('totalPatientsWithConditions').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Diabetes', 'Hypertension', 'Alcoholism', 'Handicap'],
            datasets: [{
                label: 'Number of Patients',
                data: [diabetes, hypertension, alcoholism, handicap],
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
            responsive: true,
            indexAxis: 'y', // Makes the bar chart horizontal
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Patients'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Condition'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Patients with Conditions'
                },
                legend: {
                    display: false
                }
            }
        }
    });
}

function getAppointmentsOverMonthsCharts(months, totals) {
    const ctx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                data: totals,
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







