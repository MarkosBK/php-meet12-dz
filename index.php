<?php
include_once("classes.php");
$pictTable = new PicturesTable();
if (isset($_POST['addPicture'])) {
    if ($pictTable->moveToDb($_FILES)) {
?>
<script>
setTimeout(() => {
    window.location = document.URL;
}, 2000);
</script>
<?php
    } else {
        echo "<h3 align='center' style='color: red'>Возникла ошибка!</h3>";
    }
} else {
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="index.php" method="POST" enctype="multipart/form-data" class="container mx-auto mt-5">
        <div class="input__wrapper">
            <input type="file" id="input__file" name="input__file[]" class="input__file" accept="image/*" multiple>
            <label for="input__file" class="btn btn-dark input__file-button m-0">
                <span class="input__file-button-text">Выберите файлы</span>
            </label>
            <input type="submit" id="addPicture" name="addPicture" value="Add" class="btn btn-primary" disabled>
        </div>
    </form>
    <div class="container">
        <table class="table p-5">
            <thead>
                <tr>
                    <th scope="col" class='py-1 px-1 col-9'>Name</th>
                    <th scope="col" class='py-1 px-1 col-1'>Size</th>
                    <th scope="col" class='py-1 px-1 col-1'>Picture</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $pictures = $pictTable->picturesArr;
                    for ($i = 0; $i < count($pictures); $i++) {
                        echo "<tr>";
                        echo "<td class='py-1 px-1'>" . $pictures[$i]->name . "</td>";
                        echo "<td class='py-1 px-1'>" . $pictures[$i]->size . "</td>";
                        echo "<td class='py-1 px-1'><div class='divImage' style='width:200px; height:150px; background-image: url(" . $pictures[$i]->path . ")'></td>";
                        echo "</tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
    var input = document.getElementById("input__file");

    $(input).change(function(e) {
        let submit = document.getElementById("addPicture");
        let label = input.nextElementSibling,
            labelVal = label.querySelector('.input__file-button-text').innerText;
        let countFiles = '';
        if (this.files && this.files.length >= 1) {
            countFiles = this.files.length;
            submit.disabled = false;
        } else {
            submit.disabled = true;
        }
        if (countFiles)
            label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
        else
            label.querySelector('.input__file-button-text').innerText = labelVal;
    });
    </script>
</body>

</html>
<?php
}
?>