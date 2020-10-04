
if(window.hasOwnProperty('LPlugin')) {
    throw new Error('Conflict plugin!');
} else {
    window.LPlugin = (function() {
        return {
        }
    })();
}
