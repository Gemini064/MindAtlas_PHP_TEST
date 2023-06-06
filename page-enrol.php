<?php
	global $wpdb;
	// $user_table = 'users';
	// $course_table = 'courses';
	// $enrol_table = 'enrolments';
	// $sql = "SELECT * FROM `users` 
	// INNER JOIN `enrolments` ON users.ID = enrolments.userID
	// INNER JOIN `courses` ON courses.ID = enrolments.courseID;";
	// $rows = $wpdb->get_results($sql);
	// $arr_enrol_user = array();
	// $arr_enrol_code = array();
	// $arr_enrol_desc = array();
	// $arr_enrol_stat = array();
	// foreach ($rows as $row){
	// 	array_push($arr_enrol_user, $row->FirstName . " " . $row->LastName);
	// 	array_push($arr_enrol_code, $row->courseID);
	// 	array_push($arr_enrol_desc, $row->Description);
	// 	array_push($arr_enrol_stat, $row->status);
	// }
	// $size = count($arr_enrol_user);
	// $pages = ceil($size/20);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<title>ENROLMENT</title>
	<style type="text/css">
		body{
			background: #ededed;
		  	font-family: 'Roboto', sans-serif;
		}
		section{
			margin: 50px 80px;
		}
		table{
			width: 100%;
			table-layout: fixed;
			border-collapse: collapse;
		}
		thead{
			background-color: #f5f5f5;
		}
		th{
			padding: 10px 15px;
			text-align: left;
			font-weight: 500;
			font-size: 13px;
			color: grey;
		}
		tbody>tr{
			background-color: #f5f5f5;
			border-top: 1px solid rgba(0, 0, 0, .1);
			border-bottom: 1px solid rgba(0, 0, 0, .1);
		}
		td{
			padding: 15px;
			text-align: left;
			vertical-align:middle;
			font-weight: 500;
			font-size: 12px;
		}
		h1{
			padding-bottom: 9px;
			margin: 0px;
		    color: #49505e;
		    font-size: 20px;
		}
		.completed {
			color: green;
		}
		.in_progress {
			color: #053E4C;
		}
		.not_started {
			color: #A7235B;
		}
		.completed > span {
			background: #9AEBA3;
			padding: 5px 10px;
			border-radius: 5px;
		}
		.not_started > span {
			background: #F4A9C8;
			padding: 5px 10px;
			border-radius: 5px;
		}
		.in_progress > span {
			background: #96D8E8;
			padding: 5px 10px;
			border-radius: 5px;
		}
		.pagination {
			display: flex;
			justify-content: center;
			padding-top: 10px;
		}
		.form-outline .form-control {
			background: white;
		}
	</style>
</head>
<body>
	<section>
		<h1>ENROLMENT LIST</h1>
		<form action="" method="GET">
			<div class="input-group mb-3">
				<input type="text" name="search" value="<?php if(isset($_GET['search'])) {echo $_GET['search']; } ?>" class="form-control" placeholder="Search Enrolment">
				<button type="submit" class="btn btn-primary">Search</button>
			</div>
		</form>

		<div class="tbl-header">
			<table>
				<thead>
					<tr>
						<th>User Name</th>
						<th>Course Code</th>
						<th>Course Title</th>
						<th>Completion Status</th>
					</tr>
				</thead>
			</table>
		</div>
		<table>
			<tbody>
				<?php
					if (isset($_GET['search']))
					{
						$filterValue = $_GET['search'];
						$sql = "SELECT * FROM `users` 
						INNER JOIN `enrolments` ON users.ID = enrolments.userID
						INNER JOIN `courses` ON courses.ID = enrolments.courseID 
						WHERE enrolments.courseID LIKE '%$filterValue%'
						OR courses.Description LIKE '%$filterValue%'
						;";
					} else {
						$sql = "SELECT * FROM `users` 
						INNER JOIN `enrolments` ON users.ID = enrolments.userID
						INNER JOIN `courses` ON courses.ID = enrolments.courseID
						;";
					}
					$rows = $wpdb->get_results($sql);
					$arr_enrol_user = array();
					$arr_enrol_code = array();
					$arr_enrol_desc = array();
					$arr_enrol_stat = array();
					foreach ($rows as $row){
						array_push($arr_enrol_user, $row->FirstName . " " . $row->LastName);
						array_push($arr_enrol_code, $row->courseID);
						array_push($arr_enrol_desc, $row->Description);
						array_push($arr_enrol_stat, $row->status);
					}
					$size = count($arr_enrol_user);

					if ($size > 0) {
						for($i = 0; $i < $size; $i++) { ?>
							<tr>
								<td><?php echo $arr_enrol_user[$i]; ?></td>
								<td><?php echo $arr_enrol_code[$i]; ?></td>
								<td><?php echo $arr_enrol_desc[$i]; ?></td>
								<?php if ($arr_enrol_stat[$i] == 'completed') { ?>
								<td class="completed">
									<span>
										<?php echo $arr_enrol_stat[$i]; ?></td>
									</span>
								<?php } else if ($arr_enrol_stat[$i] == 'in progress') {?>
								<td class="in_progress">
									<span>
										<?php echo $arr_enrol_stat[$i]; ?>
									</span>
								</td>
								<?php } else if ($arr_enrol_stat[$i] == 'not started') {?>
								<td class="not_started">
									<span>
										<?php echo $arr_enrol_stat[$i]; ?>
									</span>
								</td>
								<?php } ?>
							</tr>
						<?php }
					} else {
						?>
						<tr>
							<td colspan="4">No Record Found</td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<ul class="pagination">
			<li class="page-item">
			<a class="page-link" href="#" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
				<span class="sr-only">Previous</span>
			</a>
			</li>
			<?php for ($i = 1; $i <= $pages; $i++) { ?>
			<li class="page-item">
				<a class="page-link" href="#">
					<?php echo $i;?>
				</a>
			</li>
			<?php } ?>
			<li class="page-item">
			<a class="page-link" href="#" aria-label="Next">
				<span aria-hidden="true">&raquo;</span>
				<span class="sr-only">Next</span>
			</a>
			</li>
		</ul>
	</section>
</body>
</html>

<script type="text/javascript">
</script>