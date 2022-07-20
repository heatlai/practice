import groovy.transform.Field
@Field final USERS = [
    'heat'   : 'Heat Lai',
    'lebron'   : 'Lebron James',
]

@Field final ROOMS = [
    'QA'       : 'xxx',
    'A'        : 'xxx',
    'B'        : 'xxx',
    'C'        : 'xxx',
    'D'        : 'xxx',
]

@Field final MEDIA_USERS = [
    'e2e'       : ['heat'],
]

def monthlyStart() {
    sendToRobotRoom(title: " ⓜ Jenkins 回歸測試開始通知 ⓜ ");
}

def monthlyEnd() {
    sendToRobotRoom(
        title: " ⓜ Jenkins 回歸測試結束通知 ⓜ ",
        result: (currentBuild.currentResult == 'SUCCESS') ? 'SUCCESS;)' : 'FAIL:^)',
    );
}

def checkStart() {
    sendToRobotRoom(title: " Ⓓ Jenkins 每日測試開始通知 started at ${env.BUILD_TIMESTAMP} Ⓓ ");
}

def checkEnd() {
    sendToRobotRoom(
        title: " Ⓓ Jenkins 每日測試結束通知 started at ${env.BUILD_TIMESTAMP} Ⓓ ",
        result: (currentBuild.currentResult == 'SUCCESS') ? 'SUCCESS(h)' : '❗❌FAIL:^)',
    );
}

def checkToProjectUser(userName, titleJobName) {
    def to = toChatUser([userName]);
    def roomId = ROOMS['QA']
    def message = """\
        |[info][title] Ⓓ "${titleJobName}" Jenkins 每日測試結束通知 started at ${env.BUILD_TIMESTAMP}Ⓓ [/title]${to}
        |Result: ❗❌FAIL:^)
        |Job Url: ${env.BUILD_URL}[/info]""".stripMargin()
    sendToChatRoom(roomId, message)
}

def checkToSubmitTestCase(mediaName,subject,fixCounts,solveNum,redmineUrl) {
    List usersArrays = MEDIA_USERS[mediaName]
    def to = toChatUser(usersArrays);
    def roomId = ROOMS[mediaName];
    def message = """\
        |[info][title]  案件測試完成通知 [/title]${subject} 測試完畢[hr]
        |${to}
        |Result：Pass
        |QA redmine連結：${redmineUrl}
        |QA返件bug數量：${solveNum}
        |QA返件次數：${fixCounts}[/info]""".stripMargin()
    sendToChatRoom(roomId, message)
}

def caseStart() {
    sendToRobotRoom(
        title: " Ⓒ Jenkins 案件回歸測試開始通知 Ⓒ ",
    );
}

def caseEnd() {
    sendToRobotRoom(
        title: " Ⓒ Jenkins 案件回歸測試結束通知 Ⓒ ",
        result: (currentBuild.currentResult == 'SUCCESS') ? 'SUCCESS😍' : 'FAIL🤢',
        to: toExecutorChatUser(),
    );
}
def caseATeamDelayStart(jobName, caseNumber) {
    def to = toChatUser(['heat'], ['lebron']);
    def message = """\
        |[info][title] Ⓒ "${jobName}" 案件回歸測試通知 Ⓒ [/title]${to}
        |Tester: ${env.BUILD_USER}
        |Job Url: https://jenkins.xxx.com/job/${jobName}/
        |Comment: "10 分鐘後會開始執行測試"
        |Case Number: ${caseNumber}[/info]""".stripMargin()
    sendToChatRoom(ROOMS['A'], message)
}

def toExecutorChatUser() {
    return toChatUser([env.BUILD_USER])
}

def toChatUser(ArrayList<String> to = [], ArrayList<String> cc = []) {
    def toStr = '';
    for(name in to) {
        def user = USERS[name.toLowerCase()]
        if( user ) {
            toStr = toStr + "${user}"
        }
    }
    if(cc.size()) {
        toStr = toStr + "\ncc:"
        for(name in cc) {
            def user = USERS[name.toLowerCase()]
            if( user ) {
                toStr = toStr + "${user}"
            }
        }
    }
    return toStr
}
