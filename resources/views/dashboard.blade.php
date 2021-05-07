@extends("master")
@section("content")
<form action="/diff-files" method="post" class="files-select" enctype="multipart/form-data">
  @csrf 
  <div class="mb-4">
  <input type="file" name="filesv1[]" class="form-control mb-2" id="filesv1" multiple directory webkitdirectory mozdirectory />
  <label class="form-label" for="form2Example1">Select Folder to Upload(v1):</label>
  </div>
  <div class="mb-4">
  <input type="file" name="filesv2[]" class="form-control mb-2" id="filesv2" multiple directory="" webkitdirectory="" moxdirectory="" />
  <label class="form-label" for="form2Example1">Select Folder to Upload(v2):</label>
  </div>
  <input type="Submit" class="btn btn-primary mb-2" id="btnFetch" onclick="getElementById('btnFetch').value = 'Uploading...'" value="Upload" name="upload" />
</form>

<div class="uploads">
<h3>Access previous uploads</h3>
<table class="table">
<thead>
  <tr>
    <th>Uploads</th>
    <th>Date Added</th>
  </tr>
</thead>
<tbody>
  <?php foreach($uploads as $upload): ?>
	<tr class ="upload" onclick="window.location.href='/diff/<?= $upload ?>';return false;">
		<td><?= $upload ?></td>
		<td><?= date("Y-m-d h:i:s A",(int)$upload) ?></td>
	</tr>
</tbody>	
  <?php endforeach ?>
</table>
</div>
@endsection  