
# Quick KB Project Setup

Follow the steps below to set up and run the Laravel 12 project.

---

## 🚀 **Installation Steps**

### **1. Install Dependencies**
Run the following command to install all required dependencies:

```sh
composer install
```

---

### **2. Build Frontend Assets**
If you are using Vite, run:

```sh
composer run dev
```

Or, if using npm, run:

```sh
npm run build
```

---

### **3. Generate Application Key**
Run this command to generate the application encryption key:

```sh
php artisan key:generate
```

---

### **4. Run Database Migrations**
Apply database migrations with:

```sh
php artisan migrate --force
```

---

### **5. Import Data into TNTSearch**
If you are using **Laravel Scout with TNTSearch**, import your models:

```sh
php artisan scout:import "App\Models\Article"
```

---

### **6. Set Required Permissions**
Make sure the following directories have the correct permissions:

```sh
chmod 777 -R storage/search
chmod 777 -R database/database.sqlite
chmod 777 -R bootstrap/cache
```

✅ **That's it! Your Laravel project is now set up and ready to go!** 🎉  
To start the application, use:

```sh
php artisan serve
```

---

## 🛠 **Troubleshooting**
If you face any permission issues, try running the commands with `sudo`:

```sh
sudo chmod 777 -R storage/search database/database.sqlite bootstrap/cache
```

## 📦 Deployment


### One-Click Deploy Options

| Platform | Deploy Button |
|----------|--------------|
| Digital Ocean | [![Deploy to DigitalOcean](https://www.deploytodo.com/do-btn-blue.svg)](https://cloud.digitalocean.com/apps/new?repo=https://github.com/cs-quicklabs/quick-kb/tree/development&spec=.do/deploy.template.yaml) |
|Deploy to Render| [![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy?repo=https://github.com/cs-quicklabs/quick-kb/tree/feature/quick-kb)|




For any issues, feel free to check the **Laravel documentation** or raise an issue in this repository.

---

🚀 **Happy Coding!** 🎯
```

This `README.md` covers all setup steps clearly and ensures everything is configured properly. Let me know if you want any modifications! 🚀