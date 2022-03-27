<?php session_start();include("templates/page_header.php");?>
<!DOCTYPE html>
<h1>Welcome, thanks for this oppurtunity</h1>
<h2>Plant monitor:</h2>
<?php echo "test".$_SESSION['start'];?>

<form action="/controller.php" method="POST">
<input type="hidden" name="csrftoken" value="">
<input type="hidden" name="control" value="1">
<input type="submit" value="next" >
</form>
</html>