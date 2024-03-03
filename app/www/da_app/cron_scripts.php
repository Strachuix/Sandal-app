<?php
require './db_connect.php';

$sql = 'SELECT id FROM users WHERE role = "STRAP"';
$res = mysqli_query($connect, $sql);
$id_array = array();
while ($row = mysqli_fetch_array($res)) {
    array_push($id_array, $row['id']);
}
if(count($id_array) > 1){
    $pared_users = array();
    $temp = null;
    if (count($id_array) % 2 != 0) {
        $temp = array_pop($id_array);
    }
    shuffle($id_array);
    for ($i = 0; $i < count($id_array); $i += 2) {
        $indeksNastepny = $i + 1;
        if (isset($id_array[$indeksNastepny])) {
            $pared_users[] = [$id_array[$i], $id_array[$indeksNastepny]];
        } else {
            $pared_users[] = [$id_array[$i]];
        }
    }
    if($temp != null){
        //TODO
    }
}
?>