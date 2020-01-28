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
    
  $select_restaurants_sql = 'SELECT name, detail,id FROM restaurants WHERE area='.$selected_area;
  
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

// DB拿出所有地点的ID和name
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
			if (isset($_GET['area'])) {
			   // 地域リストを関数で表示させます。
			   print_selected($_GET['area']);
			} else {
			   echo "リストから地域を選択してください。";
			}
			
			?>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course　C180257張文佳</div>
	</footer>
</body>

</html>