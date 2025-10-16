<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>東京の天気ダッシュボード</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 2rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
    }
    h1 {
      color: white;
      text-align: center;
      margin-bottom: 0.5rem;
    }
    .subtitle {
      color: rgba(255, 255, 255, 0.9);
      text-align: center;
      margin-bottom: 2rem;
    }
    .weather-card {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }
    .location {
      font-size: 1.5rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 0.5rem;
    }
    .update-time {
      color: #666;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }
    .main-temp {
      font-size: 4rem;
      font-weight: bold;
      color: #667eea;
      margin: 1rem 0;
    }
    .weather-desc {
      font-size: 1.3rem;
      color: #555;
      margin-bottom: 2rem;
    }
    .weather-details {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }
    .detail-item {
      background: #f7f7f7;
      padding: 1rem;
      border-radius: 10px;
    }
    .detail-label {
      font-size: 0.85rem;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .detail-value {
      font-size: 1.3rem;
      font-weight: bold;
      color: #333;
      margin-top: 0.3rem;
    }
    .loading {
      text-align: center;
      color: #666;
      padding: 2rem;
    }
    .error {
      color: #e74c3c;
      text-align: center;
      padding: 1rem;
    }
    .weather-icon {
      font-size: 3rem;
      text-align: center;
      margin: 1rem 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🌤️ 天気ダッシュボード</h1>
    <p class="subtitle">リアルタイム天気情報 • 30秒ごとに更新</p>

    <div class="weather-card" id="weatherCard">
      <div class="loading">天気データを読み込み中...</div>
    </div>
  </div>

  <script>
    // Get weather icon based on weather code
    function getWeatherIcon(code) {
      if (code === 0 || code === 1) return '☀️';
      if (code === 2) return '⛅';
      if (code === 3) return '☁️';
      if (code >= 45 && code <= 48) return '🌫️';
      if (code >= 51 && code <= 55) return '🌦️';
      if (code >= 61 && code <= 65) return '🌧️';
      if (code >= 71 && code <= 77) return '❄️';
      if (code >= 80 && code <= 82) return '🌧️';
      if (code >= 85 && code <= 86) return '🌨️';
      if (code >= 95) return '⛈️';
      return '🌤️';
    }

    async function updateWeather() {
      try {
        const res = await fetch('data.php');
        const data = await res.json();
        
        if (data.success) {
          const icon = getWeatherIcon(data.weather_code);
          
          document.getElementById('weatherCard').innerHTML = `
            <div class="location">${data.location}</div>
            <div class="update-time">最終更新: ${data.time}</div>
            <div class="weather-icon">${icon}</div>
            <div class="main-temp">${data.temperature}°C</div>
            <div class="weather-desc">${data.weather_description}</div>
            <div class="weather-details">
              <div class="detail-item">
                <div class="detail-label">体感温度</div>
                <div class="detail-value">${data.feels_like}°C</div>
              </div>
              <div class="detail-item">
                <div class="detail-label">湿度</div>
                <div class="detail-value">${data.humidity}%</div>
              </div>
              <div class="detail-item">
                <div class="detail-label">風速</div>
                <div class="detail-value">${data.wind_speed} km/h</div>
              </div>
              <div class="detail-item">
                <div class="detail-label">降水量</div>
                <div class="detail-value">${data.precipitation} mm</div>
              </div>
            </div>
          `;
        } else {
          document.getElementById('weatherCard').innerHTML = `
            <div class="error">❌ ${data.error || '天気データの読み込みに失敗しました'}</div>
          `;
        }
      } catch (e) {
        document.getElementById('weatherCard').innerHTML = `
          <div class="error">❌ 天気データの取得中にエラーが発生しました。もう一度お試しください。</div>
        `;
        console.error('Error:', e);
      }
    }

    updateWeather();                      // run immediately
    setInterval(updateWeather, 30000);   // refresh every 30 seconds
  </script>
</body>
</html>
