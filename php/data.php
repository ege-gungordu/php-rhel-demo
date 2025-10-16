<?php
// Fetch weather data for Tokyo from Open-Meteo API
// Tokyo coordinates: 35.6762°N, 139.6503°E

$tokyo_lat = 35.6762;
$tokyo_lon = 139.6503;

// Open-Meteo API URL with current weather parameters
$api_url = "https://api.open-meteo.com/v1/forecast?latitude={$tokyo_lat}&longitude={$tokyo_lon}&current=temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,wind_speed_10m&timezone=Asia/Tokyo";

// Fetch weather data
$weather_data = file_get_contents($api_url);
$weather = json_decode($weather_data, true);

// 天気コードの説明（WMO天気解釈コード）
$weather_descriptions = [
    0 => '快晴',
    1 => '晴れ',
    2 => '一部曇り',
    3 => '曇り',
    45 => '霧',
    48 => '霧氷',
    51 => '小雨',
    53 => '雨',
    55 => '大雨',
    61 => 'にわか雨',
    63 => '雨',
    65 => '大雨',
    71 => '小雪',
    73 => '雪',
    75 => '大雪',
    77 => 'あられ',
    80 => 'にわか雨',
    81 => 'にわか雨',
    82 => '激しいにわか雨',
    85 => 'にわか雪',
    86 => '激しいにわか雪',
    95 => '雷雨',
    96 => '雹を伴う雷雨',
    99 => '激しい雹を伴う雷雨'
];

if ($weather && isset($weather['current'])) {
    $current = $weather['current'];
    $weather_code = $current['weather_code'];
    
    $response = [
        'success' => true,
        'location' => '東京',
        'time' => date('H:i:s'),
        'temperature' => round($current['temperature_2m'], 1),
        'feels_like' => round($current['apparent_temperature'], 1),
        'humidity' => $current['relative_humidity_2m'],
        'wind_speed' => round($current['wind_speed_10m'], 1),
        'precipitation' => $current['precipitation'],
        'weather_description' => $weather_descriptions[$weather_code] ?? '不明',
        'weather_code' => $weather_code
    ];
} else {
    $response = [
        'success' => false,
        'error' => '天気データの取得に失敗しました'
    ];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
