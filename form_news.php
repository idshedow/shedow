<head>
<meta charset="utf-8">
</head>
<?php
/**
 * @file
 * Page for adding new matherial to site.
 */
include "authorisation.php";
// cheking authorization
if (isset($_SESSION['user'])) {
  // cheking user's permissions
  if ($_SESSION['user_role'] >= 3) {
    // set values to variables
    $time_date = date("d-m-Y H:i");
    $_SESSION['date'] = $time_date;
    if (isset($_POST['header'])) {
      $header = trim(strip_tags($_POST['header']));
      $header_ua = trim(strip_tags($_POST['header_ua']));
      $_SESSION['article_header'] = $header;
      $_SESSION['article_header_ua'] = $header_ua;
    }
    if (isset($_POST['article'])) {
      $article = trim(strip_tags($_POST['article']));
      $article_ua = trim(strip_tags($_POST['article_ua']));
      $_SESSION['article_text'] = $article;
      $_SESSION['article_text_ua'] = $article_ua;
    }
    // if somehow user wrote text without authorising
    if (isset($_SESSION['user'])) {
      $author = $_SESSION['user'];
    }
    else {
      $author = 'unknown author';
    }

    // insert information to data base
    if(isset($_POST['add_article'])) {
      $add_en = $db->prepare("INSERT INTO link_list (list_link_header, list_link_text,
        list_link_header_ua, list_link_text_ua, list_link_date, list_link_author) VALUES (?, ?, ?, ?, ?, ?)");
      $add_en->execute(array($header, $article, $header_ua, $article_ua, $time_date, $author));
      header("Location:view.php");
    }
  }
  else {
    header("Location: index.php");
  }
}
else {
    header("Location: index.php");
  }
?>

<form action="<?=$_SERVER['REQUEST_URI']?>" method='post'>
<table>
<tr><td>
<p>Text in English: <br>
<input type='text' name='header' size='60' placeholder='header'></td><td>
<p>Text in Ukrainian: <br>
<input type='text' name='header_ua' size='60' placeholder='header'></td>
</tr><tr><td>
<textarea name='article' cols='80' rows='20'>
</textarea>
</td><td>
<textarea name='article_ua' cols='80' rows='20'>
</textarea>
</td></tr>
</table>
<input name='add_article' type='submit' value='Add new matherial'>
</form>
