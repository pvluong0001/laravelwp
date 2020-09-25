const uuid = require('uuid');

if(window.hasOwnProperty('LPlugin')) {
    throw new Error('Conflict plugin!');
} else {
    window.LPlugin = (function() {
        const id = uuid.v4();

        const socket = new WebSocket('ws://localhost:1357');

        socket.onopen = function(event) {
            console.log('WebSocket is connected.');
            socket.send(JSON.stringify({
                type: 'initId',
                data: id
            }))
        };

        socket.onerror = error => {
            console.log(error)
        }

        function getId() {
            return id;
        }

        function enableShowMessage(element = null) {
            socket.onmessage = event => {
                const {type, text} = JSON.parse(event.data);
                if(element) {
                    element.append(`<div>${text}</div>`)
                }
            }
        }

        return {
            getId,
            enableShowMessage
        }
    })();
}
