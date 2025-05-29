# 📊 MetricsWave

[![License: MIT with Commons Clause](https://img.shields.io/badge/License-MIT%20with%20Commons%20Clause-yellow.svg)](LICENSE.md)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)](https://laravel.com)
[![React](https://img.shields.io/badge/React-18.x-61DAFB?logo=react)](https://reactjs.org)

**MetricsWave** is an open-source analytics and metrics tracking platform that helps teams monitor, visualize, and get notified about important business metrics in real-time.

## 🚀 Features

### 📈 **Real-time Metrics Tracking**
- Track custom metrics with parameters and tags
- Record events with timestamps and metadata
- Support for incremental counters and custom scoring
- Historical data retention and aggregation

### 📊 **Beautiful Dashboards**
- Create custom dashboards with multiple visualizations
- Share public dashboards with stakeholders
- Real-time data updates and interactive charts
- Mobile-responsive design for on-the-go monitoring

### 🔔 **Smart Notifications & Triggers**
- Set up intelligent triggers based on metric thresholds
- Multi-channel notifications (Telegram, Email, etc.)
- Custom trigger conditions and parameters
- Team-based notification management

### 👥 **Team Collaboration**
- Multi-team support with role-based access control
- Share dashboards and metrics across teams
- Collaborative metric management
- User impersonation for support scenarios

### 🔗 **Flexible Integrations**
- REST API for easy integration with any application
- Support for various data sources and services
- OAuth integration with popular platforms
- Webhook support for real-time data ingestion

### 📱 **Developer-Friendly**
- Simple HTTP API for metric recording
- Comprehensive documentation and examples
- Open-source with active community
- Built with modern technologies (Laravel + React)

## 🎯 Use Cases

### **Product Analytics**
- Track user engagement, conversion rates, and feature adoption
- Monitor performance metrics and API response times
- Analyze user behavior patterns and trends

### **Business Intelligence**
- Monitor sales metrics, revenue, and growth indicators
- Track marketing campaign performance and ROI
- Create executive dashboards for strategic decision-making

### **Infrastructure Monitoring**
- Track server performance, uptime, and resource usage
- Monitor application errors and performance bottlenecks
- Set up alerts for critical system events

### **Customer Success**
- Monitor customer health scores and satisfaction metrics
- Track support ticket resolution times and SLA compliance
- Analyze customer retention and churn patterns

### **E-commerce Analytics**
- Track order volumes, conversion rates, and cart abandonment
- Monitor inventory levels and product performance
- Analyze customer lifetime value and purchasing patterns

## 🛠️ Technical Documentation

### Prerequisites

- **PHP**: 8.1 or higher
- **Node.js**: 16.x or higher
- **Docker & Docker Compose**: Latest version
- **Git**: For version control

### 🚀 Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-org/metricswave.git
   cd metricswave/backend
   ```

2. **Install PHP dependencies**
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php82-composer:latest \
       composer install --ignore-platform-reqs
   ```

3. **Start the development environment**
   ```bash
   ./vendor/bin/sail up -d
   ```

4. **Set up the application**
   ```bash
   # Copy environment file
   ./vendor/bin/sail artisan sail:publish
   cp .env.example .env
   
   # Generate application key
   ./vendor/bin/sail artisan key:generate
   
   # Run database migrations
   ./vendor/bin/sail artisan migrate
   
   # Install frontend dependencies
   ./vendor/bin/sail npm install
   
   # Build frontend assets
   ./vendor/bin/sail npm run dev
   ```

5. **Access the application**
   - Frontend: http://localhost
   - API: http://localhost/api
   - Admin Panel: http://localhost/admin

### 🐳 Docker Development

The project uses [Laravel Sail](https://laravel.com/docs/10.x/sail) for Docker-based development:

```bash
# Start all services
./vendor/bin/sail up -d

# View logs
./vendor/bin/sail logs

# Access Laravel container
./vendor/bin/sail shell

# Run Artisan commands
./vendor/bin/sail artisan migrate

# Run tests
./vendor/bin/sail pest

# Stop all services
./vendor/bin/sail down
```

### 🗄️ Database Setup

1. **Run migrations**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

2. **Seed the database (optional)**
   ```bash
   ./vendor/bin/sail artisan db:seed
   ```

3. **Create a test user**
   ```bash
   ./vendor/bin/sail artisan tinker
   # In tinker:
   User::factory()->create(['email' => 'admin@example.com']);
   ```

### 🎨 Frontend Development

The frontend is built with React and uses Vite for development:

```bash
# Development server with hot reload
./vendor/bin/sail npm run dev

# Production build
./vendor/bin/sail npm run build

# Install new packages
./vendor/bin/sail npm install <package-name>
```

### 🔧 Configuration

#### Environment Variables
Key configuration options in `.env`:

```env
# Application
APP_NAME="MetricsWave"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=metricswave
DB_USERNAME=sail
DB_PASSWORD=password

# Redis (for caching and queues)
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Notifications
TELEGRAM_BOT_TOKEN=your_telegram_bot_token
MAIL_MAILER=smtp
```

#### Queue Configuration
For background job processing:

```bash
# Start queue worker
./vendor/bin/sail artisan queue:work

# Process failed jobs
./vendor/bin/sail artisan queue:retry all
```

### 🧪 Testing

```bash
# Run all tests
./vendor/bin/sail pest

# Run specific test suite
./vendor/bin/sail pest --group=metrics

# Run with coverage
./vendor/bin/sail pest --coverage
```

## 🤝 Contributing

We welcome contributions from the community! Here's how you can contribute:

### 🐛 Reporting Issues

1. Check existing issues to avoid duplicates
2. Use the issue template and provide detailed information
3. Include steps to reproduce the problem
4. Add relevant labels and assign to appropriate milestone

### 💡 Feature Requests

1. Open a new issue with the "enhancement" label
2. Describe the feature and its use case
3. Discuss the implementation approach
4. Wait for maintainer approval before starting development

### 🔧 Code Contributions

1. **Fork the repository**
   ```bash
   git clone https://github.com/your-username/metricswave.git
   cd metricswave/backend
   ```

2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Set up development environment**
   ```bash
   # Follow the Quick Start guide above
   ./vendor/bin/sail up -d
   ```

4. **Make your changes**
   - Follow PSR-12 coding standards for PHP
   - Use ESLint configuration for JavaScript/React
   - Write tests for new functionality
   - Update documentation as needed

5. **Run quality checks**
   ```bash
   # PHP code style
   ./vendor/bin/sail composer pint
   
   # PHP static analysis
   ./vendor/bin/sail composer phpstan
   
   # Run tests
   ./vendor/bin/sail pest
   
   # Frontend linting
   ./vendor/bin/sail npm run lint
   ```

6. **Commit your changes**
   ```bash
   git add .
   git commit -m "feat: add new metrics visualization component"
   ```

7. **Push and create PR**
   ```bash
   git push origin feature/your-feature-name
   ```
   Then create a Pull Request on GitHub.

### 📋 Development Guidelines

#### Code Style
- **PHP**: Follow PSR-12 standards, use Laravel conventions
- **JavaScript/React**: Use ESLint and Prettier configurations
- **Database**: Use descriptive migration names and proper indexing
- **API**: Follow RESTful conventions and proper HTTP status codes

#### Commit Messages
Use conventional commits format:
- `feat:` for new features
- `fix:` for bug fixes
- `docs:` for documentation changes
- `style:` for code style changes
- `refactor:` for code refactoring
- `test:` for adding or updating tests

#### Pull Request Process
1. Ensure all tests pass and code follows style guidelines
2. Update documentation for any new features
3. Add or update tests for your changes
4. Request review from maintainers
5. Address feedback and iterate until approved

### 🏗️ Project Structure

```
backend/
├── app/                    # Laravel application code
├── src/                    # Domain-specific modules
│   ├── Metrics/           # Core metrics functionality
│   ├── Teams/             # Team management
│   ├── Users/             # User management
│   ├── Channels/          # Notification channels
│   └── Pages/             # Statamic pages
├── resources/             # Frontend React code
├── routes/                # API and web routes
├── database/              # Migrations and seeders
├── tests/                 # Test suites
└── config/                # Configuration files
```

## 📜 License

This project is licensed under the MIT License with Commons Clause - see the [LICENSE.md](LICENSE.md) file for details.

The Commons Clause means you can use, modify, and distribute the software freely, but you cannot sell it as a hosted service or commercial product.

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com) and [React](https://reactjs.org)
- Powered by [Statamic](https://statamic.com) for content management
- Uses [Filament](https://filamentphp.com) for admin interface
- Notifications via [Laravel Notification Channels](https://laravel-notification-channels.com)

## 📞 Support

- 📚 **Documentation**: [Coming Soon]
- 💬 **Community**: [GitHub Discussions](https://github.com/your-org/metricswave/discussions)
- 🐛 **Issues**: [GitHub Issues](https://github.com/your-org/metricswave/issues)
- 📧 **Email**: support@metricswave.com

---

<p align="center">
  <strong>Made with ❤️ by the MetricsWave Team</strong>
</p>
