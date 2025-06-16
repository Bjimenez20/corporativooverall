<?php
include_once('./../connection/index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = $_POST['full_name'];
    $position = $_POST['position'];
    $company = $_POST['company'];
    $business_sector = $_POST['business_sector'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $unidad = $_POST['unidad'];
    $message = $_POST['message'];

    $sql = "INSERT INTO `contacts` (`full_name`, `position`, `company`, `business_sector`, `email`, `country`, `unidad`, `message`) VALUES ('$full_name', '$position', '$company', '$business_sector', '$email', '$country', '$unidad', '$message')";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        $sqlSelect = mysqli_query($connection, "SELECT * FROM contacts ORDER BY id DESC LIMIT 1");

        while ($date = mysqli_fetch_array($sqlSelect)) {
            $full_name = $date['full_name'];
            $position = $date['position'];
            $company = $date['company'];
            $business_sector = $date['business_sector'];
            $email = $date['email'];
            $country = $date['country'];
            $unidad = $date['unidad'];
            $message = $date['message'];
        }

        switch ($unidad) {
            case 'Executive Search':
                require('email/Executive_search.php');
                break;

            case 'Talent Solutions':
                require('email/Talent_solutions.php');
                break;

            case 'Permanent Placement':
                require('email/Permanent_placement.php');
                break;

            case 'Marketing':
                require('email/Marketing.php');
                break;

            case 'Trade Marketing':
                require('email/Trade_marketing.php');
                break;

            case 'Marketing Digital':
                require('email/Marketing_digital.php');
                break;

            case 'Outsourcing Staffing':
                require('email/Outsourcing_staffing.php');
                break;

            case 'Facility Managment':
                require('email/Facility_management.php');
                break;

            case 'Servicios Temporales':
                 require('email/Servicios_temporales.php');
                break;

            case 'Payroll':
                require('email/Payroll.php');
                break;

            case 'Contact Center':
                require('email/Contact_center.php');
                break;

            case 'Gestion Logistica':
                 require('email/logistica.php');
                break;

            case 'Servicios Industriales':
                 require('email/Servicios_industriales.php');
                break;

            case 'Servicios Estrategicos Salud':
                require('email/Sector_salud.php');
                break;
        }
    }
}
