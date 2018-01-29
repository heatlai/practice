let url = new URL("https://geo.example.org/api");
let params = {
    lat: 35.696233,
    long: 139.570431
};

Object.keys(params).forEach(
    key => url.searchParams.append(key, params[key])
);

fetch(url).then(function (res) {
    if (res.status !== 200)
    {
        throw new Error('errorCode: ' + res.status);
    }
    return res.json();
}).then(function (data) {
    return console.log('res:', data);
}).catch(function (err) {
    return console.error('error:', err);
});