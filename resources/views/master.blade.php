<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <title>Php diff</title>
</head>
<body>
    {{View::make('header')}}
    @yield("content")
    {{View::make('footer')}}
</body>

<style>

    table.diff{
        table-layout: fixed;
        width: 100% ;
    }
    .diff-files tbody tr:hover {
        cursor: pointer;
        background-color: gray;
    }
    .diff-files th {
        color: #dd5;
    }

    td.diffDeleted{
        background-color: #ffeef0;
        padding: 5px 10px;
    }
    td.diffInserted{
        background-color: #e6ffed;
        padding: 5px 10px;
    }
    td.diffUnmodified{
        padding: 5px 10px;
    }
    form.files-select{
        margin-top:10%;
        margin-right:10%;
        margin-left:10%;
    }
    div.diff-files{
        margin-right:10%;
        margin-left:10%;
    }
    table.diff-table{
        background: #34495E;
        color: #fff;
        border-radius: .4em;
        width: 100%;
    }
    div.file-header{
        padding: 5px 10px;
        background-color: #fafbfc;
        border-bottom: 1px solid #e1e4e8;
    }
    div.difffile{
        border: 1px solid #e1e4e8;
        border-radius: 6px;
        margin: 10px;
    }
    .uploads{
        margin-top:5%;
        margin-right:10%;
        margin-left:10%;
        margin-bottom: :1%;
    }
    .uploads table{
        width: 100%;
    }
    .uploads tr.upload:hover{
        cursor: pointer;
        text-decoration: underline;
        color: blue;
    }

</style>

</html> 