pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                git branch: 'master', url: 'https://github.com/p2tdsi/projet-.git'
            }
        }
        stage('List files') {
            steps {
                sh 'ls -l'
            }
        }
    }
}



