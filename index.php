<?php
    require "includes/config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title'];?></title>
  <link rel="stylesheet" type="text/css" href="media/assets/bootstrap-grid-only/css/grid12.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="media/css/style.css">
</head>
<body>
  <div id="wrapper">
      <?php include "header.php";?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a href="articles.php">View All</a>
              <h3>Hot Articles</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">
                    <?php
                        $articles = mysqli_query($connection, "SELECT * FROM Article ORDER BY id LIMIT 4");
                        if(!$articles){die(mysqli_error($connection));}
                    ?>

                    <?php
                        if (mysqli_num_rows($articles) > 0) {
                            while ($art = mysqli_fetch_assoc($articles))
                            {
                    ?>
                        <article class="article">
                            <div class="article__image" style="background-image: url(images/<?php echo $art['image'];?>);"></div>
                            <div class="article__info">
                                <a href="article.php?id=<?php echo $art['id'];?>"><?php echo $art['title'];?></a>
                                <div class="article__info__meta">
                                    <?php
                                    $art_cat = false;
                                    foreach($categories as $cat) {
                                        if($cat['id'] == $art['category_id']){
                                            $art_cat=$cat;
                                            break;
                                        }
                                    }
                                    ?>
                                    <small>Category: <a href="/articles.php?id=<?php echo $art_cat['id'];?>"><?php echo $art_cat['Title'];?></a></small>
                                </div>
                                <div class="article__info__preview"><?php echo mb_substr($art['text'], 0, 79, 'utf-8');?></div>
                            </div>
                        </article>
                    <?php
                            }
                        }else{
                            echo "No categories are found!";
                        }
                    ?>
                </div>
              </div>
            </div>

            <div class="block">
              <a href="#">View All</a>
              <h3>Security [New]</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                    <?php
                    $security = mysqli_query($connection, "SELECT * FROM Article WHERE category_id = 6");
                    if(!$security){die(mysqli_error($connection));}
                    ?>

                    <?php
                    if (mysqli_num_rows($security) > 0) {
                        while ($art = mysqli_fetch_assoc($security))
                        {
                            ?>
                            <article class="article">
                                <div class="article__image" style="background-image: url(images/<?php echo $art['image'];?>);"></div>
                                <div class="article__info">
                                    <a href="article.php?id=<?php echo $art['id'];?>"><?php echo $art['title'];?></a>
                                    <div class="article__info__meta">
                                        <?php
                                        $art_cat = false;
                                        foreach($categories as $cat) {
                                            if($cat['id'] == $art['category_id']){
                                                $art_cat=$cat;
                                                break;
                                            }
                                        }
                                        ?>
                                        <small>Category: <a href="/articles.php?category=<?php echo $art_cat['id'];?>"><?php echo $art_cat['Title'];?></a></small>
                                    </div>
                                    <div class="article__info__preview"><?php echo mb_substr($art['text'], 0, 79, 'utf-8');?></div>
                                </div>
                            </article>
                            <?php
                        }
                    }else{
                        echo "No categories are found!";
                    }
                    ?>

                </div>
              </div>
            </div>

            <div class="block">
              <a href="#">View all</a>
              <h3>Programming [New]</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                    <?php
                    $articles = mysqli_query($connection, "SELECT * FROM Article WHERE category_id = 4");
                    if(!$articles){die(mysqli_error($connection));}
                    ?>

                    <?php
                    if (mysqli_num_rows($articles) > 0) {
                        while ($art = mysqli_fetch_assoc($articles))
                        {
                            ?>
                            <article class="article">
                                <div class="article__image" style="background-image: url(images/<?php echo $art['image'];?>);"></div>
                                <div class="article__info">
                                    <a href="article.php?id=<?php echo $art['id'];?>"><?php echo $art['title'];?></a>
                                    <div class="article__info__meta">
                                        <?php
                                        $art_cat = false;
                                        foreach($categories as $cat) {
                                            if($cat['id'] == $art['category_id']){
                                                $art_cat=$cat;
                                                break;
                                            }
                                        }
                                        ?>
                                        <small>Category: <a href="/articles.php?category=<?php echo $art_cat['id'];?>"><?php echo $art_cat['Title'];?></a></small>
                                    </div>
                                    <div class="article__info__preview"><?php echo mb_substr($art['text'], 0, 79, 'utf-8');?></div>
                                </div>
                            </article>
                            <?php
                        }
                    }else{
                        echo "No categories are found!";
                    }
                    ?>

                </div>
              </div>
            </div>
          </section>
            <section class="content__right col-md-4">
                <?php include "sidebar.php";?>
                <div class="block">
                    <h3>Recent Comments</h3>
                    <div class="block__content">
                        <div class="articles articles__vertical">
                            <?php
                            $comments = mysqli_query($connection, "SELECT * FROM Comment LIMIT 4");
                            if(!$comments){die(mysqli_error($connection));}
                            ?>

                            <?php
                            if (mysqli_num_rows($comments) > 0) {
                                while ($art = mysqli_fetch_assoc($comments))
                                {
                                    ?>
                                    <article class="article">
                                        <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($art['email'])?>);"></div>
                                        <div class="article__info">
                                            <a href="article.php?id=<?php echo $art['article_id'];?>"><?php echo $art['author'];?></a>
                                            <div class="article__info__meta"></div>
                                            <div class="article__info__preview"><?php echo mb_substr($art['text'], 0, 79, 'utf-8');?></div>
                                        </div>
                                    </article>
                                    <?php
                                }
                            }else{
                                echo "No categories are found!";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>
  <?php include "footer.php";?>
  </div>
</body>
</html>