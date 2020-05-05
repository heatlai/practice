
const GAS_POST_SIGN_SALT = 'MTUyNTMxOTliNDdkNDQ3Ng==';

/**
 * @return boolean
 */
function checkToken(param) {
    if (!param._token) {
        return false;
    }
    // 最後8位是時間值 16進位 轉回 10 進位
    const time = parseInt('0x' + param._token.substr(-8));
    // 取token本體，去掉最後8位時間值
    const token = param._token.substring(0, param._token.length - 8);
    delete param._token;

    const fieldNames = Object.keys(param).sort();
    let col = [];
    for (var k of fieldNames) {
        col.push(k + '=' + param[k]);
    }

    let hashData = col.join('|') + '||' + GAS_POST_SIGN_SALT + '@' + time;
    const hashBinaryArray = Utilities.computeDigest(Utilities.DigestAlgorithm.SHA_256, hashData);
    const rez = hashBinaryArray.map(b => ('0' + (b & 0xff).toString(16)).slice(-2)).join('');
    return rez === token;
}
