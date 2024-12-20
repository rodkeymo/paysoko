# Laravel Full-Stack Application with Cart and Order Management

This is a Laravel-based full-stack application that includes cart functionality, order management, and a basic user interface with Blade templates. It uses Docker for easy setup and deployment and includes CI/CD automation with GitHub Actions.


## **Features**

- Add products to a cart (data fetched from a third-party API).
- Remove items from the cart.
- Place an order based on the cart items.
- View past orders.
- Backend powered by Laravel.
- Dockerized for easy local setup and deployment.
- CI/CD pipeline with GitHub Actions for testing and deploying.



## **Requirements**

Before running or deploying the application, ensure you have the following installed:

- Docker and Docker Compose
- Git
- PHP 8.2 (for running locally without Docker)
- Composer (PHP dependency manager)
- Node.js and npm (if you want to modify CSS/JS assets)
- DigitalOcean account (or your preferred hosting platform)



## **1. How to Run the Application Locally**

### **Steps:**

1. **Clone the Repository**
   ```bash
   git clone https://github.com/rodkeymo/paysoko.git
   cd paysoko
   ```

2. **Set Up Environment Variables**
   Copy the example `.env` file and update it if necessary:
   ```bash
   cp .env.example .env
   ```

3. **Start Docker Containers**
   Build and start the Docker containers using `docker-compose`:
   ```bash
   docker-compose up -d
   ```

4. **Run Composer Install**
   Install the required PHP dependencies:
   ```bash
   docker exec paysoko composer install
   ```

5. **Generate Application Key**
   Run this command to generate a new key for your application:
   ```bash
   docker exec paysoko php artisan key:generate
   ```

6. **Run Database Migrations**
   Apply database migrations to set up the schema:
   ```bash
   docker exec paysoko php artisan migrate
   ```

7. **Access the Application**
   Visit `http://localhost:8000` in your browser. You should see the application running.



## **2. Steps to Deploy the Application with CI/CD Scripts**

This project is set up with GitHub Actions for automated testing and deployment. Follow these steps to deploy the application:

### **Set Up Your Server**
1. Log in to your DigitalOcean account and create a new droplet with Docker installed. Alternatively, follow [this guide](https://www.digitalocean.com/docs/docker/) to install Docker on your server.

2. SSH into your server:
   ```bash
   ssh root@your-server-ip
   ```

3. Set up your project directory:
   ```bash
   mkdir -p /var/www/paysoko
   ```

### **Configure GitHub Secrets**
1. Add the following secrets to your GitHub repository:
   - `SSH_HOST`: The IP address or hostname of your server.
   - `SSH_USERNAME`: The username to SSH into your server (e.g., `root`).
   - `SSH_PRIVATE_KEY`: The private SSH key for authentication.

   To generate an SSH key:
   ```bash
   ssh-keygen -t rsa -b 4096 -C "your-email@example.com"
   ```

   Add the public key (`id_rsa.pub`) to the `~/.ssh/authorized_keys` file on your server.

### **Deploying via CI/CD**
1. Push your code to the `main` branch:
   ```bash
   git add .
   git commit -m "Initial deployment"
   git push origin main
   ```

2. GitHub Actions will automatically:
   - Run tests.
   - Deploy your application to your server via SSH.

3. Check the deployment logs in the "Actions" tab of your GitHub repository to ensure the deployment succeeded.



## **Local Development Commands**

Here are some useful commands for local development:

- **Run Tests**
  ```bash
  docker exec paysoko php artisan test
  ```

- **Access the Laravel Container**
  ```bash
  docker exec -it paysoko bash
  ```

- **Rebuild Docker Containers**
  If you make changes to `Dockerfile` or `docker-compose.yml`, rebuild the containers:
  ```bash
  docker-compose up -d --build
  ```

- **Stop and Remove Containers**
  ```bash
  docker-compose down
  ```



## **Project Architecture**

### **Backend**
- Laravel (PHP framework) for API and Blade templates.
- MySQL for database storage.
- Redis for cart functionality.

### **Frontend**
- Blade templates for server-side rendering.
- Bootstrap for styling.



## **Troubleshooting**

### **Database Connection Issues**
- Ensure the database credentials in `.env` match those in `docker-compose.yml`.

### **Laravel Permissions**
- If you encounter permission issues, ensure `storage` and `bootstrap/cache` directories are writable:
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

### **Docker Issues**
- Restart Docker if containers fail to start:
  ```bash
  docker-compose down && docker-compose up -d
  ```


