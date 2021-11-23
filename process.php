<?php

    if (isset($_FILES) && !empty($_FILES)) {
        $filename = $_FILES['fileName']['name'];
        $filetype = $_FILES['fileName']['type'];
        $filesize = $_FILES['fileName']['size'];
        $filetmp_name = $_FILES['fileName']['tmp_name'];

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["fileName"]["name"]);
        $extension = end($temp);

        $newName = $filename.'-'.time().rand(0,10000).'.'.$extension;

        if ((($_FILES["fileName"]["type"] == "image/gif")
        || ($_FILES["fileName"]["type"] == "image/jpeg")
        || ($_FILES["fileName"]["type"] == "image/jpg")
        || ($_FILES["fileName"]["type"] == "image/pjpeg")
        || ($_FILES["fileName"]["type"] == "image/x-png")
        || ($_FILES["fileName"]["type"] == "image/png"))
        && ($_FILES["fileName"]["size"] < 20000000)
        && in_array($extension, $allowedExts))
        {
            if ($_FILES["fileName"]["error"] == 0)
            {
                move_uploaded_file($filetmp_name,"img/$newName");
                $server = $_SERVER['SERVER_NAME'];
                $domain = $_SERVER['REQUEST_URI'];
                $domain = explode('/',$domain)[1];
                echo $server.'/'.$domain.'/'."img/$newName";
            } else {
                echo 2;
            }
        } else {
            echo 1;
        }
}

?>