<html>
  <head>
  <title>Upload Folder using PHP </title>
  </head>
  <body>
  <form action="/diff-files" method="post" enctype="multipart/form-data">
  @csrf 
  Type Folder Name:<input type="text" name="foldername" /><br/><br/>
  Select Folder to Upload(v1): <input type="file" name="filesv1[]" id="filesv1" multiple directory webkitdirectory mozdirectory /><br/><br/> 
  Select Folder to Upload(v2): <input type="file" name="filesv2[]" id="filesv2" multiple directory="" webkitdirectory="" moxdirectory="" /><br/><br/> 
  <input type="Submit" value="Upload" name="upload" />
  </form>
  </body>
  </html>