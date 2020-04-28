// 只是筆記，實際要用的話，有些地方是不正確或不必要寫的
node {
    def msg = '成功(gogo)'
    try {
        parallel(
            "Checkout Docker":{
                stage('Git Pull') {
                    dir ('docker') {
                        git branch: 'master',
                            credentialsId: 'xxx', // https://jenkins/credentials/
                            url: 'git@github.com:heatlai/docker-for-dev.git'
                        sh "git rev-parse --abbrev-ref HEAD"
                    }
                }
            },
            "Checkout Source Code":{
                stage('Git Pull') {
                    dir ('src') {
                        git branch: 'dev',
                            credentialsId: 'xxx',
                            url: 'git@github.com:heatlai/my-project.git'
                        if("${CommitId}") {
                            sh "git rev-parse ${CommitId}"
                            sh "git checkout -f ${CommitId}"
                        }
                        sh "git rev-parse --abbrev-ref HEAD"
                    }
                    sh 'chmod 775 -R src'
                    sh 'chmod 777 -R src/storage'
                    sh 'chmod 777 -R src/bootstrap/cache'
                }
            },
            "Checkout Tests Code":{
                stage('Git Pull') {
                    dir ('tests') {
                        git branch: 'master',
                            credentialsId: 'xxx',
                            url: 'git@github.com:heatlai/my-project-test.git'
                        sh "git rev-parse --abbrev-ref HEAD"
                    }
                }
            }
        )

        withEnv(['DISABLE_AUTH=true', 'DB_ENGINE=sqlite']) {
            stage('Build Container') {
                sh 'printenv'
                sh "echo \${DB_ENGINE}"
                echo "The build number is ${env.BUILD_NUMBER}"
                echo "You can also use \${BUILD_NUMBER} -> ${BUILD_NUMBER}"
                sh 'echo "I can access $BUILD_NUMBER in shell command as well."'
                sh 'node -v'
                sh 'npm -v'
                sh 'pwd'
                sh "docker-compose -p ${JOB_NAME} --project-directory . -f ./docker/docker-compose-jenkins.yml up -d"
            }
        }

        stage('Run Test') {
            if("${specificTest}") {
                try {
                    dir ('tests') {
                        sh 'npm install --unsafe-perm=true --allow-root'
                        sh "sed -i 's/ENV=.*/ENV=${testEnv}/g' .env"
                        sh "npm run test '${specificTest}'"
                    }
                } catch(err) {
                    msg = '測試失敗(think)'
                }
                junit 'tests/*.xml'
            } else {
                echo 'No Test.'
            }
            sh "docker-compose -p ${JOB_NAME} --project-directory . -f ./docker/docker-compose-jenkins.yml down"
        }
    } catch (e) {
        msg = '建置失敗(puke)'
    } finally {
        stage('Send Result') {
            def room_id='12345678'
            sh """
                curl -s -X POST 'https://api.chatapp.com/v1/rooms/${room_id}/messages' \
                  -H 'X-Token: xxx' \
                  -d 'body=[info][title]Jenkins 通知[/title]RESULT: ${msg} \n CONSOLE: https://jenkins/blue/organizations/jenkins/${JOB_NAME}/detail/${JOB_NAME}/${BUILD_NUMBER}/ [/info]'
            """
            if("${msg}" != '成功(gogo)') {
                sh 'exit 1'
            }
        }
    }
}
