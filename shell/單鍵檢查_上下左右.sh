#!/usr/bin/env bash

readOneKeyPress() {
    local ESC=$(printf "\033")
    read -p "單鍵檢查：" -rsn1 input
    # 當輸入的字元為 ESC 字元時，再抓 2 個字元
    # 因為方向鍵(上下左右)是 3 字元 例: up => ${ESC}[A
    if [[ $input == $ESC ]]; then
        read -rsn2 input
    fi
    case $input in
        '[A') echo up ;;
        '[B') echo down ;;
        '[C') echo right ;;
        '[D') echo left ;;
        '') echo enter ;; # enter, tab, space 的 input 都是空字串
        *)
            echo "$input"
            return
            ;;
    esac
}

key=$(readOneKeyPress)
case $key in
    up) echo up ;;
    down) echo down ;;
    right) echo right ;;
    left) echo left ;;
    enter) echo enter ;;
    q)
        echo quit
        exit
        ;;
    *) echo "$key" ;;
esac
