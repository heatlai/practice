/**
 * 接收 json format 參數
 */
function doPost(e) {
    var json = JSON.parse(e.postData.contents);
    console.log(json);
    return ContentService.createTextOutput(JSON.stringify(json));
}
