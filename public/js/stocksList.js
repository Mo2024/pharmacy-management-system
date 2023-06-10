function decreaseValue(value) {
    el = document.getElementById(value)
    if (el.value > 1) {
        el.value--;
    }
}
function increaseValue(value) {
    el = document.getElementById(value)
    el.value++;
}