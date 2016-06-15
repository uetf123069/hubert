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
    console.log('socket.handshake.query.myid', socket.handshake.query.myid);
    console.log('socket.handshake.query.reqid', socket.handshake.query.reqid);

    socket.reqid = socket.handshake.query.reqid;
    
    socket.join(socket.handshake.query.myid);

    socket.emit('connected', 'Connection to server established!');

    socket.on('send message', function(data) {

        if(data.type == 'up') {
            receiver = 'pu' + data.provider_id;
        } else {
            receiver = 'up' + data.user_id;
        }

        console.log('receiver',receiver);

        socket.broadcast.to( receiver ).emit('message', data);

        url = 'http://xuber.appoets.co/message/save?user_id='+data.user_id
        +'&provider_id='+data.provider_id
        +'&message='+data.message
        +'&type='+data.type
        +'&request_id='+socket.reqid;

        console.log(url);

        request(url, function (error, response, body) {
            if (!error && response.statusCode == 200) {
                // console.log(body); // Show the HTML for the Google homepage. 
            }
        });
    });

    socket.on('disconnect', function(data) {
        console.log('disconnect', data);
    });
});