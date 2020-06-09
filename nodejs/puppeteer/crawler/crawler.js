'use strict';
require('module-alias/register');
const puppeteer = require('puppeteer');
const fs = require('fs');
const app = require('mylib/app');

// 開始時間
const hrstart = process.hrtime();

(async () => {
    const browser = await puppeteer.launch({
        // headless: false,
        // devtools: true,
        slowMo: 100, // 設定每一步的延遲毫秒數
        defaultViewport: null, // full page, default : 800x600
        args: [
            '--window-size=1920,1080', // default : 800x600 or use --start-fullscreen 全螢幕
        ]
    });
    const page = await browser.newPage();

    const urls = [
        ['仙台', 'https://www.cityheaven.net/miyagi/A0401/shop-list/'],
        ['高松', 'https://www.cityheaven.net/kagawa/A3701/shop-list/'],
        ['善通寺', 'https://www.cityheaven.net/kagawa/A3702/shop-list/'],
        ['山口市', 'https://www.cityheaven.net/yamaguchi/A3501/A350101/shop-list/'],
        ['周南', 'https://www.cityheaven.net/yamaguchi/A3505/shop-list/'],
        ['松山', 'https://www.cityheaven.net/ehime/A3801/A380101/shop-list/'],
        ['今治', 'https://www.cityheaven.net/ehime/A3802/A380201/shop-list/'],
        ['岡山市', 'https://www.cityheaven.net/okayama/A3301/A330101/shop-list/'],
        ['倉敷', 'https://www.cityheaven.net/okayama/A3302/A330201/shop-list/'],
        ['広島市', 'https://www.cityheaven.net/hiroshima/A3401/shop-list/'],
        ['東広島', 'https://www.cityheaven.net/hiroshima/A3404/A340403/shop-list/'],
    ];

    for (const params of urls) {
        const area = params[0];
        const testUrl = params[1];
        const fileName = `${app.rootDir}/output/area-${area}.csv`;

        console.log(`[${area}] START.`);

        await page.goto(testUrl, {waitUntil: 'load', timeout: 0});
        await readMore(page);

        fs.openSync(fileName, 'w');

        // 取得所有 title & href
        let shopUrlList = await page.$$(".shop_contents_list > ul > li > div.shop_header > div.shop_title > div.shop_title_name > div.table-cell a");
        console.log(`[${area}] COUNT: ${shopUrlList.length}`);
        for (let shop of shopUrlList) {
            let shopUrl = await page.evaluate(el => el.href, shop);
            let shoptitle = await page.evaluate(el => el.innerText, shop);
            fs.appendFile(fileName, `"${shoptitle}","${shopUrl}"\r`, function (err) {
                console.log(err ? err : `[${area}] Append: ${shoptitle}, ${shopUrl}.`);
            });
        }

        await sleep(100);
        console.log(`[${area}] END.`);
    }

    await browser.close();

    const hrend = process.hrtime(hrstart);
    console.info('Execution time: %ds %dms', hrend[0], hrend[1] / 1000000)
})();

async function readMore(page) {
    let ajaxUrl = page.url();
    let readMoreBtn = "#main > div.shop_nav_list > span";

    // when read more btn is visible
    while (await page.evaluate(isVisible, readMoreBtn)) {
        console.log('readMore Next.');
        let btn = await page.$(readMoreBtn);
        await btn.click();
        await page.waitForResponse(res => {
            return res.request().url().startsWith(ajaxUrl) && res.ok();
        });
    }

    console.log('readMore End.');
}

function sleep(ms = 0) {
    return new Promise(r => setTimeout(r, ms));
}

function isVisible(selector) {
    const e = document.querySelector(selector);
    if (!e) {
        return false;
    }
    const style = window.getComputedStyle(e);
    return style && style.display !== 'none' && style.visibility !== 'hidden' && style.opacity !== '0';
}
