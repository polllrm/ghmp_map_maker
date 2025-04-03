<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GHMP Map Maker</title>
  <link rel="stylesheet" href="leaflet.css">
  <link rel="shortcut icon" href="assets/brand/green_haven_memorial_park_logo.ico" type="image/x-icon">
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
    /* Make the map responsive and fill the container */
    #map {
      height: 500px;
      width: 100%;
    }
  </style>

  <style>
    .info.legend {
      background: white;
      padding: 10px;
      border-radius: 5px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      font-size: 14px;
      line-height: 18px;
      color: #333;
    }
  </style>
</head>

<body>

  <main class="container-fluid">
    <div class="rounded" id="map"></div>
    <p>
      Lawn A: 450 <br>
      Lawn B: 509 <br>
      Lawn C: 549 <br>
      Lawn D: 554 <br>
      Lawn E: 799 <br>
      Lawn F: 399 <br>
      Lawn G: 628 <br>
      Lawn H: 587 <br>
      Lawn I: 547 <br>
      Lawn J: 463 <br>
      Lawn K: 754 <br>
      Lawn L: 605 <br>
      Lawn M: 979 <br>
      Estate A: 680 Lots = 85 Estates <br>
      Estate B: 336 Lots = 48 Estates <br>
      Estate C: 1,024 Lots = 160 Estates
    </p>
  </main>

  <script src="jquery.js"></script>
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="leaflet.js"></script>
  <script src="turf.min.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize the map at the specified coordinates
      const map = L.map('map').setView([14.871186, 120.977913], 19); // Initial view

      // Add the OpenStreetMap tile layer
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 22,
      }).addTo(map);

      // Estate start
      // Estate dimensions in degrees (approximate, adjust if needed)
      // const estateDimensions = {
      //     A: { width: 0.000036, height: 0.000045 },  // 4m × 5m
      //     B: { width: 0.0000315, height: 0.000045 }, // 3.5m × 5m
      //     C: { width: 0.000036, height: 0.000036 }   // 4m × 4m
      // };

      // NOTE: UNCOMMENT THIS TO JUST DISPLAY THE RECTANGLES
      // // Function to create an estate rectangle on the map
      function createEstate(type, startLat, startLng) {
        if (!estateDimensions[type]) {
          console.error("Invalid estate type:", type);
          return;
        }

        const {
          width,
          height
        } = estateDimensions[type];

        // Define the bounds starting from the bottom-left corner
        const bounds = [
          [startLat, startLng], // Bottom-left corner (provided)
          [startLat + height, startLng + width] // Top-right corner (calculated)
        ];

        // Add the rectangle for the estate to the map
        L.rectangle(bounds, {
          color: "#006400", // Dark green color for estates
          weight: 2,
          fillColor: "#228B22", // Fill color for estates
          fillOpacity: 0.5
        }).addTo(map);
      }

      // Estate with fetch start
      const estateDimensions = {
        A: {
          width: 0.000036,
          height: 0.000045
        }, // 4m × 5m
        B: {
          width: 0.0000315,
          height: 0.000045
        }, // 3.5m × 5m
        C: {
          width: 0.000036,
          height: 0.000036
        } // 4m × 4m
      };

      // To track estate numbers for each type (A, B, C)
      const estateCounters = {
        A: 0,
        B: 0,
        C: 0
      };
      // Estate end

      // NOTE: UNCOMMENT THIS TO INSERT TO THE DATABASE
      // function createEstateAndInsert(type, startLat, startLng) {
      //     if (!estateDimensions[type]) {
      //         console.error("Invalid estate type:", type);
      //         return;
      //     }

      //     const { width, height } = estateDimensions[type];

      //     // Calculate the end coordinates based on starting coordinates and dimensions
      //     const latitudeEnd = startLat + height;
      //     const longitudeEnd = startLng + width;

      //     // Increment the estate counter for the given type
      //     estateCounters[type] += 1;
      //     const estateNumber = estateCounters[type];

      //     // Generate the estate_id in the format: E-[Estate type][Estate number]
      //     const estateId = `E-${type}${estateNumber}`;

      //     // Prepare the SQL insert query
      //     const sqlQuery = `
      //         INSERT INTO estate (estate_id, latitude_start, latitude_end, longitude_start, longitude_end)
      //         VALUES ('${estateId}', ${startLat}, ${latitudeEnd}, ${startLng}, ${longitudeEnd});
      //     `;

      //     // Simulate the insertion (you can replace this with actual database interaction)
      //     console.log("SQL Query:", sqlQuery);

      //     // Example of how to insert into the database using fetch (you'll need to adapt this part for your backend):

      //     // fetch('insert_estate.php', {
      //     //     method: 'POST',
      //     //     headers: {
      //     //         'Content-Type': 'application/json'
      //     //     },
      //     //     body: JSON.stringify({
      //     //         estate_id: estateId,
      //     //         latitude_start: startLat,
      //     //         latitude_end: latitudeEnd,
      //     //         longitude_start: startLng,
      //     //         longitude_end: longitudeEnd,
      //     //         status: "Available"
      //     //     })
      //     // });

      //     $.ajax({
      //       url: 'insert_estate.php',
      //       method: 'POST',
      //       contentType: 'application/json',
      //       data: JSON.stringify({
      //         estate_id: estateId,
      //             latitude_start: startLat,
      //             latitude_end: latitudeEnd,
      //             longitude_start: startLng,
      //             longitude_end: longitudeEnd,
      //             status: "Available"
      //       }),
      //       success: function(response) {
      //         console.log(response);
      //       },
      //       error: function(err) {
      //         console.error('Error:', err);
      //       }
      //     });

      // }
      // Estate with fetch end

      // createEstateAndInsert("A", 14.8714167, 120.9769721);
      // createEstateAndInsert("B", 14.8714647, 120.9769721);
      // createEstateAndInsert("C", 14.8715127, 120.9769721);
      createEstate("A", 14.8714167, 120.9769721);
      createEstate("B", 14.8714647, 120.9769721);
      createEstate("B", 14.8715127, 120.9769721);


      // Grave dimensions (adjust as needed)
      const graveWidth = 0.0000045; // Approx. 1 meter in longitude degrees (at equator)
      const graveHeight = 0.000009; // Approx. 2 meters in latitude degrees


      // Small spacing between graves (in degrees)
      // const spacing = 0.000005; // Adjust as needed
      const spacing = 0.000001; // No spacing

      // Status options and their colors
      const statuses = {
        "Available": "#28a745", // Green
        "Reserved": "#ffc107", // Yellow
        "Sold": "#dc3545", // Red
        "Sold and Occupied": "#6c757d" // Gray
      };

      // Function to get a random status
      function getRandomStatus() {
        const keys = Object.keys(statuses);
        return keys[Math.floor(Math.random() * keys.length)];
      }

      // NOTE: UNCOMMENT THIS TO JUST DISPLAY THE RECTANGLES
      function createGraveColumn(startLat, startLng, numGraves) {
        // Loop to create the graves in a column
        for (let i = 0; i < numGraves; i++) {
          const lat = startLat + (i * (graveHeight + spacing)); // Add spacing between graves
          const lng = startLng
          // Define the bounds for each rectangle (grave)
          const bounds = [
            [lat - graveHeight / 2, lng - graveWidth / 2], // Bottom-left corner
            [lat + graveHeight / 2, lng + graveWidth / 2] // Top-right corner
          ]
          // Get a random status and its corresponding color
          const status = getRandomStatus();
          const color = statuses[status]
          // Add the rectangle for the grave to the map
          const grave = L.rectangle(bounds, {
            color: color, // Border color based on status
            weight: 2,
            fillColor: color, // Fill color based on status
            fillOpacity: 0.5
          }).addTo(map)
          // Add a popup to show the status of the grave
          grave.bindPopup(`Status: ${status}`);
        }
      }

      // NOTE: UNCOMMENT THIS TO INSERT TO THE DATABASE
      // function createGraveColumn(startLat, startLng, numGraves, phaseId, lawnId, rowId) {
      //   const graves = [];

      //   for (let i = 0; i < numGraves; i++) {
      //     const lat = startLat + (i * (graveHeight + spacing));
      //     const lng = startLng;

      //     const bounds = [
      //       [lat - graveHeight / 2, lng - graveWidth / 2],
      //       [lat + graveHeight / 2, lng + graveWidth / 2]
      //     ];

      //     const lotId = `${phaseId}${lawnId}${rowId}-${i + 1}`;
      //     const status = getRandomStatus();

      //     graves.push({
      //       lotId: lotId,
      //       latitudeStart: bounds[0][0],
      //       longitudeStart: bounds[0][1],
      //       latitudeEnd: bounds[1][0],
      //       longitudeEnd: bounds[1][1],
      //       status: status
      //     });
      //   }

      //   // Send graves to the server
      //   $.ajax({
      //     url: 'insert_graves.php',
      //     method: 'POST',
      //     contentType: 'application/json',
      //     data: JSON.stringify(graves),
      //     success: function(response) {
      //       console.log(response);
      //     },
      //     error: function(err) {
      //       console.error('Error:', err);
      //     }
      //   });
      // }

      const columnSpacing = 0.000019;

      // Phase 1 Lawn C (Should contain approximately 549 graves)
      const startLat1 = 14.8715855;
      const startLng1 = 120.9770581;
      const numGraves1 = 12;
      createGraveColumn(startLat1, startLng1, numGraves1, 1, "C", 1);

      const startLat2 = 14.8714600;
      const startLng2 = startLng1 + columnSpacing;
      const numGraves2 = 25;
      createGraveColumn(startLat2, startLng2, numGraves2, 1, "C", 2);

      const startLat3 = 14.871420;
      const startLng3 = startLng2 + columnSpacing;
      const numGraves3 = 29;
      createGraveColumn(startLat3, startLng3, numGraves3, 1, "C", 3);

      const startLat4 = 14.871420;
      const startLng4 = startLng3 + columnSpacing;
      const numGraves4 = 29;
      createGraveColumn(startLat4, startLng4, numGraves4, 1, "C", 4);

      const startLat5 = 14.871420;
      const startLng5 = startLng4 + columnSpacing;
      const numGraves5 = 29;
      createGraveColumn(startLat5, startLng5, numGraves5, 1, "C", 5);

      const startLat6 = 14.871420;
      const startLng6 = startLng5 + columnSpacing;
      const numGraves6 = 29;
      createGraveColumn(startLat6, startLng6, numGraves6, 1, "C", 6);

      const startLat7 = 14.871420;
      const startLng7 = startLng6 + columnSpacing;
      const numGraves7 = 30;
      createGraveColumn(startLat7, startLng7, numGraves7, 1, "C", 7);

      const startLat8 = 14.871420;
      const startLng8 = startLng7 + columnSpacing;
      const numGraves8 = 30;
      createGraveColumn(startLat8, startLng8, numGraves8, 1, "C", 8);

      const startLat9 = 14.871420;
      const startLng9 = startLng8 + columnSpacing;
      const numGraves9 = 30;
      createGraveColumn(startLat9, startLng9, numGraves9, 1, "C", 9);

      const startLat10 = 14.871420;
      const startLng10 = startLng9 + columnSpacing;
      const numGraves10 = 30;
      createGraveColumn(startLat10, startLng10, numGraves10, 1, "C", 10);

      const startLat11 = 14.871420;
      const startLng11 = startLng10 + columnSpacing;
      const numGraves11 = 30;
      createGraveColumn(startLat11, startLng11, numGraves11, 1, "C", 11);

      const startLat12 = 14.871420;
      const startLng12 = startLng11 + columnSpacing;
      const numGraves12 = 30;
      createGraveColumn(startLat12, startLng12, numGraves12, 1, "C", 12);

      const startLat13 = 14.871420;
      const startLng13 = startLng12 + columnSpacing;
      const numGraves13 = 31;
      createGraveColumn(startLat13, startLng13, numGraves13, 1, "C", 13);

      const startLat14 = 14.871420;
      const startLng14 = startLng13 + columnSpacing;
      const numGraves14 = 31;
      createGraveColumn(startLat14, startLng14, numGraves14, 1, "C", 14);

      const startLat15 = 14.871420;
      const startLng15 = startLng14 + columnSpacing;
      const numGraves15 = 31;
      createGraveColumn(startLat15, startLng15, numGraves15, 1, "C", 15);

      const startLat16 = 14.871420;
      const startLng16 = startLng15 + columnSpacing;
      const numGraves16 = 31;
      createGraveColumn(startLat16, startLng16, numGraves16, 1, "C", 16);

      const startLat17 = 14.871420;
      const startLng17 = startLng16 + columnSpacing;
      const numGraves17 = 31;
      createGraveColumn(startLat17, startLng17, numGraves17, 1, "C", 17);

      const startLat18 = 14.871420;
      const startLng18 = startLng17 + columnSpacing;
      const numGraves18 = 31;
      createGraveColumn(startLat18, startLng18, numGraves18, 1, "C", 18);

      const startLat19 = 14.871420;
      const startLng19 = startLng18 + columnSpacing;
      const numGraves19 = 31;
      createGraveColumn(startLat19, startLng19, numGraves19, 1, "C", 19);

      // Phase 1 Lawn D (Should contain approximately 554 graves)
      // Phase 1 Lawn D (Should contain approximately 554 graves)
      const startLat20 = 14.871415;
      const startLng20 = startLng19 + columnSpacing + columnSpacing;
      const numGraves20 = 32;
      createGraveColumn(startLat20, startLng20, numGraves20, 1, "D", 1);

      const startLat21 = 14.871415;
      const startLng21 = startLng20 + columnSpacing;
      const numGraves21 = 32;
      createGraveColumn(startLat21, startLng21, numGraves21, 1, "D", 2);

      const startLat22 = 14.871415;
      const startLng22 = startLng21 + columnSpacing;
      const numGraves22 = 33;
      createGraveColumn(startLat22, startLng22, numGraves22, 1, "D", 3);

      const startLat23 = 14.871415;
      const startLng23 = startLng22 + columnSpacing;
      const numGraves23 = 33;
      createGraveColumn(startLat23, startLng23, numGraves23, 1, "D", 4);

      const startLat24 = 14.871400;
      const startLng24 = startLng23 + columnSpacing;
      const numGraves24 = 34;
      createGraveColumn(startLat24, startLng24, numGraves24, 1, "D", 5);

      const startLat25 = 14.871405;
      const startLng25 = startLng24 + columnSpacing;
      const numGraves25 = 34;
      createGraveColumn(startLat25, startLng25, numGraves25, 1, "D", 6);

      const startLat26 = 14.871400;
      const startLng26 = startLng25 + columnSpacing;
      const numGraves26 = 35;
      createGraveColumn(startLat26, startLng26, numGraves26, 1, "D", 7);

      const startLat27 = 14.871400;
      const startLng27 = startLng26 + columnSpacing;
      const numGraves27 = 35;
      createGraveColumn(startLat27, startLng27, numGraves27, 1, "D", 8);

      const startLat28 = 14.871400;
      const startLng28 = startLng27 + columnSpacing;
      const numGraves28 = 35;
      createGraveColumn(startLat28, startLng28, numGraves28, 1, "D", 9);

      const startLat29 = 14.871400;
      const startLng29 = startLng28 + columnSpacing;
      const numGraves29 = 35;
      createGraveColumn(startLat29, startLng29, numGraves29, 1, "D", 10);

      const startLat30 = 14.871400;
      const startLng30 = startLng29 + columnSpacing;
      const numGraves30 = 36;
      createGraveColumn(startLat30, startLng30, numGraves30, 1, "D", 11);

      const startLat31 = 14.871400;
      const startLng31 = startLng30 + columnSpacing;
      const numGraves31 = 36;
      createGraveColumn(startLat31, startLng31, numGraves31, 1, "D", 12);

      const startLat32 = 14.871400;
      const startLng32 = startLng31 + columnSpacing;
      const numGraves32 = 36;
      createGraveColumn(startLat32, startLng32, numGraves32, 1, "D", 13);

      const startLat33 = 14.871400;
      const startLng33 = startLng32 + columnSpacing;
      const numGraves33 = 36;
      createGraveColumn(startLat33, startLng33, numGraves33, 1, "D", 14);

      const startLat34 = 14.871400;
      const startLng34 = startLng33 + columnSpacing;
      const numGraves34 = 36;
      createGraveColumn(startLat34, startLng34, numGraves34, 1, "D", 15);

      const startLat35 = 14.871400;
      const startLng35 = startLng34 + columnSpacing;
      const numGraves35 = 36;
      createGraveColumn(startLat35, startLng35, numGraves35, 1, "D", 16);

      const startLat36 = 14.871400;
      const startLng36 = startLng35 + columnSpacing;
      const numGraves36 = 37;
      createGraveColumn(startLat36, startLng36, numGraves36, 1, "D", 17);

      // const startLat37 = 14.871400;
      // const startLng37 = startLng36 + columnSpacing;
      // const numGraves37 = 7;
      // createGraveColumn(startLat37, startLng37, numGraves37, 1, "C", 37);

      // Phase 1 Lawn A 450
      const startLat38 = 14.87107;
      const startLng38 = 120.9770581;
      const numGraves38 = 25;
      createGraveColumn(startLat38, startLng38, numGraves38, 1, "A", 38);

      const startLat39 = 14.87106;
      const startLng39 = startLng38 + columnSpacing;
      const numGraves39 = 25;
      createGraveColumn(startLat39, startLng39, numGraves39, 1, "A", 39);

      const startLat40 = 14.87105;
      const startLng40 = startLng39 + columnSpacing;
      const numGraves40 = 26;
      createGraveColumn(startLat40, startLng40, numGraves40, 1, "A", 40);

      const startLat41 = 14.87104;
      const startLng41 = startLng40 + columnSpacing;
      const numGraves41 = 26;
      createGraveColumn(startLat41, startLng41, numGraves41, 1, "A", 41);

      const startLat42 = 14.87104;
      const startLng42 = startLng41 + columnSpacing;
      const numGraves42 = 26;
      createGraveColumn(startLat42, startLng42, numGraves42, 1, "A", 42);

      const startLat43 = 14.87103;
      const startLng43 = startLng42 + columnSpacing;
      const numGraves43 = 27;
      createGraveColumn(startLat43, startLng43, numGraves43, 1, "A", 43);

      const startLat44 = 14.87102;
      const startLng44 = startLng43 + columnSpacing;
      const numGraves44 = 27;
      createGraveColumn(startLat44, startLng44, numGraves44, 1, "A", 44);

      const startLat45 = 14.87102;
      const startLng45 = startLng44 + columnSpacing;
      const numGraves45 = 27;
      createGraveColumn(startLat45, startLng45, numGraves45, 1, "A", 45);

      const startLat46 = 14.87101;
      const startLng46 = startLng45 + columnSpacing;
      const numGraves46 = 28;
      createGraveColumn(startLat46, startLng46, numGraves46, 1, "A", 46);

      const startLat47 = 14.87101;
      const startLng47 = startLng46 + columnSpacing;
      const numGraves47 = 28;
      createGraveColumn(startLat47, startLng47, numGraves47, 1, "A", 47);

      const startLat48 = 14.87100;
      const startLng48 = startLng47 + columnSpacing;
      const numGraves48 = 29;
      createGraveColumn(startLat48, startLng48, numGraves48, 1, "A", 48);

      const startLat49 = 14.87100;
      const startLng49 = startLng48 + columnSpacing;
      const numGraves49 = 29;
      createGraveColumn(startLat49, startLng49, numGraves49, 1, "A", 49);

      const startLat50 = 14.87100;
      const startLng50 = startLng49 + columnSpacing;
      const numGraves50 = 29;
      createGraveColumn(startLat50, startLng50, numGraves50, 1, "A", 50);

      // New columns starting at a more appropriate latitude
      const startLat51 = 14.87099;  // Adjusted latitude
      const startLng51 = startLng50 + columnSpacing;
      const numGraves51 = 29;
      createGraveColumn(startLat51, startLng51, numGraves51, 1, "A", 51);

      const startLat52 = 14.87098;  // Adjusted latitude
      const startLng52 = startLng51 + columnSpacing;
      const numGraves52 = 30;
      createGraveColumn(startLat52, startLng52, numGraves52, 1, "A", 52);

      const startLat53 = 14.87097;  // Adjusted latitude
      const startLng53 = startLng52 + columnSpacing;
      const numGraves53 = 31;
      createGraveColumn(startLat53, startLng53, numGraves53, 1, "A", 53);

      const startLat54 = 14.87097;  // Adjusted latitude
      const startLng54 = startLng53 + columnSpacing;
      const numGraves54 = 31;
      createGraveColumn(startLat54, startLng54, numGraves54, 1, "A", 54);



      ///////////
      // Phase 1 Lawn B (Should contain approximately 509 graves)
      const startLat55 = 14.87095;  // Adjusted latitude
      const startLng55 = startLng54 + columnSpacing + columnSpacing;
      const numGraves55 = 32;
      createGraveColumn(startLat55, startLng55, numGraves55, 1, "B", 55);

      const startLat56 = 14.87095;  // Adjusted latitude
      const startLng56 = startLng55 + columnSpacing;
      const numGraves56 = 32;
      createGraveColumn(startLat56, startLng56, numGraves56, 1, "B", 56);

      const startLat57 = 14.87094;  // Adjusted latitude
      const startLng57 = startLng56 + columnSpacing;
      const numGraves57 = 33;
      createGraveColumn(startLat57, startLng57, numGraves57, 1, "B", 57);

      const startLat58 = 14.87094;  // Adjusted latitude
      const startLng58 = startLng57 + columnSpacing;
      const numGraves58 = 33;
      createGraveColumn(startLat58, startLng58, numGraves58, 1, "B", 58);

      const startLat59 = 14.87092;  // Adjusted latitude
      const startLng59 = startLng58 + columnSpacing;
      const numGraves59 = 34;
      createGraveColumn(startLat59, startLng59, numGraves59, 1, "B", 59);

      const startLat60 = 14.87092;  // Adjusted latitude
      const startLng60 = startLng59 + columnSpacing;
      const numGraves60 = 34;
      createGraveColumn(startLat60, startLng60, numGraves60, 1, "B", 60);

      const startLat61 = 14.87092;  // Adjusted latitude
      const startLng61 = startLng60 + columnSpacing;
      const numGraves61 = 34;
      createGraveColumn(startLat61, startLng61, numGraves61, 1, "B", 61);

      const startLat62 = 14.87091;  // Adjusted latitude
      const startLng62 = startLng61 + columnSpacing;
      const numGraves62 = 35;
      createGraveColumn(startLat62, startLng62, numGraves62, 1, "B", 62);

      const startLat63 = 14.87090;  // Adjusted latitude
      const startLng63 = startLng62 + columnSpacing;
      const numGraves63 = 36;
      createGraveColumn(startLat63, startLng63, numGraves63, 1, "B", 63);

      const startLat64 = 14.87090;  // Adjusted latitude
      const startLng64 = startLng63 + columnSpacing;
      const numGraves64 = 36;
      createGraveColumn(startLat64, startLng64, numGraves64, 1, "B", 64);

      const startLat65 = 14.87089;  // Adjusted latitude
      const startLng65 = startLng64 + columnSpacing;
      const numGraves65 = 37;
      createGraveColumn(startLat65, startLng65, numGraves65, 1, "B", 65);

      const startLat66 = 14.87088;  // Adjusted latitude
      const startLng66 = startLng65 + columnSpacing;
      const numGraves66 = 37;
      createGraveColumn(startLat66, startLng66, numGraves66, 1, "B", 66);

      const startLat67 = 14.87088;  // Adjusted latitude
      const startLng67 = startLng66 + columnSpacing;
      const numGraves67 = 37;
      createGraveColumn(startLat67, startLng67, numGraves67, 1, "B", 67);

      const startLat68 = 14.87087;  // Adjusted latitude
      const startLng68 = startLng67 + columnSpacing;
      const numGraves68 = 38;
      createGraveColumn(startLat68, startLng68, numGraves68, 1, "B", 68);

      const startLat69 = 14.87087;  // Adjusted latitude
      const startLng69 = startLng68 + columnSpacing;
      const numGraves69 = 38;
      createGraveColumn(startLat69, startLng69, numGraves69, 1, "B", 69);

      const startLat70 = 14.87086;  // Adjusted latitude
      const startLng70 = startLng69 + columnSpacing;
      const numGraves70 = 39;
      createGraveColumn(startLat70, startLng70, numGraves70, 1, "B", 70);



      // Phase 1 Lawn E (Should contain approximately 799 graves)
      const startLat71 = 14.87080;  // Adjusted latitude
      const startLng71 = startLng70 + columnSpacing + columnSpacing + columnSpacing + columnSpacing
        + columnSpacing + columnSpacing + columnSpacing + columnSpacing;
      const numGraves71 = 40; // adjust the graves
      createGraveColumn(startLat71, startLng71, numGraves71, 1, "E", 71);

      const startLat72 = 14.87080;  // Adjusted latitude
      const startLng72 = startLng71 + columnSpacing;
      const numGraves72 = 40;  // adjust the graves 
      createGraveColumn(startLat72, startLng72, numGraves72, 1, "E", 72);

      const startLat73 = 14.87079;  // Adjusted latitude
      const startLng73 = startLng72 + columnSpacing;
      const numGraves73 = 42; // adjust the graves
      createGraveColumn(startLat73, startLng73, numGraves73, 1, "E", 73);

      const startLat74 = 14.87078;  // Adjusted latitude
      const startLng74 = startLng73 + columnSpacing;
      const numGraves74 = 45; // adjust the graves
      createGraveColumn(startLat74, startLng74, numGraves74, 1, "E", 74);

      const startLat75 = 14.87077;  // Adjusted latitude
      const startLng75 = startLng74 + columnSpacing;
      const numGraves75 = 47; // adjust the graves
      createGraveColumn(startLat75, startLng75, numGraves75, 1, "E", 75);

      const startLat76 = 14.87076;  // Adjusted latitude
      const startLng76 = startLng75 + columnSpacing;
      const numGraves76 = 48; // adjust the graves
      createGraveColumn(startLat76, startLng76, numGraves76, 1, "E", 76);

      const startLat77 = 14.87075;  // Adjusted latitude
      const startLng77 = startLng76 + columnSpacing;
      const numGraves77 = 49; // adjust the graves
      createGraveColumn(startLat77, startLng77, numGraves77, 1, "E", 77);

      const startLat78 = 14.87074;  // Adjusted latitude
      const startLng78 = startLng77 + columnSpacing;
      const numGraves78 = 50; // adjust the graves
      createGraveColumn(startLat78, startLng78, numGraves78, 1, "E", 78);

      const startLat79 = 14.87073;  // Adjusted latitude
      const startLng79 = startLng78 + columnSpacing;
      const numGraves79 = 51; // adjust the graves
      createGraveColumn(startLat79, startLng79, numGraves79, 1, "E", 79);

      const startLat80 = 14.87072;  // Adjusted latitude
      const startLng80 = startLng79 + columnSpacing;
      const numGraves80 = 52; // adjust the graves
      createGraveColumn(startLat80, startLng80, numGraves80, 1, "E", 80);

      const startLat81 = 14.87071;  // Adjusted latitude
      const startLng81 = startLng80 + columnSpacing;
      const numGraves81 = 53; // adjust the graves
      createGraveColumn(startLat81, startLng81, numGraves81, 1, "E", 81);

      const startLat82 = 14.87069;  // Adjusted latitude
      const startLng82 = startLng81 + columnSpacing;
      const numGraves82 = 55; // adjust the graves
      createGraveColumn(startLat82, startLng82, numGraves82, 1, "E", 82);

      const startLat83 = 14.87068;  // Adjusted latitude
      const startLng83 = startLng82 + columnSpacing;
      const numGraves83 = 55; // adjust the graves
      createGraveColumn(startLat83, startLng83, numGraves83, 1, "E", 83);

      const startLat84 = 14.87067;  // Adjusted latitude
      const startLng84 = startLng83 + columnSpacing;
      const numGraves84 = 56; // adjust the graves
      createGraveColumn(startLat84, startLng84, numGraves84, 1, "E", 84);

      const startLat85 = 14.87066;  // Adjusted latitude
      const startLng85 = startLng84 + columnSpacing;
      const numGraves85 = 57; // adjust the graves
      createGraveColumn(startLat85, startLng85, numGraves85, 1, "E", 85);

      const startLat86 = 14.87064;  // Adjusted latitude
      const startLng86 = startLng85 + columnSpacing;
      const numGraves86 = 59; // adjust the graves
      createGraveColumn(startLat86, startLng86, numGraves86, 1, "E", 86);

      const startLat87 = 14.87063;  // Adjusted latitude
      const startLng87 = startLng86 + columnSpacing;
      const numGraves87 = 52; // adjust the graves
      createGraveColumn(startLat87, startLng87, numGraves87, 1, "E", 87);

      const startLat88 = 14.87062;  // Adjusted latitude
      const startLng88 = startLng87 + columnSpacing;
      const numGraves88 = 47; // adjust the graves
      createGraveColumn(startLat88, startLng88, numGraves88, 1, "E", 88);

      const startLat89 = 14.87060;  // Adjusted latitude
      const startLng89 = startLng88 + columnSpacing;
      const numGraves89 = 42; // adjust the graves
      createGraveColumn(startLat89, startLng89, numGraves89, 1, "E", 89);

      const startLat90 = 14.87059;  // Adjusted latitude
      const startLng90 = startLng89 + columnSpacing;
      const numGraves90 = 35; // adjust the graves
      createGraveColumn(startLat90, startLng90, numGraves90, 1, "E", 90);

      const startLat91 = 14.87057;  // Adjusted latitude
      const startLng91 = startLng90 + columnSpacing;
      const numGraves91 = 30; // adjust the graves
      createGraveColumn(startLat91, startLng91, numGraves91, 1, "E", 91);

      const startLat92 = 14.87056;  // Adjusted latitude
      const startLng92 = startLng91 + columnSpacing;
      const numGraves92 = 23; // adjust the graves
      createGraveColumn(startLat92, startLng92, numGraves92, 1, "E", 92);

      const startLat93 = 14.87055;  // Adjusted latitude
      const startLng93 = startLng92 + columnSpacing;
      const numGraves93 = 17; // adjust the graves
      createGraveColumn(startLat93, startLng93, numGraves93, 1, "E", 93);

      const startLat94 = 14.87054;  // Adjusted latitude
      const startLng94 = startLng93 + columnSpacing;
      const numGraves94 = 11; // adjust the graves
      createGraveColumn(startLat94, startLng94, numGraves94, 1, "E", 94);

      const startLat95 = 14.87053;  // Adjusted latitude
      const startLng95 = startLng94 + columnSpacing;
      const numGraves95 = 5; // adjust the graves
      createGraveColumn(startLat95, startLng95, numGraves95, 1, "E", 95);


      // Phase 1 Lawn E (Should contain approximately 399 graves)
      const startLat96 = 14.871400;  // Adjusted latitude
      const startLng96 = startLng70 + columnSpacing + columnSpacing + columnSpacing + columnSpacing
        + columnSpacing + columnSpacing + columnSpacing + columnSpacing;
      const numGraves96 = 47; // adjust the graves
      createGraveColumn(startLat96, startLng96, numGraves96, 1, "F", 96);

      const startLat97 = 14.871390;  // Adjusted latitude
      const startLng97 = startLng96 + columnSpacing;
      const numGraves97 = 48; // adjust the graves
      createGraveColumn(startLat97, startLng97, numGraves97, 1, "F", 97);

      const startLat98 = 14.871380;  // Adjusted latitude
      const startLng98 = startLng97 + columnSpacing;
      const numGraves98 = 49; // adjust the graves
      createGraveColumn(startLat98, startLng98, numGraves98, 1, "F", 98);

      const startLat99 = 14.871360;  // Adjusted latitude
      const startLng99 = startLng98 + columnSpacing;
      const numGraves99 = 52; // adjust the graves
      createGraveColumn(startLat99, startLng99, numGraves99, 1, "F", 99);

      const startLat100 = 14.8713435;  // Adjusted latitude
      const startLng100 = startLng99 + columnSpacing;
      const numGraves100 = 52; // adjust the graves
      createGraveColumn(startLat100, startLng100, numGraves100, 1, "F", 100);

      const startLat101 = 14.871290;  // Adjusted latitude
      const startLng101 = startLng100 + columnSpacing;
      const numGraves101 = 57; // adjust the graves
      createGraveColumn(startLat101, startLng101, numGraves101, 1, "F", 101);

      const startLat102 = 14.871290;  // Adjusted latitude
      const startLng102 = startLng101 + columnSpacing;
      const numGraves102 = 56; // adjust the graves
      createGraveColumn(startLat102, startLng102, numGraves102, 1, "F", 102);

      const startLat103 = 14.871290;  // Adjusted latitude
      const startLng103 = startLng102 + columnSpacing;
      const numGraves103 = 55; // adjust the graves
      createGraveColumn(startLat103, startLng103, numGraves103, 1, "F", 103);

      const startLat104 = 14.871285;  // Adjusted latitude
      const startLng104 = startLng103 + columnSpacing;
      const numGraves104 = 53; // adjust the graves
      createGraveColumn(startLat104, startLng104, numGraves104, 1, "F", 104);

      const startLat105 = 14.871285;  // Adjusted latitude
      const startLng105 = startLng104 + columnSpacing;
      const numGraves105 = 46; // adjust the graves
      createGraveColumn(startLat105, startLng105, numGraves105, 1, "F", 105);

      const startLat106 = 14.871285;  // Adjusted latitude
      const startLng106 = startLng105 + columnSpacing;
      const numGraves106 = 37; // adjust the graves
      createGraveColumn(startLat106, startLng106, numGraves106, 1, "F", 106);

      const startLat107 = 14.871285;  // Adjusted latitude
      const startLng107 = startLng106 + columnSpacing;
      const numGraves107 = 27; // adjust the graves
      createGraveColumn(startLat107, startLng107, numGraves107, 1, "F", 107);

      const startLat108 = 14.871285;  // Adjusted latitude
      const startLng108 = startLng107 + columnSpacing;
      const numGraves108 = 20; // adjust the graves
      createGraveColumn(startLat108, startLng108, numGraves108, 1, "F", 108);

      const startLat109 = 14.871285;  // Adjusted latitude
      const startLng109 = startLng108 + columnSpacing;
      const numGraves109 = 11; // adjust the graves
      createGraveColumn(startLat109, startLng109, numGraves109, 1, "F", 109);

      const startLat110 = 14.871285;  // Adjusted latitude
      const startLng110 = startLng109 + columnSpacing;
      const numGraves110 = 3; // adjust the graves
      createGraveColumn(startLat110, startLng110, numGraves110, 1, "F", 110);


      // Phase 1 Lawn G (Should contain approximately 628 graves)
      const startLat111 = 14.871400;  // Adjusted latitude
      const startLng111 = startLng110 + columnSpacing + columnSpacing + columnSpacing + columnSpacing
        + columnSpacing + columnSpacing + columnSpacing + columnSpacing;
      const numGraves111 = 47; // adjust the graves
      createGraveColumn(startLat111, startLng111, numGraves111, 1, "G", 111);



      var latlngs = [
        [14.871167768208937, 120.97843093203585],
        [14.870471704771298, 120.9785971468332]
      ];

      // Create a polyline (line) from the coordinates
      var polyline = L.polyline(latlngs, {
        color: 'blue',        // Line color
        weight: 4,            // Line thickness
        opacity: 0.7          // Line opacity
      }).addTo(map);

      var latlngs2 = [
        [14.871135034293799, 120.9786334756037], // 14.871135034293799, 120.9786334756037
        [14.870500357332057, 120.97880163288028]  // 14.870500357332057, 120.97880163288028
      ];

      // Create a polyline (line) from the coordinates
      var polyline = L.polyline(latlngs2, {
        color: 'blue',        // Line color
        weight: 4,            // Line thickness
        opacity: 0.7          // Line opacity
      }).addTo(map);

      // 14.87082324409059, 120.9783014139407
      // 14.870842342045782, 120.9784930837253
      var latlngs3 = [
        [14.87082324409059, 120.9785114756037],
        [14.870842342045782, 120.9782720837253]
      ];

      // Create a polyline (line) from the coordinates
      var polyline = L.polyline(latlngs3, {
        color: 'blue',        // Line color
        weight: 4,            // Line thickness
        opacity: 0.7          // Line opacity
      }).addTo(map);





      // const startLat39 = 14.871400;
      // const startLng39 = startLng38 + columnSpacing;
      // const numGraves39 = 37;
      // createGraveColumn(startLat39, startLng39, numGraves39, 1, "A", 39);

      // const startLat40 = 14.871400;
      // const startLng40 = startLng39 + columnSpacing;
      // const numGraves40 = 38;
      // createGraveColumn(startLat40, startLng40, numGraves40, 1, "A", 40);

      // const startLat41 = 14.871400;
      // const startLng41 = startLng40 + columnSpacing;
      // const numGraves41 = 38;
      // createGraveColumn(startLat41, startLng41, numGraves41, 1, "A", 41);

      // const startLat42 = 14.871400;
      // const startLng42 = startLng41 + columnSpacing;
      // const numGraves42 = 38;
      // createGraveColumn(startLat42, startLng42, numGraves42, 1, "A", 42);


      // Add legend to the map
      const legend = L.control({
        position: "bottomright"
      });

      legend.onAdd = function () {
        const div = L.DomUtil.create("div", "info legend");

        // Status options and colors
        const statuses = {
          "Available": "#28a745", // Green
          "Reserved": "#ffc107", // Yellow
          "Sold": "#dc3545", // Red
          "Sold and Occupied": "#6c757d" // Gray
        };

        // Create legend content
        div.innerHTML = "<h4>Grave Status</h4>";
        for (const status in statuses) {
          div.innerHTML +=
            `<i style="background:${statuses[status]}; width: 18px; height: 18px; display: inline-block; margin-right: 5px;"></i>` +
            `${status}<br>`;
        }

        return div;
      };

      legend.addTo(map);
    });
  </script>


</body>

</html>