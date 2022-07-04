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
              <h3>All Articles</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">
                    <?php
                        $per_page = 4;
                        $page = 1;

                        if(isset($_GET['page'])){
                            $page = (int) $_GET['page'];
                        }

                        $total_count_queue = mysqli_query($connection, "SELECT COUNT(id) AS total_count FROM Article");
                        $total_count = mysqli_fetch_assoc($total_count_queue);
                        $total_count = $total_count['total_count'];

                        $total_pages = ceil($total_count/$per_page);
                        if($page <= 1 || $page > $total_pages){
                            $page = 1;
                        }

                        $offset = 0;

                        if($page != 0){
                            $offset = ($per_page * $page) - $per_page;
                        }

                        $articles = mysqli_query($connection, "SELECT * FROM Article ORDER BY id DESC LIMIT $offset, $per_page");
                        if(!$articles){die(mysqli_error($connection));}
                    ?>

                    <?php
                        $articles_exist = true;
                        if (mysqli_num_rows($articles) <= 0) {
                            echo "No articles found!";
                            $articles_exist = false;
                        }
                        while ($art = mysqli_fetch_assoc($articles)){?>
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
                        ?>
                    </div>
                    <?php
                        if($articles_exist == true){
                            echo '<div class="paginator">';
                            if($page > 1){
                                echo '<a href="articles.php?page='.($page - 1).'">&laquo; Prev. Page</a>  ';
                            }
                            if( $page < $total_pages){
                                echo '<a href="articles.php?page='.($page + 1).'">Next Page&raquo;</a>';
                            }
                            echo '</div>';
                        }
                    ?>
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