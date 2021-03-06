<?php
require_once('../includes/connection.inc.php');
// create database connection
$conn = dbConnect('write');
if (isset($_POST['insert'])) {
  // initialize flag
  $OK = false;
  // create SQL
  $sql = 'INSERT INTO blog (title, article, created)
		  VALUES(?, ?, NOW())';
  // initialize prepared statement
  $stmt = $conn->stmt_init();
  $stmt->prepare($sql);
  // bind parameters and execute statement
  $stmt->bind_param('ss', $_POST['title'], $_POST['article']);
  // execute and get number of affected rows
  $stmt->execute();
  $OK = $stmt->affected_rows;
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/phpsols/admin/blog_list_mysqli.php');
	exit;
  } else {
	$error = $stmt->error;
  }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Insert Blog Entry</title>
<link href="../styles/admin.css" rel="stylesheet" type="text/css">
</head>

<body>
<h1>Insert New Blog Entry</h1>
<?php if (isset($error)) {
  echo "<p>Error: $error</p>";
} ?>
<form id="form1" method="post" action="" enctype="multipart/form-data">
  <p>
    <label for="title">Title:</label>
    <input name="title" type="text" class="widebox" id="title" value="<?php if (isset($error)) {
	  echo htmlentities($_POST['title'], ENT_COMPAT, 'utf-8');
	} ?>">
  </p>
  <p>
    <label for="article">Article:</label>
    <textarea name="article" cols="60" rows="8" class="widebox" id="article"><?php if (isset($error)) {
	  echo htmlentities($_POST['article'], ENT_COMPAT, 'utf-8');
	} ?></textarea>
  </p>
  <p>
    <label for="category">Categories:</label>
    <select name="category[]" size="5" multiple id="category">
    <?php
	// get categories
	$getCats = 'SELECT cat_id, category FROM categories
	            ORDER BY category';
	$categories = $conn->query($getCats);
	while ($row = $categories->fetch_assoc()) {
	?>
    <option value="<?php echo $row['cat_id']; ?>" <?php
    if (isset($_POST['category']) && in_array($row['cat_id'], $_POST['category'])) {
	  echo 'selected';
	} ?>><?php echo $row['category']; ?></option>
    <?php } ?>
    </select>
  </p>
  <p>
    <input type="submit" name="insert" value="Insert New Entry">
  </p>
</form>
</body>
</html>