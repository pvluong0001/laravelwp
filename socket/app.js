const webSocketServer = require('websocket').server;
const http = require('http');

const server = http.createServer();
server.listen(1357, function() {});

const wsServer = new webSocketServer({
  httpServer: server
});

const connections = {};

wsServer.on('request', function (request) {
  const connection = request.accept(null, request.origin);

  connection.send(JSON.stringify({
    type: 'message',
    text: 'Connected success'
  }))

  // Đây là callback quan trọng nhất,chúng ta sẽ
  // xử lý thông tin của client ở đây.
  connection.on('message', function (message) {
    const {type} = message;
    let jsonMessage;

    switch (type) {
      case 'utf8':
        jsonMessage = JSON.parse(message.utf8Data);

        if(jsonMessage.type === 'initId') {
          connections[jsonMessage.data] = connection;
        }
        break;
      case 'binary':
        jsonMessage = JSON.parse(message.binaryData.toString());

        const {connection: connectionId, text} = jsonMessage;
        connections[connectionId].send(JSON.stringify({
          type: 'message',
          text
        }))

        break;
    }
  });

  connection.on('close', function (connection) {
    // do something
  });
});