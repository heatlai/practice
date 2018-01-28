var promise = getPromise(true);

function getPromise(bool) {
    return new Promise(function(resolve, reject) {
        var value = 'yes';
        var error = 'no';
        console.log(bool, value, error);

        if (bool) {
            resolve(value);
        } else {
            throw error;
        }
    });
}

promise.then(function(data) {
    data = data + ', yoyoyo';
    return data;
}).then(function(data) {
    console.log('resolve', data);
}).catch(function(e) {
    console.log('catch', e);
});

console.log('done');