<?php
/**
 * @file
 * This page opens any article depending on id
 */

$article_view = array();

include "authorisation.php";
// all users except banned can view articles
if ((isset($_SESSION['user'])) && ($_SESSION['user_role'] == 1)) {
  header("Location: index.php");
}
  $article = $db->query("SELECT * FROM link_list WHERE id=" . $_GET['id']);
  $view_article = $article->fetch(PDO::FETCH_ASSOC);
  // view article in English if ENG is chosen 
  if (($_SESSION['lang']) == 'en') {
    $article_view['header'] = "<div class='article_header'>{$view_article['list_link_header']}</div>";
    $article_view['body'] = "<div class='article_body'>{$view_article['list_link_text']}</div>";
  }
  // view article in Ukrainian if UA is chosen
  else {
    $article_view['header'] = "<div class='article_header'>{$view_article['list_link_header_ua']}</div>";
    $article_view['body'] = "<div class='article_body'>{$view_article['list_link_text_ua']}</div>";
  }
  // link to author's profile page and date
$article_view['author'] = "<div class='article_author'><a href='profile.php?user={$view_article[
  'list_link_author']}'>{$view_article['list_link_author']}</a></div>";
$article_view['created'] = "<div class='date'>{$view_article['list_link_date']}</div>";

  // if you are autorized and you are moder or admin...
  if ((isset($_SESSION['user_role'])) and ($_SESSION['user_role'] >= 3)) {
    // if you are moder and author or you are admin you can edit this article and delete it
    if ((($_SESSION['user']) == ($view_article['list_link_author'])) or (($_SESSION['user_role']) == 4))
    {

      if (isset($_POST['delete'])) {
        $db->exec('DELETE FROM link_list WHERE id=' . $view_article['id']);
        header("Location: index.php");
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Shedow site</title>
  <link href="shedow_style.css" rel="stylesheet" type="text/css">
  <meta charset="utf-8">
</head>
<body>
  <?php print $header; ?>
  <div class='article'>
    <?php foreach($article_view as $item): ?>
    <?php print $item; ?>
    <?php endforeach; ?>
    <a href="edit_existing_article.php?id=<?=$view_article['id']?>">Edit</a><br>
    <form method='post'>
    <input name='delete' type='submit' value='Delete article'><br>
    </form>
    <a href='index.php'>Back to Main Page</a>
  </div>
</body>
</html>
