## Web App 回傳參數

- 字串：
```js
return ContentService.createTextOutput('Hello world!');
```
- HTML：
```js
// 直接傳 html code
  var HTML = '<b>Hello world!</b>';
  return HtmlService.createHtmlOutput(HTML);
```
```js
// 傳 template
  return HtmlService.createHtmlOutputFromFile('index');
```
```html
<!-- index.html -->
<!DOCTYPE html>
<html>
  <head>
    <base target="_top">
  </head>
  <body>
    Hello, World!
  </body>
</html>
```
- JSON：
```js
  return ContentService.createTextOutput(JSON.stringify(data))
      .setMimeType(ContentService.MimeType.JSON);
```
