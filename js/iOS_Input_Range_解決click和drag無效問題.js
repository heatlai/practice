/**
 * 解決 iOS 13.x 以下的 safari input[type=range] 的問題
 * 1. 不能用 click 變更值
 * 2. 一定要點到圓點上面才能拖動
 */

const iosOnTouch = function (e) {
    var rangeEl = e.target,
        dr = rangeEl.getBoundingClientRect(),
        step = rangeEl.getAttribute("step") ? (rangeEl.getAttribute("step") * 1) : 1,
        max = rangeEl.getAttribute("max") ? (rangeEl.getAttribute("max") * 1) : 100,
        pageX = e.pageX || e.changedTouches[0].pageX,
        val = Math.max(0, Math.min(max, Math.round((pageX - dr.left) * max / (dr.right - dr.left) / step) * step));
    rangeEl.value = val;
    rangeEl.dispatchEvent(new Event('input', {'bubbles': true}));
}

if (!!navigator.platform.match(/iPhone|iPod|iPad/)) {
    document.querySelectorAll('input[type=range]').forEach(function (el) {
        // for click
        el.addEventListener("touchend", iosOnTouch, {passive: true});
        // for drag
        el.addEventListener("touchmove", iosOnTouch, {passive: true});
    });
}
