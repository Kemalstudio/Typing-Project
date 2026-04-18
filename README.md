# ⌨️ Typing Master - Professional Typing Speed Test

A modern, professional typing speed test application with beautiful design, smooth animations, and full mobile responsiveness.

## ✨ Features

### Core Functionality
- **Multiple Difficulty Levels**: Easy, Medium, and Hard passages
- **Test Modes**: 
  - Timed Mode (60 seconds)
  - Full Passage Mode (type until completion)
- **Real-time Statistics**:
  - Words Per Minute (WPM)
  - Accuracy Percentage
  - Time Tracking
- **Personal Best Tracking**: Automatically saves your highest WPM using localStorage

### User Interface
- **Modern Design**: Clean, professional interface with gradient accents
- **Dark Mode**: Eye-friendly dark theme by default
- **Responsive Layout**: 
  - Optimized for desktop (1920px+)
  - Tablet-friendly (768px - 1024px)
  - Mobile-optimized (480px - 768px)
  - Small phone support (< 480px)
- **Smooth Animations**: 
  - Entry animations for containers
  - Floating logo effect
  - Pulsing results for personal records
  - Blinking cursor indicator
  - Hover effects on buttons
- **Color-coded Feedback**:
  - Green: Correct characters
  - Red: Incorrect characters
  - Blue: Current position with cursor
  - Gray: Remaining text

### Accessibility Features
- **Focus Visible Styles**: Clear outlines for keyboard navigation
- **ARIA Labels**: Semantic HTML for screen readers
- **Reduced Motion Support**: Respects `prefers-reduced-motion` setting
- **Keyboard Shortcuts**:
  - Alt+1: Easy difficulty
  - Alt+2: Medium difficulty
  - Alt+3: Hard difficulty
  - Escape: Exit test

### Mobile Features
- **Touch Friendly**: Large buttons and optimal spacing
- **Viewport Optimization**: Proper meta tags for mobile devices
- **Responsive Grid**: Auto-adjusting layout for all screen sizes
- **Font Scaling**: Text sizes adjust for readability on small screens

## 🎮 How to Use

### Starting a Test
1. Select your desired **Difficulty Level** (Easy, Medium, Hard)
2. Choose a **Test Mode** (Timed or Full Passage)
3. Click "Start Typing Test" or press any key
4. The passage will appear - start typing!

### During the Test
- Type the passage character by character
- Watch your WPM and accuracy update in real-time
- Correct characters appear in green
- Mistakes appear in red with highlighting
- Current position is highlighted with a blue indicator
- For timed mode, test automatically ends after 60 seconds
- For passage mode, test ends when you complete the text

### After the Test
- View your final results: WPM, Accuracy, and Characters Typed
- Get personalized feedback based on your performance
- If you achieved a new personal record, a special celebration message appears!
- Click "Try Again" to immediately start a new test
- Click "Change Settings" to adjust difficulty or mode before the next test

## 📊 Performance Metrics

- **WPM (Words Per Minute)**: Calculated as (characters typed ÷ 5) ÷ minutes
- **Accuracy**: Percentage of correct characters out of total typed
- **Correct Characters**: Total number of correctly typed characters
- **Time**: Real-time elapsed time during test

## 🎨 Design Features

### Color Scheme
- **Primary**: Indigo (#6366f1)
- **Accent**: Pink (#ec4899)
- **Success**: Green (#10b981)
- **Error**: Red (#ef4444)
- **Background**: Dark (#0f0f0f to #1a1a2e)

### Typography
- **Font Family**: System fonts (Apple System Font, Segoe UI, Roboto)
- **Font Smoothing**: Anti-aliased for crisp text
- **Responsive Sizing**: Scales from 12px to 36px based on screen size

### Spacing System
- **XS**: 0.5rem (8px)
- **SM**: 1rem (16px)
- **MD**: 1.5rem (24px)
- **LG**: 2rem (32px)
- **XL**: 3rem (48px)

## 💾 Data Storage

The application uses:
- **localStorage**: Saves your personal best WPM
- **data.json**: Contains 30 passages across 3 difficulty levels
- **Client-side**: All processing happens in your browser

## 📱 Responsive Breakpoints

| Device | Width | Adjustments |
|--------|-------|-------------|
| Desktop | 1024px+ | Full spacing, large fonts |
| Tablet | 768px - 1024px | Reduced padding, medium fonts |
| Mobile | 480px - 768px | Single column, touch-optimized |
| Small Phone | < 480px | Minimal spacing, 100% width buttons |

## 🔧 Technical Details

### Built With
- **HTML5**: Semantic markup with ARIA labels
- **CSS3**: Modern features (CSS variables, Grid, Flexbox, animations)
- **JavaScript (ES6+)**: Class-based architecture with proper state management

### Browser Support
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

### Performance
- Pure JavaScript (no frameworks)
- Minimal dependencies
- ~50KB total (gzipped)
- Smooth 60fps animations

## 🚀 Features Roadmap

Future enhancements could include:
- User accounts and progress tracking
- Multiplayer competition mode
- Custom passage support
- Sound effects and achievements
- Analytics and performance history
- Different languages support
- Theme customization

## 📝 Passages

The application includes passages ranging from:
- **Easy**: Simple, everyday language (~150 characters)
- **Medium**: Intermediate complexity with varied vocabulary (~250 characters)
- **Hard**: Complex topics, technical language, philosophical concepts (~350+ characters)

All passages are copyright-free and carefully selected for typing practice.

## 🎯 Tips for Better Typing

1. **Focus on Accuracy First**: Speed naturally increases with practice
2. **Maintain Posture**: Sit up straight for better ergonomics
3. **Use All Fingers**: Proper typing technique improves speed
4. **Take Breaks**: Practice in short sessions to avoid fatigue
5. **Vary Difficulty**: Start with Easy, progress to Hard as you improve
6. **Regular Practice**: Consistency beats occasional long sessions

## 📞 Support

For issues or suggestions:
1. Check the console (F12) for any error messages
2. Ensure JavaScript is enabled in your browser
3. Clear your browser cache if experiencing loading issues
4. Try a different browser if problems persist

## 📄 License

This typing test application is provided as-is for personal use.

---

**Happy Typing!** 🎉

Start your typing journey today and watch your speed improve with consistent practice.
