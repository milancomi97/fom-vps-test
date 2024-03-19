<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .info { margin-bottom: 20px; }
    </style>
</head>
<body>
<p class="info">Memory: <span>{{$memory}}</span></p>
<p class="info">Total ram: <span>{{$totalram}}</span></p>
<p class="info">Used mem in GB: <span>{{$usedmemInGB}}</span></p>
<p class="info">CPU Load: <span>{{$load}}</span></p>

<script>
    setTimeout(function(){
        window.location.reload();
    }, 5000);
</script>
</body>
</html>
