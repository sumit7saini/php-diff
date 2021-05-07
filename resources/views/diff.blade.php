@extends("master")
@section("content")
	
	<div class="container diff-files">
		<h3>Choose file to see diff</h3>
		<table class="diff-table">
			<thead>
				<tr>
					<th>v1</th>
					<th>v2</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($data['common'] as $name): ?>
					<tr onclick="window.location.href='/diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td><?= $name ?></td>
						<td><?= $name ?></td>
					</tr>
				<?php endforeach ?>
				<?php foreach($data['onlyinv1'] as $name): ?>
					<tr onclick="window.location.href='/diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td><?= $name ?></td>
						<td></td>
					</tr>
				<?php endforeach ?>
				<?php foreach($data['onlyinv2'] as $name): ?>
					<tr onclick="window.location.href='/diff-file/<?= $data['folder'].'/'.$name ?>';return false;">
						<td></td>
						<td><?= $name ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>

@endsection
