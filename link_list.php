<?php
include "db.php";
if(!($db)) // if no connect, error and exit()
{
 echo "Unable to connect to data base server";
 exit();
}
if (!isset($limit))
{
$limit = 10;  // default results per page
}

if(!isset($page))
{
$page=0;
}
$num_results = $db->query("SELECT * FROM link_list");
$rows=$num_results->rowCount();
if ($rows == 0)
{
echo "No results found";
exit();
}

$pages = intval($rows/$limit);
if ($rows % $limit){
 $pages++;}
$current=($page/$limit) + 1; // current page number
if (($pages<1) or ($pages==0))
 $total = 1;
else
 $total = $pages; // total number of pages
$first = $page + 1;
if (!((($page + $limit) / $limit) >= $pages) && $pages != 1)
 $last = $page + $limit;
else
 $last = $rows;

// view a list of links
if (!isset($_GET['page']))
 $_GET['page']=0;
if (!isset($_GET['limit']))
 $_GET['limit']=10;
$article = $db->query("SELECT * FROM link_list ORDER BY id DESC LIMIT ".$_GET['page'].",".$_GET['limit']);
while ($post = $article->fetch(PDO::FETCH_ASSOC))
{
if ((strlen($post['list_link_text'])) > 150)
 {
 $shorted_text = substr($post['list_link_text'],0,strpos($post['list_link_text'],' ',150));
 echo "<a href=article.php?id=".$post['id'].">".$post['list_link_header']."</a><br>".$shorted_text."...<br>".$post['list_link_date']."<br>"."<a href=article.php?id=".$post['id'].">read more</a><br><br>";
 }
else
 {
 echo "<a href=article.php?id=".$post['id'].">".$post['list_link_header']."</a><br>".$post ['list_link_text']."<br>".$post['list_link_date']."<br><br>";
 }
}
?>
<br>
<span>Results <b><?=$first?></b> - <b><?=$last?></b> of <b><?=$rows?></b>;</span>
<span>Page <b><?=$current?></b> of <b><?=$total?></b></span>
<?php

// if current page is first page - don't show the link
if ($page != 0)
{
$back_page = $page - $limit;
echo "<a href=".$_SERVER['PHP_SELF']."?page=$back_page&limit=$limit> back </a>";
}
// links to pages
for ($i=1; $i <= $pages; $i++)
{
$ppage = $limit*($i - 1);
if ($ppage == $page)
 echo "<b> $i </b>";
else
 echo "<a href=".$_SERVER['PHP_SELF']."?page=$ppage&limit=$limit> $i </a>";
}
if (!((($page+$limit) / $limit) >= $pages) && ($pages != 1))
{
$next_page = $page+$limit;
echo "<a href=".$_SERVER['PHP_SELF']."?page=".$next_page."&limit=$limit>next</a>";
}
?>
<hr>
