# Project Overview

This repository contains a solution to the assigned task. Follow the instructions below to set up and run the project successfully.

## Prerequisites

- PHP >= 8.x (check `composer.json` for compatibility)
- Composer
- MySQL (or the database specified in the `.env` file)
- Ensure all other dependencies in `composer.json` are installed

## Setup Instructions

1. **Clone the Repository**
- Clone the repository using the following git command:
  git clone https://github.com/gsuzair/Ticket-Go-Task
2. **Install Dependencies**
- Run the following command to install the necessary packages:
  composer install
3. **Set Up Environment Variables**
- Create a .env file by copying the .env.example:
cp .env.example .env
- Update the .env file with database credentials and other settings as needed.
- Also run this command after updating the .env file:
  php artisan config:cache
4. **Run Migrations**
- Set up the database schema:
  php artisan migrate
5. **Seed the Database**
- Populate the database with sample data:
  php artisan db:seed
6. **Generate Swagger Documentation**
- Generate API documentation using Swagger:
  php artisan l5-swagger:generate
7. **Run the Project**
- Start the local development server:
  php artisan serve
- Or clone this in the laragon www folder and try the base URL of this application, it will take you to the API documentation.
8. **Run Tests**
- To execute the test cases, run:
  php artisan test
