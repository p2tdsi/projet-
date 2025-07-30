pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/p2tdsi/projet-.git', branch: 'master', credentialsId: 'github-token'
            }
        }
        stage('Build Docker Image') {
            agent {
                docker {
                    image 'docker:26.1'
                    args '-v /var/run/docker.sock:/var/run/docker.sock'
                }
            }
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
