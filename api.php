<?php
$link = mysqli_connect('localhost','root','','nspay');
if (!$link){
    echo 'Failed';
}

$action = 'read';
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

$response = [
    'error' => false
];
$users = array();

if ($action=='read'){
    $result = mysqli_query($link,"SELECT * FROM `users` ORDER by id DESC LIMIT 10");
    if ($result){
        $response = [
            'msg' => 'Add Successfull',
        ];

        while ($row = mysqli_fetch_assoc($result)){
            array_push($users,$row);
        }
        $response['users'] = $users;
    }else{
        $response = [
            'error' => true,
            'msg' => 'Record Failed',
        ];
    }

}
elseif ($action=='creat'){
    $name = $_POST['name'];
    $number = $_POST['number'];
    $result = mysqli_query($link,"INSERT INTO `users`(`name`, `phone`) VALUES ('$name','$number')");
    if ($result){
        $response = [
            'msg' => 'Add Successfull',
        ];
    }else{
        $response = [
            'error' => true,
            'msg' => 'Add Failed',
        ];
    }
}
elseif ($action=='update'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $result = mysqli_query($link,"UPDATE `users` SET `name`='$name',`phone`='$number' WHERE `id` = '$id'");
    if ($result){
        $response = [
            'msg' => 'Update Successfull',
        ];
    }else{
        $response = [
            'error' => true,
            'msg' => 'Update Failed',
        ];
    }
}
elseif ($action=='delete'){
    $id = $_POST['id'];
    $result = mysqli_query($link,"DELETE FROM `users` WHERE `id` = '$id'");
    if ($result){
        $response = [
            'msg' => 'Delete Successfull',
        ];
    }else{
        $response = [
            'error' => true,
            'msg' => 'Delete Failed',
        ];
    }
}
else {
    echo 'Invalid Action';
}

header('content-type: Application/json');
echo json_encode($response);

