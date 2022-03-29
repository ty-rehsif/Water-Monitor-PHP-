<?php session_start();include("templates/page_header.php");?>
<?php
//only allow processing when the method is post and when the session csrf token and form sent token are the same
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION['token']===$_POST['token'])) {
        //get the indicator to determine if table should be updated
        $control = $_POST['control'];
        //getting the id of which plant to water
        $n_water = $_POST['plant'];
        //if there is a request to water and the need to water variable is not empty then update
        if($control ==1 && !(empty($_POST['plant']))){
            update_status($dbconn, $n_water);
            }
        //get the plants from the database
        $result = get_plants($dbconn);
        //populate data variable using retrieved/queried database data
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
        header('Location: watermango.php');
    }
?>