<?php
// 透過 標準輸出 印出要詢問的內容
fwrite(STDOUT, "Enter your name: ");

// 抓取 標準輸入 的 內容
$name = trim(fgets(STDIN));

// 將剛剛輸入的內容, 送到 標準輸出
fwrite(STDOUT, "Hello, $name!");
