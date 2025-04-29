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

        stage('Install Composer') {
            steps {
                sh '''
                    EXPECTED_SIGNATURE=$(curl -s https://composer.github.io/installer.sig)
                    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                    ACTUAL_SIGNATURE=$(php -r "echo hash_file('sha384', 'composer-setup.php');")

                    if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
                        >&2 echo 'ERROR: Invalid installer signature'
                        rm composer-setup.php
                        exit 1
                    fi

                    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
                    rm composer-setup.php

                    composer --version
                '''
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
