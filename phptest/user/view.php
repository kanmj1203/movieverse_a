<?php

require("../db_connect.php");
    session_start();


	$member_num = $_REQUEST["member_num"];
	

	$query = $db->query("select * from user where member_num= $member_num");
    if ($row = $query->fetch()) {
		$email  = str_replace(" ", "&nbsp;", $row["email"]);
		$nickname = str_replace(" ", "&nbsp;", $row["nickname"]);
		$identification = str_replace(" ", "&nbsp;", $row["identification"]);
		$passwd = str_replace(" ", "&nbsp;", $row["passwd"]);
		$join_date = str_replace(" ", "&nbsp;", $row["join_date"]);
		// $bookmark_num  = str_replace(" ", "&nbsp;", $row["bookmark_num"]);
		// $review_num = str_replace(" ", "&nbsp;", $row["review_num"]);
		$img_link = $row["img_link"];
		
		$review_count = $db->query("select count(*) from review where member_num='$row[member_num]'")->fetchColumn(); 
		$bookmark_count = $db->query("select count(*) from bookmark where member_num='$row[member_num]'")->fetchColumn();  

	}





// 페이지네이션

$page_count = 5;
$page_lines = 5;


// 영화
$movie_page = isset($_REQUEST["movie_page"]) ? $_REQUEST["movie_page"] : 1;
// 현재 페이지 0보다 작으면 1로 설정
$movie_page = 0 < $movie_page ? $movie_page : 1;


$movie_numRecords = $db->query("select count(*) from review where choice_content='movie' and member_num = $member_num")->fetchColumn();
// $numRecords = (int)$numRecords;
$movie_page_total = (int)$movie_numRecords;
$movie_page_total_pages = ceil($movie_page_total  / $page_count);

// 현재 페이지 page_count보다 크면 page_total_pages로 설정
$movie_page = $movie_page_total_pages < $movie_page ? $movie_page_total_pages : $movie_page;


$movie_page_list = ceil($movie_page / $page_lines);

$movie_page_last = $movie_page_list <= $movie_page_total_pages ? $movie_page_list * $page_count : $movie_page_total_pages;
$movie_page_last = $page_count > $movie_page_total_pages ? $movie_page_total_pages : $movie_page_last;

$movie_page_start = $movie_page_last - ($page_count - 1) <= 0 ? 1 : $movie_page_last - ($page_count - 1);
// echo gettype($page_start);
$movie_page_prev = $movie_page_start - 1;
$movie_page_next = $movie_page_last + 1;

$movie_stat = $movie_page >= 1 ? ($movie_page -1) * $page_count : $movie_page * $page_count;



// 드라마
$tv_page = isset($_REQUEST["tv_page"]) ? $_REQUEST["tv_page"] : 1;
// 현재 페이지 0보다 작으면 1로 설정
$tv_page = 0 < $tv_page ? $tv_page : 1;


$tv_numRecords = $db->query("select count(*) from review where choice_content='tv' and member_num = $member_num")->fetchColumn();
// $numRecords = (int)$numRecords;
$tv_page_total = (int)$tv_numRecords;
$tv_page_total_pages = ceil($tv_page_total  / $page_count);

// 현재 페이지 page_count보다 크면 page_total_pages로 설정
$tv_page = $tv_page_total_pages < $tv_page ? $tv_page_total_pages : $tv_page;


$tv_page_list = ceil($tv_page / $page_lines);

$tv_page_last = $tv_page_list <= $tv_page_total_pages ? $tv_page_list * $page_count : $tv_page_total_pages;
$tv_page_last = $page_count > $tv_page_total_pages ? $tv_page_total_pages : $tv_page_last;

$tv_page_start = $tv_page_last - ($page_count - 1) <= 0 ? 1 : $tv_page_last - ($page_count - 1);
// echo gettype($page_start);
$tv_page_prev = $tv_page_start - 1;
$tv_page_next = $tv_page_last + 1;

$tv_stat = $tv_page >= 1 ? ($tv_page -1) * $page_count : $tv_page * $page_count;


	


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css"href="../admin_page.css">
    <style>
      
		/* .review_num      { width: 100px; }
        .review_date     	{ width:150px; }
        
		.title	{ width:400px; }
		.review			{ width:700px;  }
		.star_rating	{ width:50px; }	
		.good			{ width:50px; }
		.del		{ width:50px; }
		
		
		.bookmark_num { width: 100px; }
		.join_date     	{ width:150px; }
		 */
		
		
		
    </style>
</head>

<body>
<div class="all">
 <div class="head">
 	<a href="../../index.php"><img class="logo"src="../../img/logo/logo_txt.png"></a>	<!-- 링크걸기 -->

</div>

<div class="sidenav">
	<a href="../list.php">관리자 페이지</p>
	<a href="../user/list.php">회원 관리</a>
	<br><br>
	<a href="../review/list.php">리뷰 관리</a>

	</div>



<div class="main_view">
	<h1 style="text-align: center;"> 관리자 페이지 </h1>
	<h2 style="text-align: center;"> User 정보  </h2>
	
<table>

	<tr>
        <th>이메일</th>
        <td><?=$row["email"]?><br></td>
    </tr>
	<tr>
        <th>아이디</th>
        <td><?=$identification?><br></td>
	</tr>
	<tr>
        <th>비밀번호</th>
        <td><?=$passwd?><br></td>
	</tr>
    <tr>
        <th>닉네임</th>
        <td><?=$row["nickname"]?><br></td>
    </tr>
    <tr>
        <th>가입날짜</th>
        <td><?=$row["join_date"]?><br></td>
    </tr>
    <tr>
        <th>북마크</th>
       <td><?=$bookmark_count?><br></td>
    </tr>
    <tr>
        <th>리뷰</th>
        <td><?=$review_count?><br></td>
		</td>
    </tr>
    
	

    <tr>
    	<th>프로필</th>
		<td>
		<?php if($row["img_link"] == "user_img.png"){ 
		?>
		이미지 없음
		
		<?php
			} else {
		?>
			<img src="../../user_img/<?=$row["img_link"]?>"width="200" height="200"></td>
		<?php
			}
		?>
    </tr>
	
	 <tr>
    	<th>회원 관리</th>
		<td>
		<input class="rect3" type="button" value="수정" onclick="location.href='write.php?member_num=<?=$member_num?>'">
	
		<input class="rect3" type="button" value="삭제" onclick="location.href='delete.php?member_num=<?=$member_num?>'">
		
	</td>
    </tr>
	
</table>

<h2> 회원 영화 리뷰목록 </h2>


<table>
<tr style="font-size:20px; color: #ffffff;">
        <th class="review_num"    >리뷰번호    </th>
        <th class="review_date"  >리뷰날짜    </th>
		
		<th class="title	"  >작품  </th>
		
		<th class="review"  >리뷰   </th>
		
		<th class="star_rating"  >평점    </th>
		
		<th class="good"  >좋아요   </th>
		
		<th class="del"  >삭제   </th>
	</tr>
	
<?php

	$query = $db->query("select * from review where member_num = $member_num and choice_content = 'movie' limit $movie_stat, $page_count");
	

    while ($row = $query->fetch()) {
		
		$like_count = $db->query("select count(*) from review_like where like_review_num = '$row[like_num]'")->fetchColumn();
?>

	<tr>
		<td><?=$row["review_num"]?></td>
		<td><?=$row["review_date"]?></td>
		<td><?=$row["title"]?></td>
		<td><?=$row["review_content"]?></td>
		<td><?=$row["star_rating"]?></td>
		<td><?=$like_count?></td>
		<td>
		<input class="rect3" type="button" value="삭제" onclick="location.href='rvdel.php?review_num=<?=$row['review_num']?>&member_num=<?=$member_num?>'">
		</td>
	</tr>
			
<?php
	}
?>
    
</table>

<div class="pagination">
                <ul>
                    <li>
                    <button 
                    class="pagination_button"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$movie_page_prev?>&tv_page=<?=$tv_page?>'">
                    <
                    </button></li>
<?php
                for($i = $movie_page_start; $i <= $movie_page_last; $i++){
?>
                    <li><button
                    class="pagination_button <?=$i == $movie_page ? 'now_page' : ''?>"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$i?>&tv_page=<?=$tv_page?>'"
                    >
                    <?=$i?></button></li>
<?php
                }
?>
                    <li><button 
                    class="pagination_button"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$movie_page_next?>&tv_page=<?=$tv_page?>'" >
                    >
                    </button></li>
            </ul>
            </div>





<h2> 회원 드라마 리뷰목록 </h2>


<table class="review_table">
<tr style="font-size:20px; color: #ffffff;">
        <th class="review_num"    >리뷰번호    </th>
        <th class="review_date"  >리뷰날짜    </th>
		
		<th class="title	"  >작품  </th>
		
		<th class="review"  >리뷰   </th>
		
		<th class="star_rating"  >평점    </th>
		
		<th class="good"  >좋아요   </th>
		
		<th class="del"  >삭제   </th>
	</tr>
<?php

	$query = $db->query("select * from review where member_num = $member_num and choice_content = 'tv' limit $tv_stat, $page_count");
	

    while ($row = $query->fetch()) {
		
		$like_count = $db->query("select count(*) from review_like where like_review_num = '$row[like_num]'")->fetchColumn();
		
?>


	<tr>
		<td><?=$row["review_num"]?></td>
		<td><?=$row["review_date"]?></td>
		<td><?=$row["title"]?></td>
		<td><?=$row["review_content"]?></td>
		<td><?=$row["star_rating"]?></td>
		<td><?=$like_count?></td>
		<td>
		<input class="rect3" type="button" value="삭제" onclick="location.href='rvdel.php?review_num=<?=$row['review_num']?>&member_num=<?=$member_num?>'">
		</td>
	</tr>
			
<?php
	}
?>
    
</table>

<div class="pagination">
                <ul>
                    <li>
                    <button 
                    class="pagination_button"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$movie_page?>&tv_page=<?=$tv_page_prev?>'">
                    <
                    </button></li>
<?php
                for($i = $tv_page_start; $i <= $tv_page_last; $i++){
?>
                    <li><button
                    class="pagination_button <?=$i == $tv_page ? 'now_page' : ''?>"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$movie_page?>&tv_page=<?=$i?>'"
                    >
                    <?=$i?></button></li>
<?php
                }
?>
                    <li><button 
                    class="pagination_button"
                    type="button"
                    onclick="location.href='?member_num=<?=$member_num?>&movie_page=<?=$movie_page?>&tv_page=<?=$tv_page_next?>'" >
                    >
                    </button></li>
            </ul>
            </div>
</div>




</div>
</div>
</body>
</html>

