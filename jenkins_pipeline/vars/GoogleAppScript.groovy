/**
 * Google App Script
 */

def fetch(userId) {
    String endpoint = "https://script.google.com/macros/s/xxx/exec";
    String response = sh(
        script: "curl -L '${endpoint}?user=${userId}'",
        returnStdout: true
    ).trim()
    return readJSON(text: response)
}
