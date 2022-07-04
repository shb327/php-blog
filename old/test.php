<?php
    require("head.php");

    $connection = mysqli_connect("127.0.0.1", "root", "", "test");
    if(!$connection){
        echo "Connection is not established!<brt>";
        echo mysqli_connect_error();
        exit();
    }

$resultAll = mysqli_query($connection, "SELECT * FROM Article_Category");

if(!$resultAll){
    die(mysqli_error($connection));
}
?>

<ul>
    <?php
    if (mysqli_num_rows($resultAll) > 0) {
        while($rowCatData = mysqli_fetch_assoc($resultAll)){
            $articles_count = mysqli_query($connection, "SELECT COUNT(id) AS total_count FROM Article WHERE category_id = ".$rowCatData["id"]);
            $articles_count_res = mysqli_fetch_assoc($articles_count);
            echo '<li>'.$rowCatData["Title"].' ('.$articles_count_res['total_count'].')</li>';
        }
    }else{
        echo "No categories are found!";
    }
    ?>
</ul>

<?php
mysqli_close($connection);
require("footer.php");
?>