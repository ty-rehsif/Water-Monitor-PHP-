<?php session_start();include("templates/page_header.php");?>
<!DOCTYPE html>
<h1>Welcome, thanks for this oppurtunity</h1>
<h2>Plant monitor:</h2>

<?php echo "test".$_SESSION['start'];

$data = $_SESSION['items'];

echo $data[0]['id'];?>

<form action="/controller.php" method="POST">
<input type="hidden" name="csrftoken" value="">
<input type="submit" value="next" >





<?php if(!empty($data)){ ?>
</form>
<form action="controller.php" method="POST">
<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>last watered</th>
        <th>status</th>
        <th>action</th>
    </tr>
        <?php for ($x = 0; $x<sizeof($data); $x++){?>
    <tr>
        <td><?php echo $data[$x]['id'];?></td>
        <td><?php echo $data[$x]['name'];?></td>
        <?php echo "<script>alert(($data[$x]['update']-now())></script>"?>
        <td><?php echo $data[$x]['last_watered'];?></td>
        <td><?php echo $data[$x]['status'];?></td>
        <td>
            <input type="checkbox" name="plant[]" value="<?=$data[$x]['id']?>">
            <input type="hidden" name="control" value="1">
        </td>
    </tr>
        <?php }?>     
</table>
<input type="submit" value="submit">
</form>
<?php } ?>
</html>