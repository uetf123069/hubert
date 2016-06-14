var app = require('express')(); 
var server = require('http').Server(app);
var io = require('socket.io')(server);
var debug = require('debug')('Uber:Chat');
var request = require('request');
var port = process.env.PORT || '3000';

process.env.DEBUG = '*';
// process.env.DEBUG = '*,-express*,-engine*,-send,-*parser';

server.listen(port);

io.on('connection', function (socket) {

    console.log('new connection established');
    console.log('socket.handshake.query.sender', socket.handshake.query.sender);
    
    socket.join(socket.handshake.query.sender);

    socket.emit('connected', 'Connection to server established!');

    socket.on('send message', function(data) {
        console.log(data);
        data.sender = socket.handshake.query.sender;

        socket.broadcast.to( (data.type + data.provider) ).emit('message', data);

        request('http://dev.xuber.com/message/save?user_id='+data.user+'&provider_id='+data.provider+'&message='+data.message+'&type='+data.type, function (error, response, body) {
            if (!error && response.statusCode == 200) {
                console.log(body); // Show the HTML for the Google homepage. 
            }
        });
    });

    socket.on('disconnect', function(data) {
        console.log('disconnect', data);
    });
});