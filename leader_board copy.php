<?php 
session_start();

if(isset($_SESSION['leaderboard'])){
    $leaderBoard = $_SESSION['leaderboard'];
} else{
    $leaderBoard = [];
}
// unset($_SESSION['leaderboard']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leaderboard</title>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .leaderboard-table {
        width: 60%;
        margin: 20px auto;
        border-collapse: collapse;
    }
    .leaderboard-table th, 
    .leaderboard-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .leaderboard-table th {
        background-color: #04AA6D;
        color: white;
    }
    .leaderboard-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .leaderboard-table tr:hover {
        background-color: #ddd;
    }
    a.button {
    display: inline-block;
    text-decoration: none;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
}

a.button:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>
    <table class="leaderboard-table" id="data-table">
        <h2>Leader Board</h2>
        <a href="option.php" class="button">Home Page</a>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaderBoard as $index => $entry): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($entry['name']); ?></td>
                <td><?php echo htmlspecialchars($entry['score']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script type="text/javascript">
    $(document).ready(function() {
      $('#data-table').DataTable();
    } );
  </script>
</html>
