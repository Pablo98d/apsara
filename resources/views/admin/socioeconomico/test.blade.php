<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST</title>
</head>
<body>
    <h1>HOLA</h1>
    @php
        // dd($docs_referencia);
    @endphp
    <div>
        <img src="https://laferiecita.com/ws/documentos/{{$docs_referencia[0]->path_url}}" style="margin-top: 35px;" width="350px" height="400px" > 
    </div>
</body>
</html>