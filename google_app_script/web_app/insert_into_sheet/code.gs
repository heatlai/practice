function debug() {
    var date = '5/21';
    var values = ['gg','3be0', 'gg2','7788'];
    insertOrUpdate(date, values);
}

function doGet(e) {
    e.method = "GET";
    console.log(e);
    return ContentService.createTextOutput(JSON.stringify(e)).setMimeType(ContentService.MimeType.JSON);
}

function doPost(e) {
    e.method = "POST";
    console.log(e);

//  var param = e.parameter;
//  insert([
//    param.name,
//    param.location
//  ]);
    return ContentService.createTextOutput(JSON.stringify(e)).setMimeType(ContentService.MimeType.JSON);
}

const SHEET_URL = 'https://docs.google.com/spreadsheets/d/1q6VdbxhNWIwG2buj5cJ9MahMYOfzTw_--lmWBsDTWYY/edit';
const SHEET_GID = 925981656;

// search matches row index
Array.prototype.findIndex = function(search){
    if(search == "") return false;
    for (var i = 0; i < this.length; i++) {
        if (this[i] == search) return i;
    }
    return -1;
};

function insertOrUpdate(searchString, values) {
    var sheet = getSheetById(SHEET_GID);

    // 用 getDisplayValues() 抓 A 欄全部 value
    // 不要用 getValues() 因為日期會被轉換成 DateFormat, example: "Wed Apr 22 2020 00:00:00 GMT+0800 (台北標準時間)"
    var dataOnSheet = sheet.getRange("A1:A"+sheet.getLastRow()).getDisplayValues();
    console.log(dataOnSheet);

    // 搜尋 string matches index
    var findedRow = dataOnSheet.findIndex(searchString);
    console.log(findedRow);

    if( findedRow == -1 ) {
        // insert, 前面多寫日期跟跳過一個欄位
        var values = [searchString, ,].concat(values);
        console.log(values);
        sheet.getRange(sheet.getLastRow()+1, 1, 1, values.length).setValues([values]);
    } else {
        // update, getRange 的 index 是從 1 開始算, 所以 findedRow 要 +1
        sheet.getRange(findedRow+1, 3, 1, 4).setValues([values]);
    }
}

function insert(values) {
    var sheet = getSheetById(SHEET_GID);
    console.log(sheet.getName());

    var lastRow = sheet.getLastRow();
    var range = sheet.getRange(lastRow+1, 1, 1, values.length);
    range.setValues([values]);

    var result = range.getValues()[0];
    console.log(result);
    return result;
}

/**
 * @return Sheet
 */
function getSheetById(id) {
    var ss = SpreadsheetApp.openByUrl(SHEET_URL);
    return ss.getSheets().filter(
        function(s) {return s.getSheetId() === id;}
    )[0];
}


