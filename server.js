var mongo = require('mongodb').MongoClient,
client  = require('socket.io').listen(8080).sockets;

mongo.connect('mongodb://127.0.0.1/chat', function(err, db){
		if(err) throw err;
		client.on('connection', function(socket){
			var col = db.collection('messages')
			sendStatus = function(s){
				socket.emit('status', s);
				};
			//Emit all messages
			col.find().limit(100).sort({_id: 1}).toArray(function(err, res){
				if(err) throw err;
				socket.emit('output', res);
				});
				
			//wait for input
			socket.on('input', function(data){
					//console.log(data);
					var name = data.name,
						message = data.message
						whitespacePattern = /^\s*$/;
						
					if(whitespacePattern.test(name) || whitespacePattern.test(message))
					{
						sendStatus('Message is Required.');
						//console.log('Invalid txt');
					}
					else
					{
						col.insert({name: name, message: message}, function(){
						//Emit latest message to all clients
						client.emit('output', [data]);
						sendStatus({
							message : 'Message Sent',
							clear: '1'
							});
						});
					}
				});
			//console.log('Someone has connected');
		});
	});
	
