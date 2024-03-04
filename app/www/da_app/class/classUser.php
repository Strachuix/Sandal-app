<?php

class User
{
    public $id;
    public $username;
    public $name;
    public $surname;
    public $birthday;
    public $email;
    public $phone;
    public $role;

    public function __construct($user = null)
    {
    }

    private function initializeUser($user)
    {
        $this->id = $user['id'];
        $this->username = $user['username'];
        $this->name = $user['name'];
        $this->surname = $user['surname'];
        $this->birthday = $user['birthday'];
        $this->email = $user['email'];
        $this->phone = $user['phone'];
        $this->role = $user['role'];
    }

    public function login($username, $password)
    {
        $username = mysqli_real_escape_string($GLOBALS['connect'], $username);
        $password = mysqli_real_escape_string($GLOBALS['connect'], $password);

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($GLOBALS['connect'], $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            // echo hash("sha256", $password);
            // echo "<br>";
            // echo $hashed_password;
            if (hash("sha256", $password) == $hashed_password) {
                $this->initializeUser($row);
                $_SESSION['user_id'] = $this->id;
                $_SESSION['user'] = serialize($this);

                return true;
            }
        }

        return false;
    }

    public function signUp($data)
    {
        // Escape user input to prevent SQL injection
        $username = mysqli_real_escape_string($GLOBALS['connect'], $data['username']);
        $password = mysqli_real_escape_string($GLOBALS['connect'], $data['password']);
        $email = mysqli_real_escape_string($GLOBALS['connect'], $data['email']);
        $name = mysqli_real_escape_string($GLOBALS['connect'], $data['name']);
        $surname = mysqli_real_escape_string($GLOBALS['connect'], $data['surname']);
        $birthday = mysqli_real_escape_string($GLOBALS['connect'], $data['birthday']);
        $phone = mysqli_real_escape_string($GLOBALS['connect'], $data['phone']);
        $role = mysqli_real_escape_string($GLOBALS['connect'], $data['role']);

        $hashed_password = hash("sha256", $password);

        $sql = "INSERT INTO users
                (`username`, `password`, `name`, `surname`, `birthday`, `email`, `phone`)
                VALUES
                ('$username', '$hashed_password', '$name', '$surname', '$birthday',  '$email', '$phone')";

        $result = mysqli_query($GLOBALS['connect'], $sql);

        if ($result) {
            $this->id = mysqli_insert_id($GLOBALS['connect']);
            $this->username = $username;
            $this->name = $name;
            $this->surname = $surname;
            $this->birthday = $birthday;
            $this->email = $email;
            $this->phone = $phone;
            $this->role = $role;

            return true;
        } else {
            return false;
        }
    }

    public function userExists($filter)
    {
        $filter = mysqli_real_escape_string($GLOBALS['connect'], $filter);

        $sql = "SELECT * FROM users WHERE username = '$filter' OR id = '$filter' OR email = '$filter'";
        $result = mysqli_query($GLOBALS['connect'], $sql);

        return ($result && mysqli_num_rows($result) > 0);
    }

    public function updateData($data)
    {
        $id = $_SESSION['user_id'];

        // Escape user input to prevent SQL injection
        $username = mysqli_real_escape_string($GLOBALS['connect'], $data['login']);
        $password = mysqli_real_escape_string($GLOBALS['connect'], $data['password']);
        $email = mysqli_real_escape_string($GLOBALS['connect'], $data['email']);
        $name = mysqli_real_escape_string($GLOBALS['connect'], $data['name']);
        $surname = mysqli_real_escape_string($GLOBALS['connect'], $data['surname']);
        $phone = mysqli_real_escape_string($GLOBALS['connect'], $data['phone']);
        $role = isset($data['role']) ? mysqli_real_escape_string($GLOBALS['connect'], $data['role']) : $this->role;

        $hashed_password = hash("sha256", $password);

        $sql = "UPDATE users SET 
                `username` = '$username',
                `password` = '$hashed_password',
                `role` = '$role',
                `name` = '$name',
                `surname` = '$surname',
                `email` = '$email',
                `phone` = '$phone'
                `role` = '$role',
                WHERE id = $id";
        $result = mysqli_query($GLOBALS['connect'], $sql);

        if ($result) {
            // Update session with the new user data
            $this->username = $username;
            $this->name = $name;
            $this->surname = $surname;
            $this->email = $email;
            $this->phone = $phone;
            $this->role = $role;
            $_SESSION['user'] = serialize($this);
        }

        return $result ? true : false;
    }

    public function getPrayArray()
    {
        $sql = "SELECT prayers.*, users.name, users.surname, users.username FROM prayers
        LEFT JOIN users ON users.id = prayers.second_person
        WHERE first_person = " . $this->id . "
        AND date_start < '" . date('Y-m-d H:i:s', time()) . "'
        AND date_stop > '" . date('Y-m-d H:i:s', time()) . "'
        ORDER BY date_start DESC";

        $res = mysqli_query($GLOBALS['connect'], $sql);
        $pray_array = [];
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($pray_array, $row);
        }
        return $pray_array;
    }

    public function getPrayPersons($filter = null)
    { // $filter = ['name', 'surname', 'username'] or all
        if ($filter == null) {
            $filter = ['name', 'surname', 'username'];
        }

        $pray_array = $this->getPrayArray();
        if (count($pray_array) < 3) {
            $table = "<table>";
            foreach ($pray_array as $row) {
                $table .= "<tr>";
                foreach ($row as $key => $val) {
                    if ($filter == null || in_array($key, $filter)) {
                        $table .= "<td key='$key'>$val</td>";
                    }
                }
                $table .= "</tr>";
            }
            $table .= "</table>";
        } else {
        }
        return $table;
    }

    public function getGroups()
    {
        $sql = "SELECT
                `groups`.*
            FROM
                `groups_members`
            LEFT JOIN `groups` ON `groups`.`id` = `groups_members`.`group_id`
            WHERE
                `user_id` = " . $this->id . " AND `active` = 1
            ORDER BY
                `groups_members`.`join_date`";
        // echo $sql;
        //get all groups data
        $res = mysqli_query($GLOBALS['connect'], $sql);
        if (mysqli_num_rows($res) > 0) {
            $groups = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $group = [
                    "group_id" => $row["id"],
                    "group_name" => $row["group_name"],
                    "leader_id" => $row["leader_id"]
                ];
                array_push($groups, $group);
            }
            return $groups;
        } else {
            return false;
        }
    }

    public function getMeetings($timestamp = null)
    {
        $groups = $this->getGroups();
        if ($groups == false) {
            return "No groups to show";
        } else {
            $group_id_array = array();
            $id_search = "";
            foreach ($groups as $group) {
                array_push($group_id_array, $group['group_id']);
            }
            if (count($group_id_array) == 1) {
                $id_search = $group_id_array[0];
            } else {
                $temp_array = array_map(function ($element) {
                    return "'" . $element . "'";
                }, $group_id_array);
                $id_search = implode(', ', $temp_array);
            }

            $where = '';
            if ($timestamp != null) {
                $where = " AND meetings.date BETWEEN $timestamp AND " . strtotime('+1 day', $timestamp);
            }
            $sql = "SELECT `groups`.`group_name`, `meetings`.`id`, `meetings`.`date`, `meetings`.`group_id` FROM `meetings` LEFT JOIN `groups` ON `groups`.`id` = `meetings`.`group_id` WHERE `meetings`.`group_id` IN ($id_search) $where ORDER BY `meetings`.`date` DESC";
            $res = mysqli_query($GLOBALS['connect'], $sql);
            $out = [];
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    if ($row['date'] != null) {
                        $row['time'] = date('H:i', strtotime($row['date']));
                    } else {
                        $row['time'] = 'Jeszcze nie wiemy';
                    }
                    array_push($out, $row);
                }
            }
            return $out;
        }
    }

    public function getEvents() //TODO
    {
    }

    public function isInGroup($group_id, $user_id = null)
    {
        $user_id = $user_id == null ? $this->id : $user_id;
        $sql = "SELECT id FROM groups_members WHERE user_id = $user_id AND group_id = $group_id";
        $res = mysqli_query($GLOBALS['connect'], $sql);
        if(mysqli_num_rows($res) != 0){
            return true;
        }else{
            return false;
        }
    }

    public function joinGroup($group_id)
    {
        if($this -> isInGroup($group_id)){
            return "Jesteś już w tej grupie";
        }else{
            $sql = "INSERT INTO `groups_members`(`user_id`, `group_id`) VALUES ('$this->id','$group_id')";
            mysqli_query($GLOBALS['connect'], $sql);
            return "Zostałeś dodany";
        }
    }

    public function createGroup($group_name)
    {
        $sql = "INSERT INTO `groups`(`group_name`, `leader_id`) VALUES ('$group_name','$this->id')";
        mysqli_query($GLOBALS['connect'], $sql);
        $last_id = mysqli_insert_id($GLOBALS['connect']);
        $this->joinGroup($last_id);
    }
}
