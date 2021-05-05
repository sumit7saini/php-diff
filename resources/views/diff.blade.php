<!DOCTYPE html>
<html lang="en">
<head>
	<title>Diff</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
		<table class="table">
			<thead>
				<tr>
					<th>v1</th>
					<th>v2</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data['common'] as $name): ?>
					<tr onclick="window.location.href='diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td><?= $name ?></td>
						<td><?= $name ?></td>
					</tr>
				<?php endforeach ?>
				<?php foreach($data['onlyinv1'] as $name): ?>
					<tr onclick="window.location.href='diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td><?= $name ?></td>
						<td></td>
					</tr>
				<?php endforeach ?>
				<?php foreach($data['onlyinv2'] as $name): ?>
					<tr onclick="window.location.href='diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td></td>
						<td><?= $name ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

</body>
</html>

<style>
tr {
    cursor: pointer;
}
tr:hover {
  background-color: gray;
}
</style>
