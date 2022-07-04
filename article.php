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

    <?php
        $article  = mysqli_query($connection, "SELECT * FROM Article WHERE id =".(int)$_GET['id']);
        if(!$article){die(mysqli_error($connection));}
        if(mysqli_num_rows($article) < 0){
            ?>
            <div id="content">
                <div class="container">
                    <div class="row">
                        <section class="content__left col-md-8">
                            <div class="block">
                                <a>404 Not Found</a>
                                <h3>Article is not found!</h3>
                                <div class="block__content">
                                    <div class="full-text">Requested article is not found!ß</div>
                                </div>
                            </div>

                        </section>
                        <section class="content__right col-md-4">
                            <?php include "sidebar.php";?>
                        </section>
                    </div>
                </div>
            </div>
            <?php
        }else{
            $art = mysqli_fetch_assoc($article);
            mysqli_query($connection, "UPDATE Article SET views = views+1 WHERE id =".(int)$art['id']);
            ?>
            <div id="content">
                <div class="container">
                    <div class="row">
                        <section class="content__left col-md-8">
                            <div class="block">
                                <a><?php echo $art['views'];?> Views</a>
                                <h3><?php echo $art['title'];?></h3>
                                <div class="block__content">
                                    <img src="images/<?php echo $art['image']?>" style="max-width: 100%">
                                    <div class="full-text"><?php echo $art['text'];?></div>
                                </div>
                            </div>

                            <div class="block">
                                <a href="#comment-add-form">Add</a>
                                <h3>Comments</h3>
                                <div class="block__content">
                                    <div class="articles articles__vertical">
                                        <?php
                                        $comments = mysqli_query($connection, "SELECT * FROM Comment WHERE article_id =".(int)$art['id']);
                                        if(!$comments){die(mysqli_error($connection));}
                                        ?>

                                        <?php
                                        if (mysqli_num_rows($comments) > 0) {
                                            while ($comment = mysqli_fetch_assoc($comments))
                                            {
                                                ?>
                                                <article class="article">
                                                    <div class="article__image"
                                                         style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email'])?>);">
                                                    </div>
                                                    <div class="article__info">
                                                        <a href="article.php?id=<?php echo $comment['article_id'];?>"><?php echo $comment['author'];?></a>
                                                        <div class="article__info__meta"></div>
                                                        <div class="article__info__preview"><?php echo $comment['text'];?></div>
                                                    </div>
                                                </article>
                                                <?php
                                            }
                                        }else{
                                            echo "No Comments!";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="comment-add-form" class="block">
                                <h3>Add Comment</h3>
                                <div class="block__content">
                                    <form class="form" method="POST" action="article.php?id=<?php echo $art['id'];?>#comment-add-form">
                                        <?php
                                            if(isset($_POST['do_post'])){
                                                $errors = array();
                                                if($_POST['name'] == '') $errors[] = 'Enter a name!';
                                                if($_POST['nickname'] == '') $errors[] = 'Enter a nickname!';
                                                if($_POST['email'] == '') $errors[] = 'Enter an Email address!';
                                                if($_POST['text'] == '') $errors[] = 'Enter a comment content!';

                                                if(empty($errors)){
                                                    mysqli_query($connection,
                                                        "INSERT INTO Comment (author, nickname, email, text, article_id )
                                                                VALUES ('".$_POST['name']."', '" .$_POST['nickname']."', '" .$_POST['email']."', '" .$_POST['text']."', '" .$art['id']."')");
                                                    echo '<span style="color: limegreen; 
                                                        font-weight: bold;
                                                        margin-bottom: 10px;
                                                        display: block">Your comment is added!</span> ';
                                                }else{
                                                    echo $errors['0'];
                                                }
                                            }
                                        ?>
                                        <div class="form__group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="form__control" required=""
                                                           name="name" placeholder="Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form__control" required=""
                                                           name="nickname" placeholder="Nickname">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form__control" required=""
                                                           name="email" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__group">
                                            <textarea name="text" required="" class="form__control" placeholder="Type here..."></textarea>
                                        </div>
                                        <div class="form__group">
                                            <input type="submit" class="form__control" name="do_post" value="Add Comment">
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </section>
                        <section class="content__right col-md-4">
                            <?php include "sidebar.php";?>
                        </section>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
    <?php include "footer.php";?>
</div>
</body>
</html>