<?php
// include '../includes/database-connection.php';
$hostName = "localhost";
$serverUsername = "root";
$serverPassword = "";
$databaseName = "cms_db";

$connection = mysqli_connect($hostName, $serverUsername, $serverPassword, $databaseName);

$data = json_decode(file_get_contents('php://input'), true);

// foreach ($data as $estate) {
    $insertEstate = mysqli_prepare($connection, "INSERT INTO estates (estate_id, latitude_start, longitude_start, latitude_end, longitude_end, status) VALUES (?,?,?,?,?,?)");
    mysqli_stmt_bind_param($insertEstate, "sdddds", $data["estate_id"], $data["latitude_start"], $data["longitude_start"], $data["latitude_end"], $data["longitude_end"], $data["status"]);
    if (mysqli_stmt_execute($insertEstate)) {
        echo "Estates inserted successfully";
    } else {
        echo "Estates not inserted";
    }
// }
// if ($data) {
//     $sql = "INSERT INTO estates (estate_id, latitude_start, longitude_start, latitude_end, longitude_end, status) VALUES ";
//     $values = [];

//     foreach ($data as $lot) {
//         $values[] = sprintf(
//             "('%s', %.8f, %.8f, %.8f, %.8f, '%s')",
//             $lot['estate_id'], $lot['latitude_start'], $lot['longitude_start'], $lot['latitude_end'], $lot['longitude_end'], $lot['status']
//         );
//     }

//     $sql .= implode(", ", $values);

//     if (mysqli_query($connection, $sql)) {
//         echo "Estates inserted successfully!";
//     } else {
//         echo "Error: " . mysqli_error($connection);
//     }
// } else {
//     echo "No data received.";
// }

mysqli_close($connection);
?>
