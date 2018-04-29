/* jshint node: true */
"use strict";

var express = require('express'),
    app = express(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server);

app.get('/', function(req, res) {
  res.sendfile('/');
});

io.sockets.on('connection', function (socket) {

  socket.on('subscribe', function(room) {
    console.log('joining room', room);
    socket.join(room);
  });

  socket.on('unsubscribe', function(room) {
    console.log('leaving room', room);
    socket.leave(room);
  });

  socket.on('sendMessage', function(data) {
    console.log('sending message');
    io.sockets.in(data.room).emit('message', data);
  });

});

server.listen(8080);

console.log('listening');