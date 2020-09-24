const webSocketServer = require('websocket').server;
const http = require('http');

const server = http.createServer();
server.listen(1357, function() {});

const wsServer = new webSocketServer({
  httpServer: server
});

wsServer.on('request', function (request) {
  const connection = request.accept(null, request.origin);

  console.log('connected');
  connection.send(JSON.stringify({
    type: 'message',
    text: 'Connected success'
  }))

  // Đây là callback quan trọng nhất,chúng ta sẽ
  // xử lý thông tin của client ở đây.
  connection.on('message', function (message) {
    console.log(message.binaryData.toString(), '~~~~~~~~~~~~~~~~~')
  });

  connection.on('close', function (connection) {
    console.log('close')
  });
});