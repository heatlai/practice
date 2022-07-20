import groovy.json.JsonOutput
import groovy.transform.Field

@Field final REDMINE_ISSUE_INTERNAL_ENDPOINT = "http://ec2-x-x-x-x.ap-northeast-1.compute.amazonaws.com/redmine/issues"
@Field final REDMINE_ISSUE_URL = "https://xxx.com/redmine/issues"

def updateIssue(issueId, data) {
    if (!env.REDMINE_TOKEN) {
        error "未設定環境變數 REDMINE_TOKEN "
    }
    String json = JsonOutput.toJson(data)
    String response = sh(
        script: "curl -v -H 'Content-Type: application/json' -X PUT --data-binary '${json}' -H 'X-Redmine-API-Key: ${env.REDMINE_TOKEN}' '${REDMINE_ISSUE_INTERNAL_ENDPOINT}/${issueId}.json'",
        returnStdout: true
    ).trim()
    return response;
}

def fetchIssue(issueId) {
    if (!env.REDMINE_TOKEN) {
        error "未設定環境變數 REDMINE_TOKEN "
    }
    String response = sh(
        script: "curl -v -H 'Content-Type: application/json' -X GET -H 'X-Redmine-API-Key: ${env.REDMINE_TOKEN}' '${REDMINE_ISSUE_INTERNAL_ENDPOINT}/${issueId}.json'",
        returnStdout: true
    ).trim()
    return readJSON(text: response)
}
