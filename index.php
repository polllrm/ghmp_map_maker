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
    $(document).ready(function() {
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

      const columnSpacing = 0.0000095;

      // Phase 1 Lawn C (Should contain approximately 549 graves)
      const startLat1 = 14.8715855;
      const startLng1 = 120.9770481;
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

      const startLat20 = 14.871415;
      const startLng20 = startLng19 + columnSpacing;
      const numGraves20 = 32;
      createGraveColumn(startLat20, startLng20, numGraves20, 1, "C", 20);

      const startLat21 = 14.871415;
      const startLng21 = startLng20 + columnSpacing;
      const numGraves21 = 32;
      createGraveColumn(startLat21, startLng21, numGraves21, 1, "C", 21);

      const startLat22 = 14.871415;
      const startLng22 = startLng21 + columnSpacing;
      const numGraves22 = 33;
      createGraveColumn(startLat22, startLng22, numGraves22, 1, "C", 22);

      const startLat23 = 14.871415;
      const startLng23 = startLng22 + columnSpacing;
      const numGraves23 = 33;
      createGraveColumn(startLat23, startLng23, numGraves23, 1, "C", 23);

      const startLat24 = 14.871400;
      const startLng24 = startLng23 + columnSpacing;
      const numGraves24 = 34;
      createGraveColumn(startLat24, startLng24, numGraves24, 1, "C", 24);

      const startLat25 = 14.871405;
      const startLng25 = startLng24 + columnSpacing;
      const numGraves25 = 34;
      createGraveColumn(startLat25, startLng25, numGraves25, 1, "C", 25);

      const startLat26 = 14.871400 ;
      const startLng26 = startLng25 + columnSpacing;
      const numGraves26 = 35;
      createGraveColumn(startLat26, startLng26, numGraves26, 1, "C", 26);

      const startLat27 = 14.871400;
      const startLng27 = startLng26 + columnSpacing;
      const numGraves27 = 35;
      createGraveColumn(startLat27, startLng27, numGraves27, 1, "C", 27);

      const startLat28 = 14.871400;
      const startLng28 = startLng27 + columnSpacing;
      const numGraves28 = 35;
      createGraveColumn(startLat28, startLng28, numGraves28, 1, "C", 28);

      const startLat29 = 14.871400;
      const startLng29 = startLng28 + columnSpacing;
      const numGraves29 = 35;
      createGraveColumn(startLat29, startLng29, numGraves29, 1, "C", 29);

      const startLat30 = 14.871400;
      const startLng30 = startLng29 + columnSpacing;
      const numGraves30 = 36;
      createGraveColumn(startLat30, startLng30, numGraves30, 1, "C", 30);

      const startLat31 = 14.871400;
      const startLng31 = startLng30 + columnSpacing;
      const numGraves31 = 36;
      createGraveColumn(startLat31, startLng31, numGraves31, 1, "C", 31);

      const startLat32 = 14.871400;
      const startLng32 = startLng31 + columnSpacing;
      const numGraves32 = 36;
      createGraveColumn(startLat32, startLng32, numGraves32, 1, "C", 32);
      
      const startLat33 = 14.871400;
      const startLng33 = startLng32 + columnSpacing;
      const numGraves33 = 36;
      createGraveColumn(startLat33, startLng33, numGraves33, 1, "C", 33);

      const startLat34 = 14.871400;
      const startLng34 = startLng33 + columnSpacing;
      const numGraves34 = 36;
      createGraveColumn(startLat34, startLng34, numGraves34, 1, "C", 34);

      const startLat35 = 14.871400;
      const startLng35 = startLng34 + columnSpacing;
      const numGraves35 = 36;
      createGraveColumn(startLat35, startLng35, numGraves35, 1, "C", 35);

      const startLat36 = 14.871400;
      const startLng36 = startLng35 + columnSpacing;
      const numGraves36 = 37;
      createGraveColumn(startLat36, startLng36, numGraves36, 1, "C", 36);

      const startLat37 = 14.871400;
      const startLng37 = startLng36 + columnSpacing;
      const numGraves37 = 37;
      createGraveColumn(startLat37, startLng37, numGraves37, 1, "C", 37);

      const startLat38 = 14.871400;
      const startLng38 = startLng37 + columnSpacing;
      const numGraves38 = 37;
      createGraveColumn(startLat38, startLng38, numGraves38, 1, "C", 38);

      const startLat39 = 14.871400;
      const startLng39 = startLng38 + columnSpacing;
      const numGraves39 = 37;
      createGraveColumn(startLat39, startLng39, numGraves39, 1, "C", 39);

      const startLat40 = 14.871400;
      const startLng40 = startLng39 + columnSpacing;
      const numGraves40 = 38;
      createGraveColumn(startLat40, startLng40, numGraves40, 1, "C", 40);

      const startLat41 = 14.871400;
      const startLng41 = startLng40 + columnSpacing;
      const numGraves41 = 38;
      createGraveColumn(startLat41, startLng41, numGraves41, 1, "C", 41);

      const startLat42 = 14.871400;
      const startLng42 = startLng41 + columnSpacing;
      const numGraves42 = 38;
      createGraveColumn(startLat42, startLng42, numGraves42, 1, "C", 42);

      
      // Add legend to the map
      const legend = L.control({
        position: "bottomright"
      });

      legend.onAdd = function() {
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