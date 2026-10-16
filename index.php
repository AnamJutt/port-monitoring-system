<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Port Monitoring System
    </title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- CSS -->

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg custom-navbar">

    <div class="container">

        <a class="navbar-brand"
           href="#">

            PMS

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
             id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"
                       href="#home">

                        Home

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="#features">

                        Features

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                       href="#about">

                        About

                    </a>
                </li>

               <?php if(isset($_SESSION['admin'])){ ?>

<li class="nav-item">

    <a class="dashboard-btn"
       href="dashboard.php">

        Dashboard

    </a>

</li>

<li class="nav-item">

    <div class="user-profile">

        <?php
        echo strtoupper(
            substr($_SESSION['admin'],0,1)
        );
        ?>

    </div>

</li>

<?php } else { ?>

<li class="nav-item">

    <a class="login-btn"
       href="login.php">

        Login

    </a>

</li>

<?php } ?>

            </ul>

        </div>

    </div>

</nav>

<!-- HERO SECTION -->

<section class="hero-section"
         id="home">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <div class="hero-content">

                    <h1>
                        Port Traffic
                        Monitoring System
                    </h1>

                    <p>

                        A modern web-based system
                        designed to monitor,
                        analyze and manage
                        network port traffic
                        activity through an
                        interactive dashboard.

                    </p>

                    <a href="login.php"
                       class="hero-btn">

                        Get Started

                    </a>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="hero-image">
                    <img src="images/hero.png" alt="Hero Image" class="img-fluid">
                </div>

            </div>

        </div>

    </div>

</section>

<!-- FEATURES -->

<section class="features-section"
         id="features">

    <div class="container">

        <div class="section-title">

            <h2>System Features</h2>

            <p>
                Powerful tools for monitoring
                and managing network traffic.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="feature-card">

                    <i class="bi bi-speedometer2"></i>

                    <h3>Dashboard</h3>

                    <p>
                        Interactive monitoring
                        dashboard with charts
                        and analytics.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="feature-card">

                    <i class="bi bi-hdd-network"></i>

                    <h3>Port Monitoring</h3>

                    <p>
                        Monitor active and
                        inactive network ports
                        dynamically.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="feature-card">

                    <i class="bi bi-activity"></i>

                    <h3>Traffic Logs</h3>

                    <p>
                        Store and manage
                        network traffic
                        activity records.
                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="feature-card">

                    <i class="bi bi-bar-chart"></i>

                    <h3>Reports</h3>

                    <p>
                        Generate traffic reports
                        with charts and PDF
                        download support.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ABOUT -->

<section class="about-section"
         id="about">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <div class="about-image">
                    <img src="images/about.png" alt="About Image" class="img-fluid">
                </div>

            </div>

            <div class="col-lg-6">

                <div class="about-content">

                    <h2>
                        About The System
                    </h2>

                    <p>

                        The Network Port Traffic
                        Monitoring System is a
                        web-based platform
                        developed to monitor
                        and manage network
                        traffic activity through
                        interactive dashboards,
                        reports and analytics.

                    </p>

                    <p>

                        The system provides
                        administrators with a
                        modern interface to
                        visualize traffic records,
                        monitor ports and
                        generate reports easily.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- FOOTER -->

<footer class="footer-section">

    <div class="container">

        <p>
            © 2026 Port Monitoring System
            | Final Year Project
        </p>

    </div>

</footer>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>