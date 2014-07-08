<?php
include "db.php";
if(!($db)) // if no connect, error and exit()
{
 echo "Unable to connect to data base server";
 exit();
}
															// default results per page		
if (!isset($limit))
{
$limit = 10;  
}

if(!isset($page))
{
$page=0;
}
	 																	// counter of articles
$num_results = $db->query("SELECT * FROM link_list"); 
$rows=$num_results->rowCount();
if ($rows == 0)
{
echo "No results found";
exit();
}
												// default values if not in GET
if (!isset($_GET['page']))
	$_GET['page']=0;
else
	$page = $_GET['page'];			// $page is number of first article in current page
// initialising of variables
$pages = intval($rows/$limit);	// $pages is a number of pages in pager
if ($rows % $limit){
	$pages++;}
$current=($page/$limit) + 1; 		// $current is a current page
if (($pages<1) or ($pages==0))
	$total = 1;							// $total is total number of pages in pager
else
	$total = $pages;
$first = $page + 1;					// $first is a number of fisrt article in current page

if (!((($page + $limit) / $limit) >= $pages) && $pages != 1)
	$last = $page + $limit;			// $last is a number of last article in current page
else
	$last = $rows;						// $rows is a total number of articles in db



													// list of articles
$article = $db->query("SELECT * FROM link_list ORDER BY id DESC LIMIT ".$_GET['page'].",".$limit);
while ($post = $article->fetch(PDO::FETCH_ASSOC))
{
	if (($_SESSION['lang']) == 'en')
	{
		$lang_header = $post['list_link_header'];
		$lang_text = $post['list_link_text'];
	}
	else
	{
		$lang_header = $post['list_link_header_ua'];
		$lang_text = $post['list_link_text_ua'];
	}
	if ((strlen($post['list_link_text'])) > 150) // to short the text if it is longer 150 symbols
	{
		$shorted_text = substr($lang_text,0,strpos($lang_text,' ',150));
		echo "<a href=article.php?id=".$post['id']."><b>".$lang_header."</b></a><br>".$shorted_text."...<br><a href=profile.php?user=".$post['list_link_author'].">".$post['list_link_author']."</a><i>"." ".$post['list_link_date']."</i><br>"."<a href=article.php?id=".$post['id'].">read more</a><br><br>";
	}
	else  // if text is shorter 150 symbols - show it all
	{
		echo "<a href=article.php?id=".$post['id']."><b>".$lang_header."</b></a><br>".$lang_text."<br><a href=profile.php?user=".$post['list_link_author'].">".$post['list_link_author']."</a><i>"." ".$post['list_link_date']."</i><br><br>";
	}
	echo "<img src='images/city.jpeg' width='480' height='20'><br>";
}

															// results 1 - 10 of 21; page  1 of 3;
echo "<br>Results <b>".$first."</b> - <b>".$last."</b> of <b>".$rows."</b>; ";
echo " Page <b>".$current."</b> of <b>".$total."</b>;";
																		// 1	2	3	next
// if current page is first page - don't show the link "back"
if ($page != 0)
{
	$back_page = $page - $limit;
	echo "<a href=".$_SERVER['PHP_SELF']."?page=".$back_page."&limit=".$limit."> back </a>";
}
for ($i=1; $i <= $pages; $i++)  // don't show the link to number of current page
{
	$ppage = $limit*($i - 1);

	if ($ppage == $page)
		echo "<b> $i </b>";
	else
		echo "<a href=".$_SERVER['PHP_SELF']."?page=".$ppage."> $i </a>";

}
// if current page is last don't show the link "next"
if (!((($page+$limit) / $limit) >= $pages) && ($pages != 1))
{
	$next_page = $page+$limit;
	echo "<a href=".$_SERVER['PHP_SELF']."?page=".$next_page.">next</a>";
}
?>
<hr>
