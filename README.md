# 🧘‍♂️ FITNESS FUSION

> A personalized health and fitness web application built for India — delivering state-wise diet plans, age-based exercise routines, and real-time health metrics tracking.

![image](https://github.com/user-attachments/assets/0d805b19-7b37-45fb-be95-0f41af7424fd)

---

## ✨ Features

- **State-Wise Diet Plans** — Veg & Non-Veg meal plans tailored to all 37 Indian States & UTs
- **Age-Based Exercise Routines** — Personalized workouts for 3 age groups (15–25, 26–50, 51–75)
- **Health Metrics Dashboard** — BMI, Body Fat %, BMR, Weight History tracking
- **Detailed Health Report** — 10+ derived health metrics from your measurements
- **Secure Authentication** — Bcrypt-hashed passwords, session fixation protection
- **Responsive Design** — Works on desktop, tablet, and mobile

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.1+ |
| **Frontend** | HTML5, CSS3, JavaScript |
| **Database** | MySQL (MariaDB) |
| **Server** | Apache (XAMPP) |
| **Deployment** | Docker (optional) |

---

## 🚀 Setup Instructions (Step by Step)

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) installed (includes Apache, MySQL, PHP, phpMyAdmin)

### Step 1: Install XAMPP

Download and install XAMPP from https://www.apachefriends.org/  
Default install path: `C:\xampp`

### Step 2: Copy the Project

Copy the entire `FITNESS-FUSION` folder into your XAMPP web root:

```
C:\xampp\htdocs\FITNESS-FUSION
```

### Step 3: Start XAMPP Services

1. Open **XAMPP Control Panel**
2. Click **Start** next to **Apache**
3. Click **Start** next to **MySQL**
4. Both should turn green with port numbers showing

### Step 4: Create the Database

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click the **SQL** tab at the top
3. Open the file `database/schema.sql` from the project in any text editor
4. Copy the entire contents (`Ctrl+A` → `Ctrl+C`)
5. Paste it into the SQL text box in phpMyAdmin (`Ctrl+V`)
6. Click **Go**

This creates the `fitness_fusion_v2` database with 3 tables:
- `users` — stores user accounts
- `metrics` — stores health snapshots (BMI, body fat, BMR, etc.)
- `weight_history` — stores daily weight logs for trend tracking

### Step 5: Verify Database Port

Open `includes/config.php` and check the local development DB port:

```php
define('DB_PORT', getenv('DB_PORT') ?: '3307');
```

**If your MySQL runs on the default port `3306`**, change `3307` to `3306`:

```php
define('DB_PORT', getenv('DB_PORT') ?: '3306');
```

> **How to check your port:** Look at the XAMPP Control Panel — the port number is shown next to MySQL (e.g., `3306` or `3307`).

### Step 6: Open the Website

Go to: **http://localhost/FITNESS-FUSION/**

You should see the landing page. Click **Get Started** to register an account.

---

## ⚠️ Troubleshooting

### "localhost/phpmyadmin" shows 404 error

**Cause:** Another web server (like IIS) is using port 80, so Apache had to use a different port.

**Fix:** Check your XAMPP Control Panel for Apache's port (e.g., `8080`), then use:
```
http://localhost:8080/phpmyadmin
http://localhost:8080/FITNESS-FUSION/
```

### "Service temporarily unavailable" error

**Cause:** Database connection failed — wrong port or MySQL not running.

**Fix:**
1. Make sure MySQL is running in XAMPP Control Panel
2. Check the port in XAMPP matches the port in `includes/config.php`
3. Make sure you ran `schema.sql` in phpMyAdmin (Step 4)

### Apache won't start

**Cause:** Port 80 is occupied by another program (Skype, IIS, etc.)

**Fix:** In XAMPP, click **Config** next to Apache → open `httpd.conf` → change `Listen 80` to `Listen 8080`. Then use `localhost:8080` in your browser.

---

## 📁 Project Structure

```
FITNESS-FUSION/
├── index.html              # Landing page
├── login.html              # Login & registration UI
├── login.php               # Auth handler (sign in / sign up)
├── logout.php              # Session destroy & redirect
├── veg_diet.php            # Vegetarian state-wise diet plans (37 states)
├── mixed_diet.php          # Non-veg state-wise diet plans (37 states)
├── logo.png                # Brand logo
├── Dockerfile              # Docker deployment config
│
├── includes/
│   ├── config.php          # App config (DB, URLs, sessions, env detection)
│   ├── db.php              # Singleton PDO database connection
│   └── auth.php            # Authentication guard & session management
│
├── database/
│   └── schema.sql          # MySQL schema (run this in phpMyAdmin)
│
├── dashboard/
│   └── dashboard.php       # Main dashboard (metrics cards, weight history)
│
├── metrics/
│   ├── save_results.php    # Metrics input form + calculation + DB save
│   └── results.php         # Detailed health report page
│
├── diet/
│   ├── plan.php            # Diet plan router (auto-selects veg/nonveg)
│   ├── options.php         # Diet goal selector (loss/gain/muscle)
│   ├── wt_loss.php         # Weight loss meal plan
│   ├── wt_gain.php         # Weight gain meal plan
│   └── ms_gain.php         # Muscle gain meal plan
│
└── exercise/
    ├── plan.php            # Age-based personalized exercise plans
    └── exercise.php        # General exercise plans
```

---

## 📊 Database Schema

```
users (id, name, email, password, age, gender, state, diet_type, created_at, updated_at)
  │
  ├──< metrics (id, user_id, height, weight, bmi, body_fat, calories, created_at)
  │
  └──< weight_history (id, user_id, weight, recorded_at)
```

---

## 👤 User Flow

1. **Register** on the login page (name, email, password)
2. **Login** with email and password
3. **Enter Metrics** — height, weight, age, gender, state, diet preference
4. **View Dashboard** — BMI, body fat, BMR, weight history
5. **Health Report** — detailed breakdown of all computed metrics
6. **Diet Plan** — state-specific veg/non-veg meal plans for 3 goals
7. **Exercise Plan** — age-appropriate workout routines for 3 goals

---

## 📝 License

This project is for educational purposes.

---

## ☁️ AWS Cloud Deployment Guide

This project is designed to be deployed on AWS, covering all major cloud service models:

| Cloud Concept | AWS Service | Role in Fitness Fusion |
|--------------|-------------|----------------------|
| **IaaS** | EC2 | Virtual server running Apache + PHP |
| **PaaS** | Elastic Beanstalk | Auto-deploys, scales, and monitors the PHP app |
| **DBaaS** | RDS (MySQL) | Managed database — no manual install/backups |
| **Storage as a Service** | S3 | Stores static assets (logo, images) via `ASSET_URL` |
| **Security as a Service** | CloudFront + AWS WAF + ACM + IAM | Edge protection (SQLi/XSS managed rules), TLS, least-privilege access |

### AWS Architecture

```
User → [HTTPS] → Elastic Beanstalk (PaaS)
                        │
                        ├── EC2 Instance (IaaS) — runs Apache + PHP
                        │
                        ├── AWS RDS MySQL (DBaaS) — managed database
                        │
                        └── AWS S3 Bucket (Storage) — logo & static assets
                        
Security: CloudFront + WAF + ACM + IAM Roles + Security Groups
```

### Step 1: Create RDS Database (DBaaS)

1. AWS Console → **RDS** → **Create Database**
2. Engine: **MySQL** | Template: **Free Tier**
3. DB identifier: `fitness-fusion-db`
4. Master username: `ff_admin` | Set a strong password
5. Public access: **No**
6. Click **Create database**
7. Note the **Endpoint** (e.g., `fitness-fusion-db.abc123.us-east-1.rds.amazonaws.com`)
8. Connect and import schema:
   ```bash
   mysql -h <RDS-ENDPOINT> -u ff_admin -p fitness_fusion_v2 < database/schema.sql
   ```

### Step 2: Create S3 Bucket (Storage as a Service)

1. AWS Console → **S3** → **Create Bucket**
2. Bucket name: `fitness-fusion-assets`
3. Uncheck "Block all public access" (for static assets)
4. Upload `logo.png` to the bucket
5. Set the object to **public read**
6. Your asset URL will be: `https://fitness-fusion-assets.s3.amazonaws.com`

### Step 3: Deploy with Elastic Beanstalk (PaaS + IaaS)

1. AWS Console → **Elastic Beanstalk** → **Create Application**
2. Application name: `fitness-fusion`
3. Platform: **Docker** (single container) or **PHP 8.1**
4. Upload: Zip the project (includes Dockerfile) and upload
5. Under **Configuration → Software**, set environment variables:
   ```
   DB_HOST       = <your-rds-endpoint>
   DB_PORT       = 3306
   DB_NAME       = fitness_fusion_v2
   DB_USER       = ff_admin
   DB_PASS       = <your-rds-password>
   S3_ASSET_URL  = https://fitness-fusion-assets.s3.amazonaws.com
   APP_ENV       = production
   ```
6. Health check path: `/index.php`
7. Optionally add `.ebextensions`/`.platform/hooks` to enable Apache rewrite if you add pretty URLs.
8. Click **Create environment**

### Step 4: Configure Security (Security as a Service)

1. **Security Groups:**
   - Web SG: Allow ports 80, 443 from `0.0.0.0/0`
   - DB SG: Allow port 3306 **only from Web SG** (not public)
2. **IAM Role:** Attach `AmazonS3ReadOnlyAccess` to the Beanstalk EC2 instance role
3. **ACM (SSL):** Request a free SSL certificate → attach to the Beanstalk load balancer
4. **App-level security (already built in):**
   - Passwords hashed with **bcrypt** (`password_hash()`)
   - Session fixation protection via `session_regenerate_id()`
   - HTTP-only, SameSite session cookies; Secure flag in production
   - CSRF protection on login/signup forms
   - No credentials in code — all read from environment variables

5. **Secrets & IAM:**
   - Store DB creds in **SSM Parameter Store** or **Secrets Manager** and surface them as env vars.
   - Attach an **instance profile**/role with least-privilege S3 read and SSM/Secrets access.

### Cloud Deliverable Checklist (for reviews)

- **IaaS:** Documented EC2 option running the Docker image with env vars pointing to RDS and S3.
- **PaaS:** Elastic Beanstalk single-Docker deploy; health checks and env vars configured.
- **DBaaS:** RDS MySQL with schema imported from `database/schema.sql`.
- **Storage-as-a-Service:** S3 bucket for `logo.png` and other assets; served via `ASSET_URL` (optionally behind CloudFront).
- **Security-as-a-Service:** CloudFront + WAF managed rules + ACM TLS; IAM roles and Security Groups restricting DB to app tier only.
- **Verification:**
  - Login/register works against RDS
  - Metrics save in `metrics/save_results.php`
  - Assets load from S3/CloudFront
  - HTTPS enforced via CloudFront/ACM
  - WAF logs visible for requests

### How the Code Handles Local vs Production

The `includes/config.php` automatically detects the environment:

| Setting | Local (XAMPP) | Production (AWS) |
|---------|--------------|-----------------|
| DB credentials | `root` / no password | Read from `DB_HOST`, `DB_USER`, `DB_PASS` env vars |
| Asset URL | `ASSET_URL = BASE_URL` (local files) | `ASSET_URL = S3_ASSET_URL` env var (S3 bucket) |
| Error display | Shown in browser | Logged to file, hidden from users |
| Session cookies | Standard | HTTPS-only, secure flag enabled |

**No code changes needed between local and AWS deployment.**
