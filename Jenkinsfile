pipeline {
    agent any
    
    environment {
        COMPOSE_PROJECT_NAME = 'laravel-jenkins'  // Nama proyek untuk Docker Compose
    }
    
    stages {
        stage('Clone Repository') {
            steps {
                git credentialsId: 'a9ad390e-a198-46a8-b9e4-1edbb10f449d', url: 'https://github.com/andreirhamni09/steradian-code-challenge-backend-developer.git'
            }
        }

        stage('Build Docker Containers') {
            steps {
                script {
                    // Bangun dan jalankan kontainer Docker menggunakan Docker Compose
                    sh 'docker-compose -f docker-compose.yml up --build -d'
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    // Install dependensi Laravel di dalam container jika diperlukan
                    sh 'docker-compose exec laravel composer install'
                    // Menjalankan artisan key:generate dan lainnya jika perlu
                    sh 'docker-compose exec laravel php artisan key:generate'
                }
            }
        }

        stage('Run Tests') {
            steps {
                script {
                    // Jalankan pengujian otomatis, seperti unit test atau API test
                    sh 'docker-compose exec laravel php artisan test'
                }
            }
        }

        stage('Deploy to Production') {
            steps {
                script {
                    // Tahap ini hanya diperlukan jika Anda ingin melakukan deployment otomatis setelah build dan testing berhasil
                    // Biasanya, ini digunakan untuk memindahkan ke server staging atau produksi
                    sh 'docker-compose -f docker-compose.yml up -d' // Untuk memastikan semua kontainer berjalan di server produksi
                }
            }
        }
    }
    
    post {
        always {
            // Bersihkan semua container dan volume setelah build selesai
            sh 'docker-compose down --volumes'  // Hapus container, network, dan volume
        }
    }
}

