<?php session_start();include("templates/page_header.php");?>
<!DOCTYPE html>
<head>
<!-- -->
<!-- css styles-->
<style>
    table, th, td{
        border: 2px solid powderblue;
        align-content: center;
    }
    body{
    background-color: whitesmoke;
}
h1,h2{
    text-align: center;
    font-weight: bold;
    color:navy;
    font-family: calibri;
    text-decoration: underline;
    text-transform: uppercase;
}
.center {
    margin-left: auto;
  margin-right: auto;
}
</style>
</head>
<h1>Welcome and thank you for this oppurtunity</h1>
<h2>WaterMango [Plant Monitor]:</h2>
<body>
<!-- getting items from controller.php -->
    <?php $data = $_SESSION['items'];
#creating and setting the csrf token
    $_SESSION['token'] = (bin2hex(openssl_random_pseudo_bytes(32)));
#setting the token
    $token = $_SESSION['token'];
    ?>
<!-- if data not populated i.e. start not clicked -->
    <?php if(empty($data)){ ?>
        <form action="/controller.php" method="POST">
            <input type="hidden" name="token" value=<?=$token?>>
            <input type="submit" value="Start">
        </form>
    <?php }?>
<!-- if data is in the variable show the table -->
    <?php if(!empty($data)){?>
        <form action="controller.php" method="POST" name="water_form" id="water_form" onsubmit="water_btn.disabled = true; return true;">
            <table class = "center" style="width: 60%; text-align: center;">
            <!-- table header row with column headings-->
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Time Watered</th>
                    <th>Current Status</th>
                    <th>Time Until Next Watering</th>
                    <th>Select Plant(s) to Water</th>
                </tr>
                <!-- populate table using for loop (rows) -->
                    <?php for ($x = 0; $x<sizeof($data); $x++){?>
                        <tr>
                        <!-- plant id -->
                            <td><?php echo $data[$x]['id'];?></td>
                        <!-- plant name -->
                            <td><?php echo $data[$x]['name'];?></td>
                        <!-- time last watered -->
                            <td><?php echo date('h:i:s: A', strtotime($data[$x]['last_watered']));?></td>
                            <td><?php echo $data[$x]['status'];?></td>
                        <!-- 6 hours after last -->
                            <td><?php echo $u_time = date('h:i:s: A', (strtotime($data[$x]['last_watered'])+21600));?></td>
                        <!-- if now = 6 hours after a plant got watered then alert-->
                            <?php if ($u_time == date('h:i:s: A', strtotime("now"))){echo "<script>alert('Check the plants!')</script>";} ?>
                        <!-- selecting which plant to water-->
                            <td>
                                <input type="checkbox" name="plant[]" value="<?=$data[$x]['id']?>">
                                <input type="hidden" name="token" value=<?=$token?>>
                                <input type="hidden" name="control" value="1">
                            </td>
                        </tr>
                    <?php }?>
            </table>
                <!-- wanted to add if coming from the controller.php redirect disable or hide for 30 secs-->
                <input name="water_btn"  id="water_btn" type="submit" value="Water" onclick=<?php echo "delay(this); alert('Watering...');"?>>
        </form>
        <form action = "watermango.php" method="POST">
            <button>Stop Watering</button>
        </form>
    <?php } ?>
</body>
<script>
    function delay(obj) {
    //before click
    obj.disabled = true;
    alert("watering!");
        setTimeout(function() {
            //after click
            obj.disabled = false;
            obj.form.submit();
            }, 10000);
        }
    </script>
</html>