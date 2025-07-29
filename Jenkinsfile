pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/p2tdsi/projet.git', branch: 'master'
            }
        }
        stage('Build Docker Image') {
            steps {
                sh 'docker build -t crud-app:latest .'
            }
        }
        stage('Deploy') {
            steps {
                sh 'docker stop crud-app || true'
                sh 'docker rm crud-app || true'
                sh 'docker run -d --name crud-app -p 8081:80 -v /var/www/html/database.sqlite:/var/www/html/database.sqlite crud-app:latest'
            }
        }
    }
}
