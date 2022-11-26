<p align="center"><a href="https://lcandesign.com" target="_blank"><img src="https://cdn.document360.io/88b1b912-ebe6-4677-9cf4-27af4e66c459/Images/Setting/Logo-EPAYCO---RGB-1.png" width="400"></a></p>

# ePayco API Rest and Soap Service

Tech test from ePayco for backend developers.

**API para simular una billetera virtual**

## Running at project step by step 🚀️

### 1. Clone the project

```bash
git clone git@bitbucket.org:lcandesignteam/epaycoapi.git
```

### 2. Create `.env` files

Copy `.env.example` to a new `.env` file.

### 3. Run Docker

In the root directory execute:

```bash
docker-compose up -d
```

### 4. Check environment

execute

```bash
docker-compose ps
```

checking that all containers are up.

### 5. Create JWT_SECRET key
Enter to console execute:

```bash
docker-compose run --rm epayco /bin/bash
```

Positioned on the path `/var/www/html`, execute the next command:

```bash
php artisan jwt:secret
```

### 6. Execute migrations and seeders
Inside the container and positioned on the path `/var/www/html`, execute the next command:

```bash
php artisan migrate --seed
```
