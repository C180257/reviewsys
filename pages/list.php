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

?>

<head>
	<meta charset="UTF-8">
	<title>レストラン一覧 - レストラン・レビュ・サイト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/list.css" />
</head>

<body id="list">
	<header>
		<h1><a href="list.html">レストラン・レビュ・サイト</a></h1>
	</header>
	<main>
		<div class="clearfix">


			<h2>レストラン一覧</h2>
			<form action="list.php" name="search_form" method="get">
				<!-- 地域選択リストボックス -->
				<select name="area">
					<option value="0"> -- 地域を選んで下さい -- </option>

<?php					

$sql = 'SELECT id, name FROM areas;';
 
mysqli_select_db( $conn, 'reviewdb' );
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
    die('无法读取数据: ' . mysqli_error($conn));
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
{
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}				
?>	
				</select>
				<input type="submit" value="検索" />
			</form>
		</div><!-- /.clearfix -->
		    <?php 
			echo "<div>HELLO</div>";
			if (isset($_GET['area'])) {
			   echo "User selected!!!!".$_GET['area'];
			} else {
			   echo "Please select";
			}
			
			
			
			?>
		<table class="list">
		</table>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>