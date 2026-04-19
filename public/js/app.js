// ===== Translations =====
const translations = {
  en: {
    appTitle: 'Typing Speed Test',
    subtitle: 'Type as fast as you can',
    statsLabel: 'Statistics',
    pbLabel: 'Personal Best',
    testTimeLabel: 'Test Duration',
    controlsLabel: 'Controls',
    diffLabel: 'Difficulty',
    modeLabel: 'Mode',
    settingsLabel: 'Settings',
    settingsTitle: 'Settings',
    langLabel: 'Language',
    durationLabel: 'Test Duration (seconds)',
    startBtn: 'Start Typing Test',
    hint: 'Click the text and start typing',
    completeLabel: 'Test Complete!',
    wpmLabelResult: 'WPM',
    accuracyLabelResult: 'Accuracy',
    charsLabelResult: 'Correct Chars',
    goAgainBtn: 'Restart Test ↻',
    changeSettingsBtn: 'Change Settings'
  },
  ru: {
    appTitle: 'Тест Скорости Печати',
    subtitle: 'Печатайте как можно быстрее',
    statsLabel: 'Статистика',
    pbLabel: 'Лучший Результат',
    testTimeLabel: 'Длительность',
    controlsLabel: 'Управление',
    diffLabel: 'Сложность',
    modeLabel: 'Режим',
    settingsLabel: 'Настройки',
    settingsTitle: 'Настройки',
    langLabel: 'Язык',
    durationLabel: 'Длительность теста (секунды)',
    startBtn: 'Начать Тест',
    hint: 'Нажмите на текст и начните печатать',
    completeLabel: 'Тест Завершён!',
    wpmLabelResult: 'СПМ',
    accuracyLabelResult: 'Точность',
    charsLabelResult: 'Верных Символов',
    goAgainBtn: 'Попробовать Снова ↻',
    changeSettingsBtn: 'Изменить Настройки'
  },
  tk: {
    appTitle: 'Çap Tizligini Synamak',
    subtitle: 'Mümkin boldugyça çap ediň',
    statsLabel: 'Statistika',
    pbLabel: 'Iň Ýokary Netije',
    testTimeLabel: 'Wagt',
    controlsLabel: 'Dolandyryş',
    diffLabel: 'Çetin Derejesi',
    modeLabel: 'Режim',
    settingsLabel: 'Sazlamalar',
    settingsTitle: 'Sazlamalar',
    langLabel: 'Dil',
    durationLabel: 'Synaw wagty (sekund)',
    startBtn: 'Synawa Başla',
    hint: 'Tekste basyň we çap ediň',
    completeLabel: 'Synaw Tamamlandy!',
    wpmLabelResult: 'ÇPM',
    accuracyLabelResult: 'Hasyllygy',
    charsLabelResult: 'Dogry Nyşan',
    goAgainBtn: 'Gaýtadan Synayň ↻',
    changeSettingsBtn: 'Sazlamalary Üýtget'
  }
};

class TypingSpeedTest {
  constructor() {
    this.currentLanguage = localStorage.getItem('language') || 'en';
    this.initializeState();
    this.cacheElements();
    this.setupModal();
    this.attachEventListeners();
    this.loadPersonalBest();
    this.loadPassage();
    this.updateUI();
  }

  initializeState() {
    this.state = {
      isTestRunning: false,
      isPaused: false,
      currentDifficulty: 'easy',
      currentMode: 'timed',
      timeElapsed: 0,
      currentPassage: '',
      userInput: '',
      startTime: null,
      timerInterval: null,
      personalBest: 0,
      testDuration: (parseInt(localStorage.getItem('testDuration')) || 60) * 1000,
      stats: {
        wpm: 0,
        accuracy: 0,
        correctChars: 0,
        totalChars: 0
      }
    };
  }

  cacheElements() {
    this.elements = {
      passageDisplay: document.getElementById('passageDisplay'),
      startBtn: document.getElementById('startBtn'),
      startContainer: document.getElementById('startContainer'),
      resultsContainer: document.getElementById('resultsContainer'),
      wpmDisplay: document.getElementById('wpmDisplay'),
      accuracyDisplay: document.getElementById('accuracyDisplay'),
      timeDisplay: document.getElementById('timeDisplay'),
      pbWpmDisplay: document.getElementById('pbWpm'),
      testDurationDisplay: document.getElementById('testDurationDisplay'),
      difficultyBtns: document.querySelectorAll('.difficulty-btn'),
      modeBtns: document.querySelectorAll('.mode-btn'),
      goAgainBtn: document.getElementById('goAgainBtn'),
      resetBtn: document.getElementById('resetBtn'),
      resultsMessage: document.getElementById('resultsMessage'),
      finalWpm: document.getElementById('finalWpm'),
      finalAccuracy: document.getElementById('finalAccuracy'),
      finalChars: document.getElementById('finalChars'),
      settingsBtn: document.getElementById('settingsBtn'),
      settingsModal: document.getElementById('settingsModal'),
      modalClose: document.getElementById('modalClose'),
      modalConfirm: document.getElementById('modalConfirm'),
      langBtns: document.querySelectorAll('.lang-btn'),
      durationBtns: document.querySelectorAll('.duration-btn'),
      customDuration: document.getElementById('customDuration')
    };
  }

  setupModal() {
    this.elements.langBtns.forEach(btn => {
      if (btn.dataset.lang === this.currentLanguage) {
        btn.classList.add('active');
      }
    });

    const currentDurationSecs = this.state.testDuration / 1000;
    this.elements.durationBtns.forEach(btn => {
      if (parseInt(btn.dataset.duration) === currentDurationSecs) {
        btn.classList.add('active');
      }
    });
  }

  attachEventListeners() {
    this.elements.difficultyBtns.forEach(btn => {
      btn.addEventListener('click', () => this.selectDifficulty(btn));
    });

    this.elements.modeBtns.forEach(btn => {
      btn.addEventListener('click', () => this.selectMode(btn));
    });

    this.elements.startBtn.addEventListener('click', () => this.startTest());

    this.elements.goAgainBtn.addEventListener('click', () => this.startTest());
    this.elements.resetBtn.addEventListener('click', () => this.resetTest());

    this.elements.settingsBtn.addEventListener('click', () => this.openModal());
    this.elements.modalClose.addEventListener('click', () => this.closeModal());
    this.elements.modalConfirm.addEventListener('click', () => this.saveSettings());

    this.elements.langBtns.forEach(btn => {
      btn.addEventListener('click', () => this.selectLanguage(btn));
    });

    this.elements.durationBtns.forEach(btn => {
      btn.addEventListener('click', () => this.selectDuration(btn));
    });

    this.elements.customDuration.addEventListener('change', (e) => {
      const value = parseInt(e.target.value);
      if (value >= 10 && value <= 300) {
        this.elements.durationBtns.forEach(btn => btn.classList.remove('active'));
        this.elements.customDuration.dataset.selected = value;
      }
    });

    document.addEventListener('keydown', (e) => this.handleGlobalKeyboardShortcuts(e));

    this.elements.settingsModal.addEventListener('click', (e) => {
      if (e.target === this.elements.settingsModal) {
        this.closeModal();
      }
    });
  }

  selectLanguage(btn) {
    this.elements.langBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    this.currentLanguage = btn.dataset.lang;
  }

  selectDuration(btn) {
    this.elements.durationBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    this.elements.customDuration.value = '';
    delete this.elements.customDuration.dataset.selected;
  }

  openModal() {
    this.elements.settingsModal.classList.add('show');
  }

  closeModal() {
    this.elements.settingsModal.classList.remove('show');
  }

  saveSettings() {
    localStorage.setItem('language', this.currentLanguage);

    let duration = 60;
    const activeBtn = document.querySelector('.duration-btn.active');
    if (activeBtn) {
      duration = parseInt(activeBtn.dataset.duration);
    } else if (this.elements.customDuration.dataset.selected) {
      duration = parseInt(this.elements.customDuration.dataset.selected);
    } else if (this.elements.customDuration.value) {
      const value = parseInt(this.elements.customDuration.value);
      if (value >= 10 && value <= 300) {
        duration = value;
      }
    }

    localStorage.setItem('testDuration', duration);
    this.state.testDuration = duration * 1000;

    this.closeModal();
    this.updateUI();
  }

  updateUI() {
    const t = translations[this.currentLanguage];

    document.getElementById('appTitle').textContent = t.appTitle;
    document.getElementById('subtitle').textContent = t.subtitle;
    document.getElementById('statsLabel').textContent = t.statsLabel;
    document.getElementById('pbLabel').textContent = t.pbLabel;
    document.getElementById('testTimeLabel').textContent = t.testTimeLabel;
    document.getElementById('controlsLabel').textContent = t.controlsLabel;
    document.getElementById('diffLabel').textContent = t.diffLabel;
    document.getElementById('modeLabel').textContent = t.modeLabel;
    document.getElementById('settingsBtn').innerHTML = `⚙️ <span>${t.settingsLabel}</span>`;
    document.getElementById('settingsTitle').textContent = t.settingsTitle;
    document.getElementById('langLabel').textContent = t.langLabel;
    document.getElementById('durationLabel').textContent = t.durationLabel;
    document.getElementById('startBtn').textContent = t.startBtn;
    document.getElementById('hint').textContent = t.hint;
    document.getElementById('completeLabel').textContent = t.completeLabel;
    document.getElementById('wpmLabelResult').textContent = t.wpmLabelResult;
    document.getElementById('accuracyLabelResult').textContent = t.accuracyLabelResult;
    document.getElementById('charsLabelResult').textContent = t.charsLabelResult;
    document.getElementById('goAgainBtn').textContent = t.goAgainBtn;
    document.getElementById('resetBtn').textContent = t.changeSettingsBtn;

    const durationSecs = this.state.testDuration / 1000;
    document.getElementById('testDurationDisplay').textContent =
      durationSecs >= 60 ? Math.round(durationSecs / 60) + 'm' : durationSecs + 's';
  }

  selectDifficulty(btn) {
    if (this.state.isTestRunning) return;

    this.elements.difficultyBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    this.state.currentDifficulty = btn.dataset.difficulty;
    this.resetTest();
  }

  selectMode(btn) {
    if (this.state.isTestRunning) return;

    this.elements.modeBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    this.state.currentMode = btn.dataset.mode;
    this.resetTest();
  }

  async loadPassage() {
    try {
      const response = await fetch('data.json');
      if (!response.ok) throw new Error('Failed to load passage');

      const data = await response.json();
      const passages = data[this.state.currentDifficulty];

      if (!passages || passages.length === 0) {
        throw new Error('No passages available for this difficulty');
      }

      const randomPassage = passages[Math.floor(Math.random() * passages.length)];
      this.state.currentPassage = randomPassage.text;
      this.renderPassage();
    } catch (error) {
      console.error('Error loading passage:', error);
      this.state.currentPassage = 'The quick brown fox jumps over the lazy dog. Technology is advancing rapidly every single day.';
      this.renderPassage();
    }
  }

  renderPassage() {
    let html = '';
    for (let i = 0; i < this.state.currentPassage.length; i++) {
      const char = this.state.currentPassage[i];
      let className = 'remaining';

      if (i < this.state.userInput.length) {
        className = this.state.userInput[i] === char ? 'correct' : 'incorrect';
      } else if (i === this.state.userInput.length) {
        className = 'current';
      }

      html += `<span class="${className}">${char}</span>`;
    }
    this.elements.passageDisplay.innerHTML = html;

    const currentSpan = this.elements.passageDisplay.querySelector('.current');
    if (currentSpan) {
      const passageRect = this.elements.passageDisplay.getBoundingClientRect();
      const currentSpanRect = currentSpan.getBoundingClientRect();

      if (currentSpanRect.top < passageRect.top || currentSpanRect.bottom > passageRect.bottom) {
        currentSpan.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }
  }

  startTest() {
    if (this.state.isTestRunning) return;

    this.state.isTestRunning = true;
    this.state.userInput = '';
    this.state.timeElapsed = 0;
    this.state.startTime = Date.now();

    this.elements.startContainer.classList.add('hidden');
    this.elements.resultsContainer.classList.remove('show');

    this.loadPassage();
    this.elements.passageDisplay.focus();

    this.keyPressHandler = (e) => this.handleKeyPress(e);
    document.addEventListener('keydown', this.keyPressHandler);

    this.state.timerInterval = setInterval(() => this.updateTimer(), 100);

    if (this.state.currentMode === 'timed') {
      this.testTimeoutId = setTimeout(() => {
        if (this.state.isTestRunning) {
          this.endTest();
        }
      }, this.state.testDuration);
    }
  }

  handleKeyPress(e) {
    if (!this.state.isTestRunning) return;

    const key = e.key;

    if (key === 'Backspace') {
      e.preventDefault();
      this.state.userInput = this.state.userInput.slice(0, -1);
    } else if (key === 'Escape') {
      e.preventDefault();
      this.endTest();
      return;
    } else if (key.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) {
      this.state.userInput += key;

      if (this.state.currentMode === 'passage' && this.state.userInput.length === this.state.currentPassage.length) {
        this.endTest();
        return;
      }
    } else {
      return;
    }

    this.renderPassage();
    this.updateStats();
  }

  handleGlobalKeyboardShortcuts(e) {
    if (!this.state.isTestRunning && e.altKey) {
      if (e.key === '1') {
        e.preventDefault();
        this.elements.difficultyBtns[0].click();
      } else if (e.key === '2') {
        e.preventDefault();
        this.elements.difficultyBtns[1].click();
      } else if (e.key === '3') {
        e.preventDefault();
        this.elements.difficultyBtns[2].click();
      }
    }
  }

  updateStats() {
    if (!this.state.startTime) return;

    const timeInSeconds = Math.max((Date.now() - this.state.startTime) / 1000, 1);
    const minutes = timeInSeconds / 60;

    const wordsTyped = this.state.userInput.length / 5;
    const wpm = Math.round(wordsTyped / minutes);

    let correctChars = 0;
    for (let i = 0; i < this.state.userInput.length; i++) {
      if (i < this.state.currentPassage.length && this.state.userInput[i] === this.state.currentPassage[i]) {
        correctChars++;
      }
    }
    const accuracy = this.state.userInput.length > 0
      ? Math.round((correctChars / this.state.userInput.length) * 100)
      : 0;

    this.state.stats.wpm = wpm;
    this.state.stats.accuracy = accuracy;
    this.state.stats.correctChars = correctChars;
    this.state.stats.totalChars = this.state.userInput.length;

    this.elements.wpmDisplay.textContent = wpm;
    this.elements.accuracyDisplay.textContent = accuracy + '%';
  }

  updateTimer() {
    if (!this.state.startTime) return;

    const timeInSeconds = Math.floor((Date.now() - this.state.startTime) / 1000);
    const minutes = Math.floor(timeInSeconds / 60);
    const seconds = timeInSeconds % 60;

    this.elements.timeDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
  }

  endTest() {
    if (!this.state.isTestRunning) return;

    this.state.isTestRunning = false;
    clearInterval(this.state.timerInterval);
    if (this.testTimeoutId) clearTimeout(this.testTimeoutId);
    if (this.keyPressHandler) {
      document.removeEventListener('keydown', this.keyPressHandler);
    }

    const timeInSeconds = Math.max((Date.now() - this.state.startTime) / 1000, 1);
    const minutes = timeInSeconds / 60;
    const words = this.state.userInput.length / 5;
    const finalWpm = Math.round(words / minutes);

    let correctChars = 0;
    for (let i = 0; i < this.state.userInput.length; i++) {
      if (i < this.state.currentPassage.length && this.state.userInput[i] === this.state.currentPassage[i]) {
        correctChars++;
      }
    }
    const finalAccuracy = this.state.userInput.length > 0
      ? Math.round((correctChars / this.state.userInput.length) * 100)
      : 0;

    const isNewRecord = finalWpm > this.state.personalBest;
    if (isNewRecord) {
      this.state.personalBest = finalWpm;
      localStorage.setItem('personalBest', finalWpm);
      this.elements.pbWpmDisplay.textContent = finalWpm + ' WPM';
    }

    this.elements.finalWpm.textContent = finalWpm;
    this.elements.finalAccuracy.textContent = finalAccuracy + '%';
    this.elements.finalChars.textContent = correctChars;

    const t = translations[this.currentLanguage];
    const message = this.generateResultsMessage(finalWpm, finalAccuracy, isNewRecord, t);
    this.elements.resultsMessage.textContent = message;
    if (isNewRecord) {
      this.elements.resultsMessage.classList.add('pb-message');
    } else {
      this.elements.resultsMessage.classList.remove('pb-message');
    }

    this.submitResults(finalWpm, finalAccuracy, correctChars, this.state.userInput.length, Math.round(timeInSeconds));

    this.elements.startContainer.classList.add('hidden');
    this.elements.resultsContainer.classList.add('show');
  }

  generateResultsMessage(wpm, accuracy, isNewRecord, t) {
    if (isNewRecord) {
      return `🎉 ${this.currentLanguage === 'ru' ? 'Новый рекорд!' : this.currentLanguage === 'tk' ? 'Täze rekord!' : 'New Record!'} ${wpm} WPM, ${accuracy}% ${t.accuracyLabelResult.toLowerCase()}!`;
    } else if (wpm > 60) {
      return this.currentLanguage === 'ru' ? 'Отлично! Продолжай в том же духе.' : this.currentLanguage === 'tk' ? 'Oňat! Ýokarda barmagyň.' : 'Excellent! Keep pushing.';
    } else if (wpm > 40) {
      return this.currentLanguage === 'ru' ? 'Хорошо! Ты улучшаешься.' : this.currentLanguage === 'tk' ? 'Gowy! Ýakşarýarsan.' : 'Great work! Keep practicing.';
    } else if (wpm > 20) {
      return this.currentLanguage === 'ru' ? 'Хороший старт! Продолжай тренироваться.' : this.currentLanguage === 'tk' ? 'Gowy başlangyt! Praktika edin.' : 'Good effort! Practice makes perfect.';
    } else {
      return this.currentLanguage === 'ru' ? 'Продолжай тренироваться!' : this.currentLanguage === 'tk' ? 'Pratika etmegiň!' : 'Keep practicing to improve!';
    }
  }

  submitResults(wpm, accuracy, correctChars, totalChars, duration) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/results', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
      },
      body: JSON.stringify({
        wpm,
        accuracy,
        duration,
        correct_chars: correctChars,
        total_chars: totalChars,
      }),
    }).catch(error => {
      console.error('Failed to submit results:', error);
    });
  }

  resetTest() {
    this.state.isTestRunning = false;
    this.state.userInput = '';
    this.state.timeElapsed = 0;
    this.state.startTime = null;
    clearInterval(this.state.timerInterval);
    if (this.testTimeoutId) clearTimeout(this.testTimeoutId);

    this.elements.wpmDisplay.textContent = '0';
    this.elements.accuracyDisplay.textContent = '0%';
    this.elements.timeDisplay.textContent = '0:00';

    this.elements.startContainer.classList.remove('hidden');
    this.elements.resultsContainer.classList.remove('show');
    this.elements.resultsMessage.classList.remove('pb-message');

    this.elements.passageDisplay.innerHTML = '';
    this.loadPassage();

    if (this.keyPressHandler) {
      document.removeEventListener('keydown', this.keyPressHandler);
    }
  }

  loadPersonalBest() {
    const best = localStorage.getItem('personalBest');
    if (best) {
      this.state.personalBest = parseInt(best, 10);
      this.elements.pbWpmDisplay.textContent = best + ' WPM';
    } else {
      this.elements.pbWpmDisplay.textContent = '0 WPM';
    }
  }
}

let app;
document.addEventListener('DOMContentLoaded', () => {
  app = new TypingSpeedTest();
});
