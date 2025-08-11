# 🎓 Sentiment Analysis Engineering

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1.svg)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3.svg)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen.svg)](https://github.com/landogz/SentimentAnalysisSystem_Engineering)

> A modern, professional Laravel-based system for collecting and analyzing student feedback with advanced sentiment analysis capabilities. Built with a beautiful autumn-inspired design and comprehensive reporting features.

## ✨ Features

### 🧠 Advanced Sentiment Analysis
- **Database-Driven Words**: 209 pre-seeded sentiment words with scoring system
- **Multi-language Support**: English (96 words) and Tagalog (113 words) analysis
- **Advanced Scoring**: -5.0 to 5.0 scoring system with detailed breakdown
- **Rating Calculation**: Automatic 1-5 star rating conversion
- **Translation Support**: Google Translate API integration
- **Real-time Testing**: Built-in analysis testing with custom text

### 📊 Comprehensive Dashboard
- **Interactive Charts**: Sentiment analysis pie charts and monthly trends
- **Statistics Cards**: Real-time KPIs with autumn-themed design
- **Equal Height Layout**: Responsive flexbox design
- **Top Performers**: Teacher and subject rankings
- **Recent Activity**: Latest surveys and activity summary

### 🎨 Modern Design System
- **Autumn Color Palette**: Professional orange, green, and coral theme
- **Responsive Design**: Mobile-first approach with touch optimization
- **Professional UI**: Modern cards, gradients, and animations
- **Google Fonts**: Poppins typography for clean readability
- **SweetAlert Integration**: Professional notifications and confirmations

### 📈 Advanced Reporting
- **Multi-Format Export**: PDF, Excel, and CSV capabilities
- **Filtered Reports**: By teacher, subject, and date range
- **Interactive Charts**: Sentiment distribution and rating analysis
- **Real-time Statistics**: Dynamic data updates with AJAX
- **Professional Logout**: Enhanced SweetAlert logout system

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/landogz/SentimentAnalysisSystem_Engineering.git
   cd SentimentAnalysisSystem_Engineering
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   # Update .env with your database credentials
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage setup**
   ```bash
   php artisan storage:link
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

### Sample Data
Access `/add-sample-data` to populate the system with sample teachers, subjects, and surveys for testing.

## 🎨 Design Features

### Autumn Color Palette
```css
--dark-gray: #BF3100;      /* Deep Orange */
--light-green: #8EA604;    /* Olive Green */
--coral-pink: #FF4E00;     /* Bright Orange-Red */
--golden-orange: #F5BB00;  /* Golden Yellow */
--light-blue: #EC9F05;     /* Golden Orange */
```

### Professional UI Components
- **Enhanced Cards**: Rounded corners with subtle shadows
- **Gradient Backgrounds**: Autumn-themed gradients throughout
- **Smooth Animations**: CSS transitions and hover effects
- **Mobile-First**: Responsive design optimized for all devices
- **Touch-Friendly**: Enhanced touch targets for mobile users

## 📱 Mobile Optimizations

- **Responsive Layout**: Optimized for all screen sizes
- **Touch-Friendly Interface**: 44px minimum touch targets
- **Smooth Scrolling**: iOS-optimized scrolling
- **Mobile Sidebar**: Full-screen overlay navigation
- **Viewport Optimization**: Prevents unwanted zoom

## 🔧 Technical Stack

### Backend
- **Laravel 10.x**: Modern PHP framework
- **PHP 8.1+**: Latest PHP features
- **MySQL 8.0+**: Reliable database
- **Eloquent ORM**: Database abstraction

### Frontend
- **Bootstrap 5.3**: Responsive CSS framework
- **jQuery 3.6**: JavaScript library
- **Chart.js 4.x**: Interactive charts
- **SweetAlert2 11.x**: Beautiful alerts
- **Font Awesome 6.x**: Icon library
- **DataTables 1.13+**: Advanced tables

### Development Tools
- **Composer**: PHP dependency management
- **Laravel Mix**: Asset compilation
- **PHPUnit**: Testing framework
- **Git**: Version control

## 📊 Dashboard Overview

The system provides a comprehensive dashboard with:

- **Statistics Cards**: Total surveys, average rating, sentiment distribution
- **Interactive Charts**: Sentiment analysis pie chart and monthly trends
- **Top Performers**: Best-rated teachers and subjects
- **Recent Activity**: Latest surveys and system activity
- **Quick Actions**: Easy access to key features

## 🔒 Security Features

- **CSRF Protection**: Laravel built-in CSRF tokens
- **Session Management**: 30-minute timeout with notifications
- **Input Validation**: Server-side validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping
- **Authentication Middleware**: Secure route protection

## 📈 Performance Features

- **AJAX-Powered**: No page reloads for better UX
- **Lazy Loading**: Progressive data loading
- **Asset Optimization**: Minified CSS/JS for production
- **Database Indexing**: Optimized queries
- **Caching Ready**: Laravel cache implementation

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 📋 API Endpoints

### Sentiment Analysis
- `GET /sentiment-words` - List words with filters
- `POST /sentiment-words` - Add new word
- `PUT /sentiment-words/{id}` - Update word
- `DELETE /sentiment-words/{id}` - Delete word
- `POST /sentiment-words/test-analysis` - Test analysis
- `GET /sentiment-words/statistics` - Get statistics

### Reports
- `GET /reports` - Main reports page
- `POST /reports/export/csv` - Export CSV
- `POST /reports/export/pdf` - Export PDF
- `POST /reports/export/excel` - Export Excel

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use meaningful commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Contact the development team
- Check the documentation

### Common Issues
- **Session Timeout**: System automatically logs out after 30 minutes
- **Export Issues**: Ensure proper file permissions
- **Mobile Display**: Use responsive design features
- **Translation Issues**: Configure Google Translate API key

## 🎯 Roadmap

- [ ] Advanced analytics dashboard
- [ ] Real-time notifications
- [ ] API documentation
- [ ] Mobile app development
- [ ] Multi-tenant support
- [ ] Advanced reporting features

---

<div align="center">

**🎓 Sentiment Analysis Engineering** - Empowering educational institutions with modern feedback collection and analysis tools.

*Built with ❤️ using Laravel, Bootstrap, and modern web technologies*

[![GitHub stars](https://img.shields.io/github/stars/landogz/SentimentAnalysisSystem_Engineering?style=social)](https://github.com/landogz/SentimentAnalysisSystem_Engineering/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/landogz/SentimentAnalysisSystem_Engineering?style=social)](https://github.com/landogz/SentimentAnalysisSystem_Engineering/network)
[![GitHub issues](https://img.shields.io/github/issues/landogz/SentimentAnalysisSystem_Engineering)](https://github.com/landogz/SentimentAnalysisSystem_Engineering/issues)

</div>