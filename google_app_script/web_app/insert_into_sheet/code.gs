const SHEET_URL = 'https://docs.google.com/spreadsheets/d/xxxxxx/edit';
const SHEET_GID = 12345678;
const GAS_POST_SIGN_SALT = 'MTUyNTMxOTliNDdkNDQ3Ng==';

function doPost(e) {
    e.method = "POST";
    console.log('Request:::', e);

    var param = e.parameter;
    var res = {
        action: 'doPost',
        status: true,
        code: 0,
    };

    // check Sign
    if( ! checkSign(param) ) {
        res.code = 1;
        res.status = false;
        return jsonResponse(res);
    }

    // find date or fail
    var date = param.datetime;
    var findedRow = getRowByDate(date);
    if( findedRow == -1 ) {
        res.code = 2;
        res.status = false;
        return jsonResponse(res);
    }

    // update, getRange 的 index 是從 1 開始算
    var sheet = getSheetById(SHEET_GID);
    // var rowRange = sheet.getRange(findedRow, 1, 1, 6);
    // getRange(取第幾個row, 從C欄開始, 總共拿 1 行, 總共拿 4 欄)
    var valueRange = sheet.getRange(findedRow, 3, 1, 4);
    var values = [
        param.all_registered,
        param.yesterday_registered,
        param.yesterday_login,
        param.yesterday_oubo
    ];
    valueRange.setValues([values]);
    // rowRange.setBackground('yellow');

    // insert
    // sheet.getRange(sheet.getLastRow()+1, 1, 1, values.length)
    //     .setValues([values]);

    // 前一天 color
    // var prevRangeAtoB = sheet.getRange(findedRow-1, 1, 1, 2);
    // var prevRangeCtoF = sheet.getRange(findedRow-1, 3, 1, 4);
    // prevRangeAtoB.setBackground('#f1f1f1'); // grey
    // prevRangeCtoF.setBackground(null); // no color

    return jsonResponse(res);
}

function jsonResponse(data) {
    console.log('jsonResponse:::', data);
    return ContentService.createTextOutput(JSON.stringify(data)).setMimeType(ContentService.MimeType.JSON);
}

/**
 * @return int
 */
function getRowByDate(date) {
    var sheet = getSheetById(SHEET_GID);

    // getValues() 日期會被轉換成 DateFormat, example: "Wed Apr 22 2020 00:00:00 GMT+0800 (台北標準時間)"
    var rangeA4toEnd = sheet.getRange("A4:A"+sheet.getLastRow()).getValues();

    // 注意 new Date() 會用本地時區，一定要設定好時區
    var searchDate = Utilities.formatDate(new Date(date), "Asia/Tokyo", "YYYY/MM/dd");
    // 搜尋 string matches index
    var findedRow = rangeA4toEnd.findIndex(searchDate);

    return ( findedRow == -1 ) ? findedRow : findedRow + 4;
}

/**
 * 日期欄位
 * @return int
 */
Array.prototype.findIndex = function(search){
    if(search == "") return false;
    for (var i = 0; i < this.length; i++) {
        try {
            var date = Utilities.formatDate(new Date(this[i]), "Asia/Tokyo", "YYYY/MM/dd");
            if (date == search) return i;
        } catch (e) {}
    }
    return -1;
};

/**
 * @return boolean
 */
function auth(arr) {
    if(!arr._token) return false;
    const time = parseInt('0x' + arr._token.substr(-8));
    const token = arr._token.substring(0, arr._token.length - 8);
    delete arr._token;
    const fieldnames = Object.keys(arr).sort();
    let col = [];
    for(var k of fieldnames)
        col.push(k + '=' + arr[k]);

    const hashBa = Utilities.computeDigest(Utilities.DigestAlgorithm.SHA_256, col.join('|') + '||' + GAS_POST_SIGN_SALT + '@' + time);
    const rez = hashBa.map(b => ('0' + (b & 0xff).toString(16)).slice(-2)).join('');
    return rez === token;
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
