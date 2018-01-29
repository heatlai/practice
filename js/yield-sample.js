let getInfo = main('a');
let ajax1Return = getInfo.next();

function* main(data)
{
    let result;
    console.log('start', data);

    result = yield ajax1();
    console.log('ajax1 result:', result);

    result = yield ajax2();
    console.log('ajax2 result:', result);

    result = yield ajax3();
    console.log('ajax3 result:', result);

    console.log('all done');

    return result+'End';
}

function ajax1()
{
    console.log('ajax1 running');

    // ajax
    setTimeout(function () {
        console.log('ajax1 done');
        getInfo.next();
    }, 1000);

    return '1';
}

function ajax2()
{
    console.log('ajax2 running');

    // ajax
    setTimeout(function () {
        console.log('ajax2 done');
        getInfo.next();
    }, 1000);
}

function ajax3()
{
    console.log('ajax3 running');

    // ajax
    setTimeout(function () {
        console.log('ajax3 done');
        getInfo.next();
    }, 1000);
}