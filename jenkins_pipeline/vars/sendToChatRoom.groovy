def call(roomId, message) {
    def apiToken = '7788999'
    def apiUrl = "https://api.xxx.com/v1/rooms/${roomId}/messages"
    sh "curl -s -X POST '${apiUrl}' \
            -H 'X-Token: ${apiToken}' \
            -d 'body=${message}'"
}
