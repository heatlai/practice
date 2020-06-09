const app = require('mylib/app');
const puppeteer = require('puppeteer');
jest.setTimeout(120000); // 延長執行時間

describe.each([
    {
        url: 'https://google.com',
        selector: 'title',
        shouldIncludes: 'Google'
    },
    {
        url: 'https://facebook.com',
        selector: 'title',
        shouldIncludes: 'Facebook'
    },
])('標題檢查', (testRow) => {
    let browser, page;

    beforeAll(async () => {
        browser = await puppeteer.launch(app.launchOptions);
        page = await browser.newPage();
        await page.authenticate(app.authenticate);
        await page.goto(testRow.url, {waitUntil: 'load', timeout: 0});
    });

    afterAll(() => {
        browser.close()
    });

    test(`${testRow.url} title should includes ${testRow.shouldIncludes}`, async () => {
        const el = await page.$(testRow.selector);
        if( el ) {
            let text = await page.evaluate(el => el.textContent, el);
            expect(text.includes(testRow.shouldIncludes)).toBe(true);
        }
    });

});
