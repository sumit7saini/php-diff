@extends("master")
@section("content")
<div class="difffile">
<div class="file-header"><?= $file ?></div>
<pre><?= $data ?></pre>
</div>
@endsection