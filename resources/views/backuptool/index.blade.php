
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
<div class="container">
    <h1>All Files in Directory</h1>

    <ul>
        @foreach ($files as $file)
            <li>{{ $file }}</li>
        @endforeach
    </ul>
</div>
</body>
</html>
