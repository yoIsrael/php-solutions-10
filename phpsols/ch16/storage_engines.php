<?php
// edit the first three lines to match your remote server setup
$host = 'localhost';
$username = 'username';
$password = 'password';
$conn = new MySQLi($host, $username, $password);
$sql = 'SHOW ENGINES';
$result = $conn->query($sql) or die ($conn->error);
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Check Storage Engines</title>
</head>

<body>
<table>
<tr>
  <th>Storage Engine</th><th>Supported</th>
</tr>
<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
  <td><?php echo $row['Engine']; ?></td><td><?php echo $row['Support']; ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>