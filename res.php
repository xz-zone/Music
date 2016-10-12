<?php
	$str = htmlspecialchars($_POST['ip']);

	function myTrim($str)//清楚所有空号 换行符
	{
		 $search = array(" ","　","\n","\r","\t");
		 $replace = array("","","","","");
		 return str_replace($search, $replace, $str);
	}
	$ip =  myTrim($str);
	if ($ip) {
		$url = "http://s.music.163.com/search/get/?type=1&s=". $ip ."&limit=5000";
		$li = file_get_contents($url);
		$lis = json_decode($li,true);
		
		if (!empty($lis['result'])) {
			$arr = array();
			foreach ($lis as $key => $value) {
				$arr[] = $value['songs'];
			}

			if (!$arr[0]) {
				echo '<h1>暂无数据</h1>';
				sleep(3);
				header("Location:./index.php");
				die;
			} else {
				$ba = array();
				foreach ($arr[0] as $k => $v) {
					$ba[$k]['name'] = $v['name'];
					$ba[$k]['mice'] = $v['audio'];
					if (!empty($v['artists'][0])) {
						$ba[$k]['zqr'] = $v['artists'][0]['name'];
					} else {
						$ba[$k]['zqr'] = '暂无歌手';
					}
				}
			}
		} else {
			echo '<h1>暂无数据</h1>';
			//sleep(3);
			header("Location:./index.php");
			die;
		}
	} else {
		header("Location:./index.php");
		die;
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>搜索</title>
	<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.2/css/amazeui.css">
	<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.2/css/amazeui.min.csss">
</head>
<body>
	<table class="am-table am-table-bordered am-table-striped am-table-compact">
		<thead>
		  	<tr>
			    <th>歌名</th>
			    <th>唱曲人</th>
				<th>音乐外链</th>
				<th>在线试听</th>
				<th>音乐下载</th>
		  	</tr>
		</thead>
		<tbody>
			<?php foreach ($ba as $k => $v): ?>
				<tr class="am-active">
					<td><?php echo $v['name'];?></td>
					<td><?php echo $v['zqr'];?></td>
					<td><a href="<?php echo $v['mice'];?>" target="_black"><?php echo $v['mice'];?></td>
					<td><a href="<?php echo $v['mice'];?>" target="_black">播放</td>
					<td><a href="./xiazai.php?c=<?php echo $v['mice'];?>">下载</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>

	