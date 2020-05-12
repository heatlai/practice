/**
 * script 環境變數 key-value pair
 *  script.google.com 開啟專案
 *      -> 檔案(左上角, 工具列第一個)
 *      -> 專案屬性
 *      -> 指令碼屬性
 *  @link https://developers.google.com/apps-script/reference/properties
 */
const scriptProperties = PropertiesService.getScriptProperties();
const SHEET_URL = scriptProperties.getProperty('SHEET_URL');
const SHEET_GID = parseInt(scriptProperties.getProperty('SHEET_GID'), 10);
