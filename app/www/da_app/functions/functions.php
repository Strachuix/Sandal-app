<?php
    function getGroupData($group_id){
        $sql = "SELECT groups.*, users.name AS leader_name, users.surname AS leader_surname, users.username AS leader_username FROM groups LEFT JOIN users ON groups.leader_id = users.id WHERE group_id = $group_id";
        $res = mysqli_fetch_assoc(mysqli_query($GLOBALS['connect'], $sql));
        
    }
?>