<?php
require 'db_connection.php';
$db = new Database();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="charts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</head>
<body>

<div class="container-fluid" style="background-color: #dedcdb">

    <div class="row">
        <!--    Sidebar for navigation-->
        <div class="d-flex col-sm-2 flex-column flex-shrink-0 p-3 text-white" style="min-height: 100vh; background-color: #151f47;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <div class="logo" style="padding-right: 14px">
                    <img src="img/logo.png" alt="Logo" width="40" height="32" class="me-2">
                </div>
                <span class="fs-4">Clinic: Interactive Dashboard</span>
            </a>
            <hr>
            <p>Images used on the website were obtained from <a href="https://www.freepik.com/">FreePik</a>. </p>
            <p>Created by Sameer Uddin (20004135)</p>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#overview"></use></svg>
                        Overview
                    </a>
                </li>
                <li>
                    <a href="patients.php" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#patients"></use></svg>
                        Patients
                    </a>
                </li>
                <li>
                    <a href="appointments.php" class="nav-link text-white active">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#appointments"></use></svg>
                        Appointments
                    </a>
                </li>
                <li>
                    <a href="neighbourhoods.php" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#neighbourhoods"></use></svg>
                        Neighbourhoods
                    </a>
                </li>
            </ul>


        </div>

        <!--        Dashboard Content-->
        <div class="col-sm-10">

            <div class="row">
                <div class="col-sm-9 mx-auto" style="padding-top: 40px">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5>Filters</h5>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="patientIdInput" placeholder="Enter Appointment ID">
                                </div>

                                <div class="col-sm-4 d-flex justify-content-end">
                                    <span>
                                        <span class="badge text-bg-secondary" id="resultCount">Results: 0</span>
                                    </span>
                                </div>
                            </div>

                            <hr>

                            <div class="row">

                                <div class="col-sm-2">
                                    <h6>Showed Up</h6>
                                    <hr>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="showStatus" value="True">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                True
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="showStatus" value="False">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                False
                                            </label>
                                        </div>
                                    </div>
                                </div>





                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-4">
                                    <button type="button" id="resetFilters" class="btn btn-warning">Reset Filters</button>
                                </div>

                                <div class="col-sm-4">
                                    <label for="resultLimitRange" class="form-label">
                                        Select Results Limit: <span id="resultLimitValue">1</span>
                                    </label>
                                    <input type="range" class="form-range" id="resultLimitRange" min="1" max="1000" step="1" value="1">
                                </div>

                                <div class="col-sm-4 justify-content-end d-sm-flex">
                                    <span>
                                    <button type="button" id="applyFilters" class="btn btn-primary">Apply Filters</button>
                                    </span>
                                </div>
                            </div>


                            </div>





                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mx-auto" style="padding-top: 40px">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">PatientID</th>
                                        <th scope="col">Appointment ID</th>
                                        <th scope="col">Scheduled Day</th>
                                        <th scope="col">Appointment Day</th>
                                        <th scope="col">Date Difference</th>
                                        <th scope="col">SMS Received</th>
                                        <th scope="col">Showed-Up</th>
                                    </tr>
                                    </thead>
                                    <tbody id="appointmentsTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <footer style="padding-top: 40px"></footer>

            </div>
        </div>



    </div>
    <script src="scripts for appointments.js?v=1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>