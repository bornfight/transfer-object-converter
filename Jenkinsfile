#!/usr/bin/env groovy

pipeline {
    agent {
        label 'php7.2'
    }
    stages {
        stage("Composer") {
            steps {
                sh "composer install"
            }
        }
        stage('Test') {
            parallel {
                stage("Static Analysis") {
                    steps {
                        sh "composer run ci:analysis"
                        sh "composer run ci:analysis:tests"
                    }
                    post {
                        success {
                            recordIssues(tools: [cpd(pattern: 'reports/phpcpd*.xml'), checkStyle(pattern: 'reports/*-checkstyle*.xml'), pmdParser(pattern: 'reports/*-pmd*.xml')], unstableTotalAll: 1)
                        }
                    }
                }
                stage("Codeception") {
                    steps {
                        sh "composer run ci:test"
                    }
                    post {
                        success {
                          junit 'tests/_output/report.xml'
                          step([
                              $class: 'CloverPublisher',
                              cloverReportDir: 'tests/_output/coverage',
                              cloverReportFileName: '../coverage.xml',
                              healthyTarget: [methodCoverage: 80, conditionalCoverage: 80, statementCoverage: 80],
                              unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50],
                              failingTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50]]
                          )
                          publishHTML([allowMissing: false, alwaysLinkToLastBuild: false, keepAll: false, reportDir: 'tests/_output', reportFiles: 'report.html,coverage/index.html', reportName: 'Codeception report', reportTitles: 'Test overview,Code coverage'])
                        }
                    }
                }
            }
        }
        stage("Code Metrics") {
            when {
                branch 'master'
            }
            steps {
                checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'RelativeTargetDirectory', relativeTargetDir: 'code-metrics-observatory']], submoduleCfg: [], userRemoteConfigs: [[credentialsId: 'istudio', url: 'git@github.com:degordian/code-metrics-observatory.git']]])
                dir('code-metrics-observatory') {
                    sh "composer install"
                    configFileProvider([configFile(fileId: 'c3d7339a-64c3-43ed-a9f0-51a2423f267c', targetLocation: '.env.local')]) {
                        sh "bin/console collect transfer-object-converter ../tests/_output/report.xml"
                    }
                }
            }
        }
    }
    options {
        ansiColor("xterm")
        timestamps()
        timeout(time: 20, unit: 'MINUTES')
    }
}
