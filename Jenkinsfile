pipeline {
    agent any
        stages {
        stage('Clone repo') {
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



