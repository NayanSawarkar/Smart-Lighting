<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('colors.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      margin: 0;
      padding: 0;
      color: #333; /* Set default text color */
    }

    .center {
      text-align: center;
      margin-top: 20px;
    }

    h1 {
      font-size: 48px;
      font-weight: bold;
      color: #337ab7; /* Set heading color */
      margin-bottom: 20px;
    }

    h2 {
      font-size: 24px;
      font-weight: bold;
      color: #d9534f; /* Set heading color */
      margin-top: 40px;
      margin-bottom: 10px;
    }

    table {
      width: 90%;
      margin: 0 auto;
      border-collapse: collapse;
      border: 2px solid #ccc; /* Add border */
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
      background-color: #fff;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc; /* Add border */
    }

    th {
      background-color: #f5f5f5; /* Light gray background for headers */
    }

    tr:nth-child(even) {
      background-color: #f2f2f2; /* Alternate row color */
    }

    a {
      color: #337ab7; /* Set link color */
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline; /* Add underline on hover */
    }
  </style>
  <title>HTML Table</title>
</head>
<body>
  <div class="center">
    <h1>Status Of Lights</h1>
  </div>

  <!-- Active Lights Table -->
  <div class="center">
    <h2>Active Lights</h2>
    <table>
      <thead>
        <tr>
          <th>Light ID</th>
          <th>Landmark</th>
          <th>Status</th>
          <th>Location</th>
          <th>Last Updated</th>
        </tr>
      </thead>
      <tbody>
        <!-- PHP code for active lights goes here -->
        <?php
          error_reporting(0);
          $hostname = "localhost";
          $username = "root";
          $password = "";
          $database = "sensorinformation";

          $conn = mysqli_connect($hostname, $username, $password, $database);

          if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
          }

          // Fetch data for active lights
          $active_query = "SELECT * FROM dht11 WHERE status = 1";
          $active_result = mysqli_query($conn, $active_query);

          if(mysqli_num_rows($active_result) > 0) {
              while($row = mysqli_fetch_assoc($active_result)) {
                  $id = $row['id'];
                  $landmark = $row['Landmark'];
                  $google_maps_link = $row['location'];
                  $last_updated = $row['datetime']; // Retrieve datetime from database

                  // Format datetime
                  $last_updated_formatted = date('Y-m-d H:i:s', strtotime($last_updated));

                  ?>
                  <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $landmark; ?></td>
                      <td>Active</td>
                      <td><a href="<?php echo $google_maps_link; ?>" target="_blank">View on Google Maps</a></td>
                      <td><?php echo $last_updated_formatted; ?></td> <!-- Display Last Updated -->
                  </tr>
                  <?php
              }
          }
          ?>
      </tbody>
    </table>
  </div>

  <!-- Inactive Lights Table -->
  <div class="center">
    <h2>Inactive Lights</h2>
    <table>
      <thead>
        <tr>
          <th>Light ID</th>
          <th>Landmark</th>
          <th>Status</th>
          <th>Location</th>
          <th>Last Updated</th>
        </tr>
      </thead>
      <tbody>
        <!-- PHP code for inactive lights goes here -->
        <?php
          error_reporting(0);
          $hostname = "localhost";
          $username = "root";
          $password = "";
          $database = "sensorinformation";

          $conn = mysqli_connect($hostname, $username, $password, $database);

          if (!$conn) {
             die("Connection failed: " . mysqli_connect_error());
          }

          // Fetch data for active lights
          $active_query = "SELECT * FROM dht11 WHERE status = 0";
          $active_result = mysqli_query($conn, $active_query);

          if(mysqli_num_rows($active_result) > 0) {
              while($row = mysqli_fetch_assoc($active_result)) {
                  $id = $row['id'];
                  $landmark = $row['Landmark'];
                  $google_maps_link = $row['location'];
                  $last_updated = $row['datetime']; // Retrieve datetime from database

                  // Format datetime
                  $last_updated_formatted = date('Y-m-d H:i:s', strtotime($last_updated));

                  ?>
                  <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $landmark; ?></td>
                      <td>InActive</td>
                      <td><a href="<?php echo $google_maps_link; ?>" target="_blank">View on Google Maps</a></td>
                      <td><?php echo $last_updated_formatted; ?></td> <!-- Display Last Updated -->
                  </tr>
                  <?php
              }
          }
          ?>
      </tbody>
    </table>
  </div>
</body>
</html>
