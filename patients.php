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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="charts.js"></script>
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
                    <a href="patients.php" class="nav-link text-white active">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#patients"></use></svg>
                        Patients
                    </a>
                </li>
                <li>
                    <a href="appointments.php" class="nav-link text-white">
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

            <!--            <div class="row" style="padding-top: 40px">-->
            <!--                <div class="col-sm-11 mx-auto" style="justify-content: center; background-color: white; border-radius: 5px">-->
            <!--                    <p style="font-size: 30px; font-family: Arial,serif; color: #151f47"; align="center">This dashboard provides data-driven insights into no-show statistics, examining patient demographics, medical problems, appointment trends, and the efficacy of reminders to improve clinic operations and patient outcomes.</p>-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="row">

                <div class="col-sm-4" style="padding-top: 40px">

                    <div class="card" style="border-radius: 5px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p style="font-size: 20px; color: #151f47">Total Patients</p>
                                    <?php
                                    $totalPatients = $db->getTotalPatients();
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalPatients</h1>";
                                    ?>
                                </div>

                                <div class="col-sm-7">
                                    <canvas id="genderChart" width="100" height="100"></canvas>
                                    <?php
                                    $totalMales = $db->getTotalMales();
                                    $totalFemales = $db->getTotalFemales();
                                    ?>

                                    <script>
                                        createGenderChart(<?php echo $totalMales; ?>, <?php echo $totalFemales; ?>);
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
                                    <p style="font-size: 20px; color: #151f47">Total Appointments</p>
                                    <?php
                                    $totalAppointments = $db->getTotalAppointments();
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalAppointments</h1>";
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="appointmentChart" width="100" height="100"></canvas>
                                    <?php
                                    $totalNoShow = $db->getTotalNoShows();
                                    $totalShow = $db->getTotalShows();
                                    ?>


                                    <script>
                                        createAppointmentChart(<?php echo $totalNoShow; ?>, <?php echo $totalShow; ?>);
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
                                    $totalNeighbourhoods = $db->getTotalNeighbourhoods();
                                    echo "<h1 style='font-size: 40px; color: #151f47'>$totalNeighbourhoods</h1>";
                                    ?>
                                </div>
                                <div class="col-sm-7">
                                    <canvas id="getTop5NoShowsByNeighbourhood" width="100" height="100"></canvas>

                                    <?php
                                    $top5NoShowsByNeighbourhood = $db->getTop5NoShowsByNeighbourhood();
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

            <footer style="padding-top: 40px"></footer>

        </div>
    </div>



</div>


<script src="chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>