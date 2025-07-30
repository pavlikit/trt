# 🧮 Treat Optimizer CLI (Symfony + Docker)

A Symfony Console application that calculates the **maximum treat value** using recursive dynamic programming with memoization — all containerized with **PHP 8.3** and **Docker Compose**.

---

## 🚀 Usage (via Docker Compose)

> ✅ No need to install PHP or Composer locally — everything runs in Docker.

### 🔧 Build the container

```bash
docker-compose build

docker-compose run --rm symfony php bin/console app:optimize-treats "1,2,3,4"

🧮 Run the optimizer
Pass a comma-separated list of treat values:

docker-compose run --rm symfony php bin/console app:optimize-treats "1,2,3,4"

🧪 Run tests with Pest

docker-compose run --rm symfony vendor/bin/pest

📁 Project Highlights
Symfony 7.3 Console App

PHP 8.3 (CLI)

Recursive DP with swappable memoization interface

PestPHP for tests

No external services or database required
