$(document).ready(($) => {
    console.log('hello world');

    const clickMe = $('#click-me');
    const jqueryWarning = $('#jquery-warning');

    clickMe.click((e) => {
        jqueryWarning.css('display', 'block');
    });
});
