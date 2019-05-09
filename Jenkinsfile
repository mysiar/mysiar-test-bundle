pipeline {
    agent {
        label 'test-php72'
    }
    stages {
        stage('Env') {
            steps {
                script {
                    env.GIT_COMMITTER_EMAIL = sh (
                        script: "git --no-pager show -s --format=%ae",
                        returnStdout: true
                    ).trim()
                }
                script {
                    env.ROCKET_CHAT_USER = sh (
                        script: "git --no-pager show -s --format=%ae | sed 's/@[^,]*//'",
                        returnStdout: true
                    ).trim()
                }
            }
        }
        stage('Clean & install dependencies') {
            post {
                failure {
                    updateGitlabCommitStatus name: 'Clean & install dependencies', state: 'failed'
                }
                success {
                    updateGitlabCommitStatus name: 'Clean & install dependencies', state: 'success'
                }
            }
            steps {
                sh 'composer cache-clear'
                sh 'composer update'
            }
        }
        stage('Code linting') {
            post {
                failure {
                    updateGitlabCommitStatus name: 'Code linting', state: 'failed'
                }
                success {
                    updateGitlabCommitStatus name: 'Code linting', state: 'success'
                }
            }
            steps {
                sh 'composer php-lint'
            }
        }
        stage('Coding standard') {
            post {
                failure {
                    updateGitlabCommitStatus name: 'Coding standard', state: 'failed'
                }
                success {
                    updateGitlabCommitStatus name: 'Coding standard', state: 'success'
                }
            }
            steps {
                sh 'composer phpcs'
            }
        }
        stage('Test') {
            post {
                failure {
                    updateGitlabCommitStatus name: 'Test', state: 'failed'
                }
                success {
                    updateGitlabCommitStatus name: 'Test', state: 'success'
                }
            }
            steps {
                sh 'composer phpunit'
            }
        }
    }
    options {
        gitLabConnection('GITLAB')
        gitlabBuilds(builds: ['Clean & install dependencies', 'Code linting', 'Coding standard', 'Test'])
    }
    triggers {
        gitlab(triggerOnPush: true, triggerOnMergeRequest: true, branchFilterType: 'All')
    }
}
