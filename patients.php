<?php
require 'db_connection.php'; // Database connection file
$db = new Database(); // Create a new instance of the Database class
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title> <!-- Title of the page -->
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="container-fluid" style="background-color: #dedcdb"> <!-- Container for the page content -->

    <div class="row"> <!-- Row for the entire page content, helps align navigation bar with the whole page -->
        <!--    Sidebar for navigation-->
        <div class="d-flex col-sm-2 flex-column flex-shrink-0 p-3 text-white" style="height: 100vh; background-color: #151f47; position: sticky; top: 0; overflow-y: auto">
            <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <div class="logo" style="padding-right: 14px">
                    <img src="img/logo.png" alt="Logo" width="40" height="32" class="me-2">
                </div>
                <span class="fs-4">Clinic: Interactive Dashboard</span> <!-- Title of the dashboard -->
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white" aria-current="page"><i class="fa-solid fa-house-medical"></i> <!-- Navigation link for the Overview page -->
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#overview"></use></svg>Overview</a>
                </li>
                <li>
                    <a href="patients.php" class="nav-link text-white active"><i class="fa-solid fa-id-card-clip"></i> <!-- Navigation link for the Patients page -->
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#patients"></use></svg>Patients</a>
                </li>
                <li>
                    <a href="appointments.php" class="nav-link text-white"><i class="fa-solid fa-truck-medical"></i> <!-- Navigation link for the Appointments page -->
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#appointments"></use></svg>Appointments</a>
                </li>
                <hr>
                <div class="col-sm-12">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <p style="font-size: 20px; color: #151f47">Total Patients</p> <!--Display the total number of patients-->
                            <?php
                            $totalPatients = $db->getTotalPatients(); // Get the total number of patients
                            echo "<h1 style='font-size: 40px; color: #151f47'>$totalPatients</h1>"; // Display the total number of patients
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="padding-top: 20px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <p style="font-size: 20px; color: #151f47">Total Appointments</p> <!--Display the total number of patients-->
                            <?php
                            $totalAppointments = $db->getTotalAppointments(); // Connecting to the database to get the total number of appointments
                            echo "<h1 style='font-size: 40px; color: #151f47'>$totalAppointments</h1>"; // Display the total number of appointments
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="padding-top: 20px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <p style="font-size: 20px; color: #151f47">Total Neighbourhoods</p> <!--Display the total number of patients-->
                            <?php
                            $totalNeighbourhoods = $db->getTotalNeighbourhoods(); // Get the total number of neighbourhoods
                            echo "<h1 style='font-size: 40px; color: #151f47'>$totalNeighbourhoods</h1>"; // Display the total number of neighbourhoods
                            ?>
                        </div>
                    </div>
                </div>
            </ul>
            <hr>
            <p>Images used on the website were obtained from <a href="https://www.freepik.com/">FreePik</a>. </p>
            <p>Created by Sameer Uddin (20004135)</p>


        </div>

        <!--        Dashboard Content-->
        <div class="col-sm-10">

            <div class="row"> <!-- Row for the filters -->
                <div class="col-sm-9 mx-auto" style="padding-top: 40px">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h5>Filters</h5>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="patientIdInput" placeholder="Enter Patient ID">
                                </div>

                                <div class="col-sm-4 d-flex justify-content-end">
                                    <span>
                                        <span class="badge text-bg-secondary" id="resultCount">Results: 0</span> <!-- Number of results will be displayed here -->
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-2">
                                    <h6>Medical Condition</h6> <!-- Medical condition filter -->
                                    <hr>
                                    <form>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="diabetesCheckbox">
                                            <span class="form-check-label">Diabetes</span>
                                        </label>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="hypertensionCheckbox">
                                            <span class="form-check-label">Hypertension</span>
                                        </label>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="alcoholismCheckbox">
                                            <span class="form-check-label">Alcoholism</span>
                                        </label>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="handcapCheckbox">
                                            <span class="form-check-label">Handicap</span>
                                        </label>
                                    </form>
                                </div>

                                <div class="col-sm-3">
                                    <h6>Age</h6>
                                    <hr>
                                    <div class="row"> <!-- Age filter -->
                                        <div class="form-group col-md-6">
                                            <label>Min</label>
                                            <input type="number" class="form-control" id="ageMin" min="1" max="1000" value="1">
                                        </div>
                                        <div class="form-group col-md-6 text-right">
                                            <label>Max</label>
                                            <input type="number" class="form-control" id="ageMax" min="1" max="1000" value="1000">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <h6>Gender</h6>
                                    <hr>
                                    <div class="row"> <!-- Gender filter -->
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="M">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Male
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="F">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <h6>Scholarship</h6>
                                    <hr>
                                    <label><input class="form-check-input" type="checkbox" id="scholarshipTrue"> Scholarship (True)</label>
                                    <label><input class="form-check-input" type="checkbox" id="scholarshipFalse"> Scholarship (False)</label>
                                </div>

                                <div class="col-sm-3">
                                    <h6>Neighbourhood</h6>
                                    <hr>
                                    <select class="form-select" id="neighbourhoodSelect"> <!-- Neighbourhood filter -->
                                        <option value="">All</option>
                                        <?php
                                        $neighbourhoods = $db->getNeighbourhoods();
                                        foreach ($neighbourhoods as $neighbourhood) {
                                            echo "<option value='$neighbourhood'>$neighbourhood</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                    <button type="button" id="resetFilters" class="btn btn-warning">Reset Filters</button>
                                </div>

                                <div class="col-sm-10 justify-content-end d-sm-flex">
                                    <span>
                                    <button type="button" id="applyFilters" class="btn btn-primary">Apply Filters</button>
                                    </span>
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
                                    <th scope="col">Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Neighbourhood</th>
                                    <th scope="col">Alcoholism</th>
                                    <th scope="col">Handicap</th>
                                    <th scope="col">Hypertension</th>
                                    <th scope="col">Diabetes</th>
                                    <th scope="col">Scholarship</th>
                                </tr>
                                </thead>
                                <tbody id="patientTableBody"> <!-- Patient data will be inserted here using ID -->
                                <!-- Patient data will be inserted here -->
                                </tbody>
                            </table>

                            <div id="paginationControls" class="mt-3 d-flex justify-content-center">
                                <!-- Pagination buttons will be inserted here -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <footer style="padding-top: 40px"></footer> <!-- Footer for the page adds padding -->

        </div>
    </div>



</div>
<script src="scripts for patients.js?v=1.0"></script> <!-- JavaScript file for the Patients page -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->


</body>
</html>