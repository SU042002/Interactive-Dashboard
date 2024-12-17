<?php
require 'db_connection.php'; // Database connection
$db = new Database(); // Create a new instance of the Database class
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!--Bootstrap CSS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--Chart.js-->
    <script src="charts.js"></script> <!--Custom JS file for creating charts-->
</head>
<body>

<div class="container-fluid" style="background-color: #dedcdb">

    <div class="row"> <!--Create a row for the sidebar and the main content. Making it one row will ensure that the sidebar and the main content are on the same row. -->
        <!--Sidebar-->
        <div class="d-flex col-sm-2 flex-column flex-shrink-0 p-3 text-white" style="min-height: 100vh; background-color: #151f47;"> <!--Sidebar-->
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

                <ul class="nav nav-pills flex-column mb-auto"> <!--Navigation links-->
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#overview"></use></svg>
                            Overview
                        </a>
                    </li>
                    <li>
                        <a href="patients.php" class="nav-link text-white"> <!--Patients page-->
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#patients"></use></svg>
                            Patients
                        </a>
                    </li>
                    <li>
                        <a href="appointments.php" class="nav-link text-white"> <!--Appointments page-->
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="#appointments"></use></svg>
                            Appointments
                        </a>
                    </li>
                </ul>
        </div>

        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Patients</p> <!--Display the total number of patients-->
                                    <?php
                                    $totalPatients = $db->getTotalPatients(); // Get the total number of patients
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalPatients</h1>"; // Display the total number of patients
                                    ?>
                                </div>

                                <div class="col-sm-7">
                                    <canvas id="genderChart" width="100" height="100"></canvas>
                                    <?php
                                    $totalMales = $db->getTotalMales(); // Get the total number of males
                                    $totalFemales = $db->getTotalFemales(); // Get the total number of females
                                    ?>

                                    <script>
                                        createGenderChart(<?php echo $totalMales; ?>, <?php echo $totalFemales; ?>); // Create the gender chart
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Appointments</p>  <!--Display the total number of appointments-->
                                    <?php
                                    $totalAppointments = $db->getTotalAppointments(); // Connecting to the database to get the total number of appointments
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalAppointments</h1>"; // Display the total number of appointments
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="appointmentChart" width="100" height="100"></canvas>
                                    <?php
                                    $totalNoShow = $db->getTotalNoShows(); // Connecting to the database to get the total number of no-shows
                                    $totalShow = $db->getTotalShows();
                                    ?>
                                    <script>
                                        createAppointmentChart(<?php echo $totalNoShow; ?>, <?php echo $totalShow; ?>); // Create the appointment chart
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Neighbourhoods</p>
                                    <?php
                                    $totalNeighbourhoods = $db->getTotalNeighbourhoods(); // Get the total number of neighbourhoods
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalNeighbourhoods</h1>"; // Display the total number of neighbourhoods
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="getTop5NoShowsByNeighbourhood" width="100" height="100"></canvas>
                                    <?php
                                    $top5NoShowsByNeighbourhood = $db->getTop5NoShowsByNeighbourhood(); // Get the top 5 neighbourhoods with the highest number of no-shows
                                    $neighbourhoods = [];
                                    $noShows = [];

                                    foreach ($top5NoShowsByNeighbourhood as $item) {
                                        $neighbourhoods[] = $item['_id'];
                                        $noShows[] = $item['NoShows'];
                                    }
                                    ?>
                                    <script>
                                        createTop5NoShowsByNeighbourhoodChart(<?php echo json_encode($neighbourhoods); ?>, <?php echo json_encode($noShows); ?>);
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Patients with conditions</p>
                                    <?php
                                    $totalPatientsWithConditions = $db->getTotalPatientsWithAnyCondition();
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalPatientsWithConditions</h1>";
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="totalPatientsWithConditions" width="100" height="100"></canvas>
                                    <?php
                                    $getTotalPatientsWithConditions = $db->getTotalPatientsWithConditions(); // Connecting to the database to get the total number of patients with conditions

                                    $diabetes = $getTotalPatientsWithConditions[0]['totalDiabetes']; // Get the total number of patients with diabetes
                                    $hypertension = $getTotalPatientsWithConditions[0]['totalHypertension']; // Get the total number of patients with hypertension
                                    $alcoholism = $getTotalPatientsWithConditions[0]['totalAlcoholism']; // Get the total number of patients with alcoholism
                                    $handicap = $getTotalPatientsWithConditions[0]['totalHandicap']; // Get the total number of patients with handicap
                                    ?>
                                    <script>
                                        getTotalPatientsWithConditionsChart(<?php echo $diabetes; ?>, <?php echo $hypertension; ?>, <?php echo $alcoholism; ?>, <?php echo $handicap; ?>);
                                        // Create the total patients with conditions chart
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="appointmentsChart" width="400" height="200"></canvas>
                                    <?php
                                    $getAppointmentsOverMonths = $db->getAppointmentsOverMonths(); // Get the total number of appointments over the months

                                    $months = []; // Create an empty array to store the months
                                    $totals = []; // Create an empty array to store the total number of appointments

                                    foreach ($getAppointmentsOverMonths as $item) {
                                        $months[] = $item['_id']; // Get the month
                                        $totals[] = $item['totalAppointments']; // Get the total number of appointments
                                    }
                                    ?>
                                    <script>
                                        getAppointmentsOverMonthsCharts(<?php echo json_encode($months); ?>, <?php echo json_encode($totals); ?>); // Create the appointments over months chart
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="ageGroupChart" width="400" height="200"></canvas>
                                    <?php
                                    $appointmentsByAgeGroup = $db->getAppointmentsByAgeGroup(); // Get the total number of appointments by age group
                                    $ageGroups = []; // Create an empty array to store the age groups
                                    $totals = []; // Create an empty array to store the total number of appointments

                                    foreach ($appointmentsByAgeGroup as $item) {
                                        $ageGroups[] = $item['_id']; // Get the age group
                                        $totals[] = $item['totalAppointments']; // Get the total number of appointments
                                    }
                                    ?>
                                    <script>
                                        getAppointmentsByAgeGroupCharts(<?php echo json_encode($ageGroups); ?>, <?php echo json_encode($totals); ?>);
                                        // Create the appointments by age group chart
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4" style="padding-top: 40px">

                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="getNoShowRatesByGenderChart" width="400" height="200"></canvas>
                                    <?php
                                    $getNoShowRatesByGender = $db->getNoShowRatesByGender();
                                    $gender = [];
                                    $rate = [];

                                    foreach ($getNoShowRatesByGender as $item) {
                                        $gender[] = $item['Gender'];
                                        $rate[] = $item['NoShowRate'];
                                    }
                                    ?>
                                    <script>
                                        getNoShowRatesByGenderCharts(<?php echo json_encode($gender); ?>, <?php echo json_encode($rate); ?>);
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">

                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="getShowUpRatesBySMSCharts" width="400" height="200"></canvas>
                                    <?php
                                    $showUpRates = $db->getShowUpRatesBySMS();
                                    $smsCategories = [];
                                    $showUpRatesData = [];

                                    foreach ($showUpRates as $item) {
                                        $smsCategories[] = $item['SMS_Received'];
                                        $showUpRatesData[] = $item['ShowUpRate'];
                                    }
                                    ?>
                                    <script>
                                        createShowUpRateChart(<?php echo json_encode($smsCategories); ?>, <?php echo json_encode($showUpRatesData); ?>);
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">

                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="noShowScholarshipChart" width="400" height="200"></canvas>
                                    <?php
                                    $noShowRatesByScholarship = $db->getNoShowRatesByScholarship();

                                    $scholarshipCategories = [];
                                    $noShowRates = [];

                                    foreach ($noShowRatesByScholarship as $item) {
                                        $scholarshipCategories[] = $item['Scholarship'];
                                        $noShowRates[] = $item['NoShowRate'];
                                    }
                                    ?>


                                    <script>
                                        createNoShowScholarshipChart(<?php echo json_encode($scholarshipCategories); ?>, <?php echo json_encode($noShowRates); ?>);
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
            <div class="row">
                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <canvas id="topNeighborhoodsChart" width="400" height="200"></canvas>
                                    <?php
                                    $topNeighborhoods = $db->getTop10NeighborhoodsByPopulation(); // Get the top 10 neighbourhoods by population

                                    $neighborhoods = []; // Create an empty array to store the neighbourhoods
                                    $PopulationCount = []; // Create an empty array to store the population count

                                    // Loop through the top neighbourhoods
                                    foreach ($topNeighborhoods as $item) {
                                        $neighborhoods[] = $item['_id'];
                                        $PopulationCount[] = $item['PopulationCount'];
                                    }
                                    ?>
                                    <script>
                                        // Create the top neighbourhoods chart
                                        createTopNeighborhoodsChart(<?php echo json_encode($neighborhoods); ?>, <?php echo json_encode($PopulationCount); ?>);
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">
                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Neighbourhoods</p>
                                    <?php // Display the total number of neighbourhoods
                                    $totalNeighbourhoods = $db->getTotalNeighbourhoods(); // Connecting to the database to get the total number of neighbourhoods
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalNeighbourhoods</h1>";
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="topShowRatesChart" width="100" height="100"></canvas>
                                    <?php
                                    // Get the top show rates
                                    $topShowRates = $db->getTopShowRates(); // Connecting to the database to get the top show rates
                                    $neighborhoods = []; // Create an empty array to store the neighbourhoods
                                    $showRates = []; // Create an empty array to store the show rates

                                    foreach ($topShowRates as $item) { // Loop through the top show rates
                                        $neighborhoods[] = $item['Neighbourhood'];
                                        $showRates[] = $item['ShowRate'];
                                    }
                                    ?>
                                    <script>
                                        // Create the top show rates chart
                                        createTopShowRatesChart(<?php echo json_encode($neighborhoods); ?>, <?php echo json_encode($showRates); ?>);
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="padding-top: 40px">

                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Patients</p>
                                    <?php
                                    $totalPatients = $db->getTotalPatients(); // Get the total number of patients
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalPatients</h1>"; // Display the total number of patients
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="scholarshipChart" width="100" height="100"></canvas>
                                    <?php
                                    $scholarshipCounts = $db->getScholarshipCounts(); // Connecting to the database to get the scholarship counts
                                    $categories = []; // Create an empty array to store the categories
                                    $counts = []; // Create an empty array to store the counts

                                    foreach ($scholarshipCounts as $item) { // Loop through the scholarship counts
                                        $categories[] = $item['ScholarshipStatus']; // Add the scholarship status to the categories array
                                        $counts[] = $item['Count']; // Add the count to the counts array
                                    }
                                    ?>

                                    <script>
                                        // Create the scholarship chart
                                        createScholarshipChart(<?php echo json_encode($categories); ?>, <?php echo json_encode($counts); ?>);
                                    </script>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer style="padding-top: 40px"></footer>

    </div>
    </div>

</div>

<script src="chart.js"></script> <!--Chart.js-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> <!--Bootstrap JS-->

</body>
</html>