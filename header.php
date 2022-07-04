<?php
    require "includes/config.php";
    require "includes/db.php";
?>

<header id="header">
    <div class="header__top">
        <div class="container">
            <div class="header__top__logo">
                <h1>Bohdan's Blog</h1>
            </div>
            <nav class="header__top__menu">
                <ul>
                    <li><a href="index.php">Home Page</a></li>
                    <li><a href="about.php">About Me</a></li>
                    <li><a href="https://github.com/shb327">Social Media</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <?php
    $resultAll = mysqli_query($connection, "SELECT * FROM Article_Category");
    if(!$resultAll){die(mysqli_error($connection));}
    $categories= array();
    if (mysqli_num_rows($resultAll) > 0) {
        while($cat = mysqli_fetch_assoc($resultAll)){
            $categories[] = $cat;
        }
    }
    ?>

    <div class="header__bottom">
        <div class="container">
            <nav>
                <ul>
                    <?php
                    if (mysqli_num_rows($resultAll) > 0) {
                        foreach ($categories as $cat){
                            $var  = $cat['id'];
                            echo "<li><a href=\"articles.php?category=$var\">".$cat["Title"].'</a></li>';
                        }
                    }else{
                        echo "No categories are found!";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</header>