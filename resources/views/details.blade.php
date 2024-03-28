<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .info { margin-bottom: 20px; }

        span{
            font-weight: bolder;
        }
    </style>
</head>
<body>
<p class="info">Memory: <span>{{$memory}}</span></p>
<p class="info">Total ram: <span>{{$totalram}}</span></p>
<p class="info">Used mem in GB: <span>{{$usedmemInGB}}</span></p>
<p class="info">CPU Load: <span>{{$load}}</span></p>

<?php $status = opcache_get_status();

echo '<pre>';
print_r([
    'opcache_enabled' => $status['opcache_enabled'],
    'cache_full' => $status['cache_full'],
    'used_memory' => $status['memory_usage']['used_memory'],
    'free_memory' => $status['memory_usage']['free_memory'],
    'wasted_memory' => $status['memory_usage']['wasted_memory'],
    'cached_scripts' => $status['opcache_statistics']['num_cached_scripts'],
    'cached_keys' => $status['opcache_statistics']['num_cached_keys'],
    'hits' => $status['opcache_statistics']['hits'],
    'misses' => $status['opcache_statistics']['misses'],
    'start_time' => $status['opcache_statistics']['start_time'],
    'last_restart_time' => $status['opcache_statistics']['last_restart_time'],
]);
?>
<script>
    // setTimeout(function(){
    //     window.location.reload();
    // }, 1000);
</script>
</body>
</html>
