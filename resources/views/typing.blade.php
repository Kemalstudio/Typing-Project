<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0f0f0f">
    <meta name="description" content="Professional Typing Speed Test - Measure your WPM and accuracy">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Typing Speed Test | Master Your Speed</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <!-- Settings Modal -->
  <div class="modal" id="settingsModal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="settingsTitle">Settings</h2>
        <button class="modal-close" id="modalClose">&times;</button>
      </div>
      <div class="modal-body">
        <!-- Language Selection -->
        <div class="settings-group">
          <label id="langLabel">Language / Язык / Dil</label>
          <div class="language-buttons">
            <button class="lang-btn active" data-lang="en">English</button>
            <button class="lang-btn" data-lang="ru">Русский</button>
            <button class="lang-btn" data-lang="tk">Türkmençe</button>
          </div>
        </div>

        <!-- Duration Selection -->
        <div class="settings-group">
          <label id="durationLabel">Test Duration (seconds)</label>
          <div class="duration-buttons">
            <button class="duration-btn" data-duration="30">30s</button>
            <button class="duration-btn active" data-duration="60">60s</button>
            <button class="duration-btn" data-duration="90">90s</button>
            <button class="duration-btn" data-duration="120">2 min</button>
          </div>
          <div class="custom-duration">
            <input type="number" id="customDuration" min="10" max="300" placeholder="Custom (10-300s)" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="modal-btn-primary" id="modalConfirm" class="modal-btn-confirm">OK</button>
      </div>
    </div>
  </div>

  <div class="main-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-content">
        <div class="sidebar-section">
          <h3 id="statsLabel">Statistics</h3>
          <div class="stat-card">
            <div class="stat-card-label" id="pbLabel">Personal Best</div>
            <div class="stat-card-value" id="pbWpm">0 WPM</div>
          </div>
          <div class="stat-card">
            <div class="stat-card-label" id="testTimeLabel">Test Duration</div>
            <div class="stat-card-value" id="testDurationDisplay">60s</div>
          </div>
        </div>

        <div class="sidebar-section">
          <h3 id="controlsLabel">Controls</h3>
          <div class="difficulty-section">
            <label id="diffLabel">Difficulty</label>
            <div class="button-group sidebar-buttons">
              <button class="btn difficulty-btn active" data-difficulty="easy">Easy</button>
              <button class="btn difficulty-btn" data-difficulty="medium">Medium</button>
              <button class="btn difficulty-btn" data-difficulty="hard">Hard</button>
            </div>
          </div>
          <div class="mode-section">
            <label id="modeLabel">Mode</label>
            <div class="button-group sidebar-buttons">
              <button class="btn mode-btn active" data-mode="timed">Timed</button>
              <button class="btn mode-btn" data-mode="passage">Passage</button>
            </div>
          </div>
        </div>

        <div class="sidebar-section">
          <button class="settings-btn" id="settingsBtn">⚙️ <span id="settingsLabel">Settings</span></button>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="container">
      <!-- Header Section -->
      <div class="header">
        <div>
          <div class="logo">
            <span class="logo-icon">⌨️</span>
            <span id="appTitle">Typing Speed Test</span>
          </div>
          <div class="logo-subtitle" id="subtitle">Type as fast as you can</div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="stats-display">
        <div class="stat-item">
          <div class="stat-label">WPM</div>
          <div class="stat-value wpm" id="wpmDisplay">0</div>
        </div>
        <div class="stat-item">
          <div class="stat-label">Accuracy</div>
          <div class="stat-value accuracy" id="accuracyDisplay">0%</div>
        </div>
        <div class="stat-item">
          <div class="stat-label">Time</div>
          <div class="stat-value time" id="timeDisplay">0:00</div>
        </div>
      </div>

      <!-- Passage Container -->
      <div class="passage-container">
        <div class="passage" id="passageDisplay" role="region" aria-label="Typing area"></div>
      </div>

      <!-- Start Button Container -->
      <div class="start-button-container" id="startContainer">
        <button class="start-button" id="startBtn" data-lang="start">Start Typing Test</button>
        <p class="hint" id="hint">Click the text and start typing</p>
      </div>

      <!-- Results Container -->
      <div class="results-container" id="resultsContainer">
        <div class="results-header" id="completeLabel">Test Complete!</div>
        <div class="results-message" id="resultsMessage">Great effort! Keep practicing to improve.</div>
        <div class="results-stats">
          <div class="results-stat">
            <div class="results-stat-value" id="finalWpm">0</div>
            <div class="results-stat-label" id="wpmLabelResult">WPM</div>
          </div>
          <div class="results-stat">
            <div class="results-stat-value" id="finalAccuracy">0%</div>
            <div class="results-stat-label" id="accuracyLabelResult">Accuracy</div>
          </div>
          <div class="results-stat">
            <div class="results-stat-value" id="finalChars">0</div>
            <div class="results-stat-label" id="charsLabelResult">Correct Chars</div>
          </div>
        </div>
        <div>
          <button class="go-again-button" id="goAgainBtn">Restart Test ↻</button>
          <button class="reset-button" id="resetBtn">Change Settings</button>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
