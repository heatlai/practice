// 觸發條件設定為 特定日期時間 就可以準時執行
// 所以設定一個每日執行區間是 07:00 ~ 08:00 執行 setTrigger() 的觸發事件來設定一個今天 09:00 的準時觸發事件
function setTrigger() {
    var triggerDay = new Date();
    triggerDay.setHours(9);
    triggerDay.setMinutes(0);
    ScriptApp.newTrigger("doDailyJob").timeBased().at(triggerDay).create();
}

// 刪除每日執行的特定日期時間觸發條件
function deleteTrigger() {
    var triggers = ScriptApp.getProjectTriggers();
    for(var i = 0; i < triggers.length; i++) {
        if (triggers[i].getHandlerFunction() == "doDailyJob") {
            ScriptApp.deleteTrigger(triggers[i]);
        }
    }
}

// 每日 09:00 執行的排程工作
function doDailyJob() {
    console.log('gg3be0');
    Logger.log('gg4be0');
    deleteTrigger();
}
