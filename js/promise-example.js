let promise = getPromise(true);

function getPromise(bool)
{
    return new Promise(function (resolve, reject) {
        let value = 'yes';
        let error = 'no';
        console.log(bool, value, error);

        if (bool)
        {
            resolve(value);
        }
        else
        {
            throw error;
        }
    });
}

promise.then(function (data) {
    data = data + ', yoyoyo';
    return data;
}).then(function (data) {
    console.log('resolve', data);
}).catch(function (e) {
    console.log('catch', e);
});

console.log('done');

/* --------------------------- */

(function () {
    window.Prober = window.Prober || {};
    let _self = window.Prober;

    function init(status)
    {
        return new Promise(function (resolve, reject) {

            /* code... */

            if (status)
            {
                resolve('ok');
            }
            else
            {
                reject('failed');
            }

        });
    }

    function doSomething()
    {
        $.ajax();
    }

    init(0)
        .then(
            function (res) {
                doSomething();
                let json = res.json();
                console.log('resolve', json);
                return json;
            },
            function (error) {
                console.log('reject', error);
                throw 'york';
            })
        .then(
            function (json) {
                console.log('resole2', json);
            },
            function (error) {
                console.log('reject2', error);
            });

})();