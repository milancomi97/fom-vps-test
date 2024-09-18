<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poenter Log File Preview</title>
    <style>
        body {
            font-family: monospace;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .log-container {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            max-height: 80vh;
            overflow-y: scroll;
        }
        .log-line {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<h1>Log File Preview</h1>
<div class="log-container">
    @foreach($log as $line)
        <div class="log-line">{{ $line }}</div>
    @endforeach
</div>
</body>
</html>
