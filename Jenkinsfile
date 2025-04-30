pipeline {
    agent any

    stages {
        stage('Clone Project') {
            steps {
                git credentialsId: 'f55d6ab3-1e3c-45e8-9ed8-c07d8dbac878', url: 'https://github.com/andreirhamni09/steradian-code-challenge-backend-developer.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install'
                sh 'cp .env.example .env || true'
                sh 'php artisan key:generate'
            }
        }

        stage('Run Laravel Server') {
            steps {
                sh 'php artisan serve --host=0.0.0.0 --port=9000 &'
                sh 'sleep 5' // tunggu server naik
            }
        }

        stage('Run Tests (Opsional)') {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
