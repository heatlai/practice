function debug() {
    var result = doGet(
        {
            parameter:{
                name: 'SuperSaiyan',
                location: 'earth'
            }
        }
    );

    console.log(result);
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


