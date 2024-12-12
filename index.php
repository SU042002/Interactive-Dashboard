<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container-fluid" style="padding: 0; background-color: #dedcdb">
<!--    Sidebar for navigation-->
    <div class="d-flex col-sm-2 flex-column flex-shrink-0 p-3 text-white" style="height: 100vh; background-color: #151f47">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">Clinic: Interactive Dashboard</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#overview"></use></svg>
                    Overview
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#patients"></use></svg>
                    Patients
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#appointments"></use></svg>
                    Appointments
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <svg class="bi me-2" width="16" height="16"><use xlink:href="#neighbourhoods"></use></svg>
                    Neighbourhoods
                </a>
            </li>
        </ul>
        <hr>
        <p>Images used on the website were obtained from <a href="https://www.freepik.com/">FreePik</a>. </p>
        <p>Created by Sameer Uddin (20004135)</p>
    </div>

</div>


<!-- Bootstrap JavaScript via CDN (includes Popper.js for tooltips and dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
