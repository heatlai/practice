/**
 * 字串比對
 * @return int
 */
Array.prototype.findIndex = function(search){
    if(search == "") return false;
    for (var i = 0; i < this.length; i++) {
        if (this[i] == search) return i;
    }
    return -1;
};

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
