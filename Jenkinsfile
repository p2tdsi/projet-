pipeline {
    agent any

    environment {
        DOCKER_IMAGE_NAME = 'crud-app'
        DOCKER_IMAGE_TAG = 'latest'
    }


        stage('Build Docker Image') {
            steps {
                sh 'docker build -t ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} .'
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                    docker stop crud-app || true
                    docker rm crud-app || true
                    docker run -d --name crud-app -p 8081:80 \
                        -v /var/www/html/database.sqlite:/var/www/html/database.sqlite \
                        ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}
                '''
            }
        }
    }
}

