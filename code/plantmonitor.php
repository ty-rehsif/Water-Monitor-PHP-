<?php session_start();include("templates/page_header.php");?>
<!DOCTYPE html>
<h1>Welcome, thanks for this oppurtunity</h1>
<h2>Plant monitor:</h2>

<?php $data = $_SESSION['items'];
$_SESSION['token'] = (bin2hex(openssl_random_pseudo_bytes(32)));
$token = $_SESSION['token'];
?>
<?php if(empty($data)){ ?>
<form action="/controller.php" method="POST">
<input type="hidden" name="csrftoken" value="">
<input type="submit" value="Start" >
<?php }?>  

<?php if(!empty($data)){ ?>
</form>
<form action="controller.php" method="POST" onsubmit=<?php echo "delay(this);"?>>
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
        <?php echo "<script>alert(('$data[$x]['update']'-now())></script>"?>
        <td><?php echo $data[$x]['last_watered'];?></td>
        <td><?php echo $data[$x]['status'];?></td>
        <td>
            <input type="checkbox" name="plant[]" value="<?=$data[$x]['id']?>">
            <input type="hidden" name="token" value=<?=$token?>>
            <input type="hidden" name="control" value="1">
        </td>
    </tr>
        <?php }?>     
</table>
<input type="submit" value="submit" onclick="">
</form>
<?php } ?>
<script>
    function delay(obj) {
    obj.disabled = true;
    setTimeout(function() {
        obj.disabled = false;
    }, 10000);
}
</script>

</html>