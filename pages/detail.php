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
mysqli_select_db( $conn, 'reviewdb' );


if (isset($_POST['id'])) { // 投稿ボタンから
  $selected_fandian = $_POST['id'];
  $name = $_POST['reviewer'];
  $comment = $_POST['comment'];
  $rating = $_POST['point'];
  
  if (strlen($comment)==0) die('コメントは空にできません。');
  
  $sql_save_comment = "INSERT INTO reviews (restaurant, reviewer, comment, rating) 
  VALUES ( '$selected_fandian', '$name', '$comment', '$rating' )";
  
  if(mysqli_query($conn, $sql_save_comment)) {
      echo 'コメントを保存しました。';
  } else {
      echo "Error: " . mysqli_error($conn);
  }
  
} else if (isset($_GET['id'])) { // list から
  $selected_fandian = $_GET['id'];
} else {
  die('list.php からアクセスしてください。 C180257張文佳・2020');
}

$select_restaurants_sql = 'SELECT name, detail,image FROM restaurants WHERE id='.$selected_fandian;
  
$retval = mysqli_query( $conn, $select_restaurants_sql );
if(! $retval )
{
  die('无法读取数据: ' . mysqli_error($conn));
}
  
  
$row = mysqli_fetch_array($retval, MYSQLI_ASSOC); 

$name = $row['name'];
$detail = $row['detail'];
$image= $row['image'];



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
					<td class="photo"><img width="110" alt="写真" src="../pages/img/<?php echo $image; ?>" /></td>
					<td class="info">
						<dl>
						    <dt><?php echo $name; ?></dt>
							<dd><?php echo $detail; ?></dd>
						</dl>
					</td>
				</tr>
			</table>
		</article>
		<article id="reviews">
			<h2>レビュ一覧</h2>

<?php

  $select_pingjia_sql = 'SELECT comment, rating, reviewer FROM reviews WHERE restaurant='.$selected_fandian.' ORDER BY created DESC';
  
  mysqli_select_db( $conn, 'reviewdb' );
  $retval = mysqli_query( $conn, $select_pingjia_sql );
  if(! $retval )
  {
    die('无法读取数据: ' . mysqli_error($conn));
  }
  
  while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) 
  {
    echo '<dl>';
    
    $black = $row['rating'];
    $white = 5-$black;

	echo '<dt>';

    for ($i=0; $i< $black; $i++) {
	    echo '★';
    }
    for ($i=0; $i< $white; $i++) {
	    echo '☆';
    }
	echo '</dt>';

	echo '<dt>'.$row['reviewer'].'</dt>';
	echo '<dd>'.$row['comment'].'</dd>';
	echo '</dl>';
  }		

?>

		</article>
		<article id="review">
			<h2>レビュを書き込む</h2>
			<form name="review_form" action="detail.php" method="post">
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
				<input type="hidden" name="id" value="<?php echo $selected_fandian; ?>" />
				<input type="submit" value="投稿" />
				<input type="reset" value="クリア" />
			</form>
		</article>
		
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course　C180257張文佳</div>
	</footer>
</body>

</html>
