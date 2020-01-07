<!DOCTYPE html>
<html lang="ja">
<?php
$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '';                // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
// 设置编码，防止中文乱码
mysqli_query($conn , "set names utf8");


function print_selected($selected_area) {
  global $conn;
    
  $select_restaurants_sql = 'SELECT name, detail FROM restaurants WHERE area='.$selected_area;
  
  mysqli_select_db( $conn, 'reviewdb' );
  $retval = mysqli_query( $conn, $select_restaurants_sql );
  if(! $retval )
  {
    die('无法读取数据: ' . mysqli_error($conn));
  }
  
  print '<table class="list">';
  
  while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) 
  {
    echo '<tr>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.$row['detail'].'</td>';
	echo '<td><a href="detail.php?id='.$row['id'].'">詳細</a></td>';
	echo '</tr>';
  }				

  print '</table>';

}




?>
<head>
	<meta charset="UTF-8">
	<title>レストラン詳細情報 - レストラン・レビュ・サイト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/detail.css" />
</head>

<body id="detail">
	<header>
		<h1><a href="list.html">レストラン・レビュ・サイト</a></h1>
	</header>
	<main>
		<article id="description">
			<h2>レストラン詳細</h2>
			<table class="list">
				<tr>
					<td class="photo"><img width="110" alt="「レストラン さくら」の写真" src="../pages/img/restaurant_7.jpg" /></td>
					<td class="info">
						<dl>
						    <?php
							 mingzi($_GET['id']);
							 ?>
						</dl>
					</td>
				</tr>
			</table>
		</article>
		<article id="reviews">
			<h2>レビュ一覧</h2>
			<dl>
				<dt>★★★★☆</dt>
				<dd>常連の者で、いつも夫婦で伺っています。席数が少ないので予約した方が安心ですが、その分落ち着いて食事できますよ。コースのメインは基本的にシェフにお任せ。来るたびに、新しい味との出会いを楽しめるお店です。（totsuka）</dd>
			</dl>
			<dl>
				<dt>★★★★★</dt>
				<dd>説明の通り、喧騒を外れた場所にひっそりとあるレストランでした。伊豆市には初めて来ましたが、本当に桜がきれいですね。何よりも空気がきれいで、いいリフレッシュになりました。（oie）</dd>
			</dl>
		</article>
		<article id="review">
			<h2>レビュを書き込む</h2>
			<form name="review_form" action="detail.html" method="post">
				<table class="review">
					<tr>
						<th>お名前</th>
						<td><input type="text" name="reviewer" /></td>
					</tr>
					<tr>
						<th>ポイント</th>
						<td>
							<input type="radio" name="point" value="1" id="1" />
							<label for="1">1</label>
							<input type="radio" name="point" value="2" id="2" />
							<label for="2">2</label>
							<input type="radio" name="point" value="3" id="3" checked />
							<label for="3">3</label>
							<input type="radio" name="point" value="4" id="4" />
							<label for="4">4</label>
							<input type="radio" name="point" value="5" id="5" />
							<label for="5">5</label>
						</td>
					</tr>
					<tr>
						<th>レビュ</th>
						<td><textarea name="comment"></textarea></td>
					</tr>
				</table>
				<input type="submit" value="投稿" />
				<input type="reset" value="クリア" />
			</form>
		</article>
		
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>