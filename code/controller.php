<?php session_start();include("templates/page_header.php");?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method
    //get table information
    $control = $_POST['control'];
    $n_water = $_POST['plant'];

    if($control ==1){
        update_status($dbconn, $n_water);
        }
    $result = get_plants($dbconn);
	while ($row = pg_fetch_array($result)) {
        $data_item['id'] = $row['id'];
        $data_item['name'] = $row['p_name'];
        $data_item['last_watered'] = $row['last_watered'];
        $data_item['status'] = $row['p_status'];
        $items[] = $data_item;
        }
    //send variables to plant monitor
    $_SESSION['items'] = $items;
    //echo($items[0]['name']); = plant 1
    header('Location: plantmonitor.php');
}
?>
<!-- <?php  ?> -->