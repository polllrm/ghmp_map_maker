<?php
include 'database_connection.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $sql = "INSERT INTO cemetery_lots (lot_id, latitude_start, longitude_start, latitude_end, longitude_end, status) VALUES ";
    $values = [];

    foreach ($data as $lot) {
        $values[] = sprintf(
            "('%s', %.8f, %.8f, %.8f, %.8f, '%s')",
            $lot['lotId'], $lot['latitudeStart'], $lot['longitudeStart'], $lot['latitudeEnd'], $lot['longitudeEnd'], $lot['status']
        );
    }

    $sql .= implode(", ", $values);

    if (mysqli_query($connection, $sql)) {
        echo "Lots inserted successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "No data received.";
}

mysqli_close($connection);
?>
