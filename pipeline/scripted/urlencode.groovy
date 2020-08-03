node {
    stage('Notify') {
            str = 'https://heat.hypenode.tw/?gg=3be0&ff=20ff'
            encodeStr = URLEncoder.encode(str, "UTF-8")
            echo encodeStr
        }
}
