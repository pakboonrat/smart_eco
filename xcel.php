<?php
if(isset($_GET['act'])){
	if($_GET['act']== 'excel'){
		
		
		header("Content-Disposition: attachment; filename=export.xls");
		
		
		header("Content-Type: application/vnd.ms-excel");
		

	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>devbanban</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<br /><br /><br />
					<h4> ::ตย. PHP EXPORT TO EXCEL by devbanban.com ::
					</h4>
					
					<p>
						<a href="?act=excel" class="btn btn-primary"> Export->Excel </a>
					</p>
					
					<table border="1" class="table table-hover">
						<thead>
							<tr class="info">
								<th>data1</th>
								<th>data2</th>
								<th>data3</th>
								<th>date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>19-09-2019</td>
							</tr>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>19-09-2019</td>
							</tr>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>19-09-2019</td>
							</tr>
							<tr>
								<td>data</td>
								<td>data</td>
								<td>data</td>
								<td>19-09-2019</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>