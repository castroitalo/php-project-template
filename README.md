# PHP Project Template

A basic PHP project template for Simple Dealers Tecnologia.

## Prerequisites

- Docker version *27.2.0* or above.
- Docker Compose version *2.29.2* or above.
- Familiarity with [PHP-FIG](https://www.php-fig.org/) standards:
  - [PSR-1: Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
  - [PSR-4: Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
  - [PER Coding Style](https://www.php-fig.org/per/coding-style/)

## Setting Up the Local Environment

1. Ensure Docker and Docker Compose are installed.
2. Build and start the project locally using the following command:

   ```bash
   docker compose -f docker-compose.dev.yml up --build -d
   ```


3. After the containers are up, access the Docker container with:

   ```bash
   docker container exec -it <container_id> bash
   ```


4. Execute mandatory PHP scripts within the container, such as:

   ```bash
   php bin/execute_migration.php
   ```


5. Create a .env file based on the .env.template file.
6. Open your browser and navigate to http://localhost:3000 to verify everything is set up correctly.

## Project Template Folder Structure

```plaintext
app/
|-- bin/                                         # PHP scripts.
|-- public/                                      # Client-side assets.
|-- |-- static/                                  # Static files.
|-- |-- |-- js/                                  # JavaScript files.
|-- |-- |-- |-- pages/                           # JavaScript files for pages.
|-- |-- |-- |-- resources/                       # Third-party JavaScript resources.
|-- |-- |-- styles/                              # CSS files.
|-- |-- |-- |-- pages/                           # CSS files for pages.
|-- |-- bootstrap.php                            # Bootstrap main components.
|-- |-- index.php                                # Front controller of the app.
|-- src/                                         # Source code of the app.
|-- |-- Core/                                    # Core functionalities (e.g., router, database connection).
|-- |-- |-- Bases/                               # Base classes (e.g., controller, models, services).
|-- |-- |-- Database/                            # Database functionalities.
|-- |-- |-- Enums/                               # Application enums.
|-- |-- |-- Exceptions/                          # Custom exception classes.
|-- |-- |-- Http/                                # HTTP-related classes.
|-- |-- |-- Middlewares/                         # Application middlewares.
|-- |-- |-- Router/                              # Routing module.
|-- |-- |-- View/                                # View module (using League Plates).
|-- |-- Modules/                                 # Application entities.
|-- |-- |-- Homepage/                            # Logic for the Homepage module (controllers, models, services).
|-- templates/                                   # View templates.
|-- |-- layouts/                                 # Layout templates.
|-- |-- pages/                                   # Web page templates.
|-- |-- partials/                                # Common components for web pages.
|-- tests/                                       # Directory for tests (TDD).
|-- .env                                         # Environment configuration constants.
|-- .env.template                                # Template for the .env file.
|-- composer.json                                # Composer configuration file.
dev/                                             # Development Docker environment.
|-- nginx/                                       # NGINX configuration for development.
|-- php/                                         # PHP configuration for development.
.editorconfig                                    # Code style configuration file.
.gitignore                                       # Git ignore file.
docker-compose.dev.yml                           # Docker Compose file for the development environment.
README.md                                        # README file.
```

## Development Notes

To use this template effectively, keep in mind that the src/Modules, templates, and public/static directories are interconnected. When a module controller returns HTML, it should have a corresponding file in the templates directory. Likewise, it should have associated CSS and JavaScript files in the public/static directory.

### Example: Creating a New Module

To create a web page called *Admin* for an admin login screen, follow these steps:

1. *Create the Module: Inside the src/Modules directory, create a directory named **Admin*. Within this module, create the following subdirectories:
   - Controller/
   - Model/
   - Service/

2. *Create the Template*: Add the corresponding HTML template file in the templates/pages/ directory.

3. *Add JavaScript and CSS*: Include a JavaScript file in the public/static/js/pages/ directory and a CSS file in the public/static/styles/pages/ directory.

By following these steps, you ensure that all parts of your application are consistently organized and easy to manage.
