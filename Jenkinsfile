pipeline {
    agent any

    stages {
        stage('Clone Project') {
            steps {
                git credentialsId: '607dbbed-bc65-4e26-ae84-59a7e4725d8f', url: 'https://github.com/andreirhamni09/steradian-code-challenge-backend-developer.git'
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
