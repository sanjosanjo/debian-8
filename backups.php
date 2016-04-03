<?php
$ftp_server = "";
$ftp_user_name = "";
$ftp_user_pass = "";

$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

ftp_pasv($conn_id, true); // Passive mode

/**
 * https://php.net/manual/fr/function.ftp-rawlist.php#110803
 */

function ftpListDetailed($resource, $directory = '.') { 
	if (is_array($children = ftp_rawlist($resource, $directory))) { 
		$items = array();

		foreach ($children as $child) {
			$chunks = preg_split("/\s+/", $child);
			list($item['rights'], $item['number'], $item['user'], $item['group'], $item['size'], $item['month'], $item['day'], $item['time']) = $chunks;
			$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';
			array_splice($chunks, 0, 8);
			$items[implode(" ", $chunks)] = $item;
		} 

		return $items; 
	} 
}

function byteconvert($bytes) {
    $symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $exp = floor( log($bytes) / log(1024) );
    return sprintf( '%.2f ' . $symbol[ $exp ], ($bytes / pow(1024, floor($exp))) );
}

$list = ftpListDetailed($conn_id);
$total_size = 0;
ftp_close($conn_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>FTP backups</title>
	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<style>
		body {
			padding-top: 20px;
		}
	</style>
	
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="container">
		<?php if(!empty($list)):?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo $ftp_server;?>
				</div>
				<table class="table table-bordered table-condensed table-striped">
					<tr>
						<th>File</th>
						<th>Size</th>
						<th>Changed</th>
						<th>Owner</th>
						<th>Group</th>
						<th>Rights</th>
						<th>Type</th>
					</tr>
					<?php foreach($list as $file => $details):?>
						<tr>
							<td><?php echo $file;?></td>
							<td><?php echo byteconvert($details['size']);?></td>
							<td><?php echo $details['day'];?> <?php echo $details['month'];?> <?php echo $details['time'];?></td>
							<td><?php echo $details['user'];?></td>
							<td><?php echo $details['group'];?></td>
							<td><?php echo $details['rights'];?></td>
							<td><?php echo $details['type'];?></td>
						</tr>
						<?php
						$total_size += $details['size'];
						?>
					<?php endforeach;?>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo byteconvert($total_size);?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
		<?php endif;?>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</body>
</html>
