pipeline {
    agent {
        docker {
            image 'composer:latest'
        }
    }


    environment {
        COMPOSER_ALLOW_SUPERUSER = 1
    }

    stages {
        stage('Clone Project') {
            steps {
                git credentialsId: '420c94b0-4bc5-42a2-abb0-bd7b534b8eec', url: 'https://github.com/andreirhamni09/steradian-code-challenge-backend-developer.git'
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
