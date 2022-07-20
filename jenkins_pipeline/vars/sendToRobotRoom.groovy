def call(Map args) {
    def roomId = 'xxx'
    def message = """\
        |[info][title]${args.title}[/title]${args.to ?: ''}
        |Job: ${env.JOB_NAME}
        |Tester: ${env.BUILD_USER}
        |${args.result ? "Result: ${args.result}\n" : ''}Git Branch: ${env.GIT_BRANCH}
        |Build Url: ${env.BUILD_URL}[/info]""".stripMargin()
    sendToChatRoom(roomId, message)
}
