<?php 
/* functions without return */
function category()
{
	$id = $_GET["id"];
	if(!$id)
	{
		$sql = "select * from categories";
		$db = new db2();
		$result = $db->result($sql);
		$temp = '<div class="article">';
		foreach($result as $a)
		{
			$link = '?id='.$a["articles_id"].'" target="_self" title="'.$a["articles_name"].'" alt="'.$a["articles_name"];
			$temp .= '
			<div class="article_row">
				<div class="article_image">
					<a href="'.$link.'">
					<img src="'.$a["articles_image_upload"].'" width="19" height="19" />
					</a>			
				</div><!--article_image-->
				<div class="article_title">
				<h2>
					<a href="'.$link.'">
						'.$a["articles_name"].'
					</a>
				</h2>
				</div>
				<div class="article_description">
					'.substr($a["article"], 0, strpos($a["article"], ' ', 300)).'
					<a href="'.$link.'">
						<span class="article_more">
							More Info
						</span><!--article_more-->
					</a>
				</div><!--artilce_description-->
			<div class="clear"></div>
			</div><!--article_row-->';
		}
		$temp .= '</div><!--article-->';
		$data_n["html_head"] = "";
		$data_n["html_title"] = "Articles";
		$data_n["html_heading"] = "Articles";
		$data_n["html_text"] = $temp;
		return $data_n;
	}
	//Step 2

	$sql = "select * from articles where articles_id = ".$id;
	$db = new db2();
	$result = $db->result($sql);
	$temp = '<div class="article">';
	$a = mysql_fetch_array($result);
	$temp = $a["article"];
	$temp = str_replace("\n", "<br />", $temp);
	$data_n["html_head"] = "";
	$data_n["html_title"] = "Articles - ".$a["articles_name"];
	$data_n["html_heading"] = $a["articles_name"];
	$data_n["html_text"] = $temp;
	return $data_n;
}
?>