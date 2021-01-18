<?php

function connect($host = "localhost", $user = "root", $pass = "root", $dbname = "phpdz12")
{
    $link = mysqli_connect($host, $user, $pass) or die("Failed connect to server");
    mysqli_select_db($link, $dbname) or die("Failed connet to database");
    mysqli_query($link, "set names 'utf-8'");
    return $link;
}

$link = connect();
class Picture
{
    public $id;
    public $name;
    public $path;
    public $size;

    function __construct($id, $name, $path, $size)
    {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->size = $size;
    }
}

class PicturesTable
{
    public $picturesArr = [];

    function __construct()
    {
        global $link;
        $q = "SELECT * FROM Pictures";
        $query = mysqli_query($link, $q) or die("Ошибка при извлечении");
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($this->picturesArr, new Picture($row['id'], $row['name'], $row['path'], $row['size']));
        }
    }

    public function moveToDb($files)
    {
        global $link;
        for ($i = 0; $i < count($files["input__file"]["name"]); $i++) {
            if ($files && $files["input__file"]["error"][$i] == UPLOAD_ERR_OK) {
                $imgName = $files["input__file"]["name"][$i];
                $imgName = str_replace(" ", "_", $imgName);
                $filesize = filesize($files["input__file"]["tmp_name"][$i]);

                if (!file_exists("images/" . $imgName)) {
                    move_uploaded_file($files["input__file"]["tmp_name"][$i], "images/" . $imgName);
                }
                $imgPath = "images/" . $imgName;
                $q = "INSERT INTO Pictures (name, path, size) VALUES ('" . $imgName . "','" . $imgPath . "','" . $filesize . "')";
                $query = mysqli_query($link, $q);
                if (mysqli_errno($link) == 1406) {
                    echo "<h3 align='center' style='color: red'>" . $imgName . ": Размер файла слишком большой!</h3>";
                } else if (mysqli_errno($link) == 0) {
                    echo "<h3 align='center' style='color: green'>" . $imgName . ": Файл добавлен</h3>";
                }
            }
        }
        return true;
    }
}