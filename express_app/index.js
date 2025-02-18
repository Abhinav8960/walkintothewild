import { Prisma, PrismaClient } from '@prisma/client';
const express = require('express');
const app = express();
const prisma = new PrismaClient()
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server);

app.get('/', (req, res) => {
    res.sendFile(__dirname + '/chat/index.html');
});

io.on('connection', (socket) => {
    console.log('a user connected : '+socket);

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });

    socket.on('chat message', (msg) => {
        console.log('message: ' + msg);
        io.emit('chat message', msg); // message to everyone
    });

    socket.on('room list', (room) => {
        console.log('room list: ' + room);
        io.emit('room list',); // message to everyone
    });

    io.of("/").adapter.on("create-room", (room) => {
        console.log(`room ${room} was created`);
    });

    io.of("/").adapter.on("join-room", (room, id) => {
        console.log(`socket ${id} has joined room ${room}`);
    });




//     // basic emit
//   socket.emit(/* ... */);

//   // to all clients in the current namespace except the sender
//   socket.broadcast.emit(/* ... */);

//   // to all clients in room1 except the sender
//   socket.to("room1").emit(/* ... */);

//   // to all clients in room1 and/or room2 except the sender
//   socket.to("room1").to("room2").emit(/* ... */);

//   // to all clients in room1
//   io.in("room1").emit(/* ... */);

//   // to all clients in namespace "myNamespace"
//   io.of("myNamespace").emit(/* ... */);

//   // to all clients in room1 in namespace "myNamespace"
//   io.of("myNamespace").to("room1").emit(/* ... */);

//   // to individual socketid (private message)
//   io.to(socketId).emit(/* ... */);

//   // to all clients on this node (when using multiple nodes)
//   io.local.emit(/* ... */);

//   // to all connected clients
//   io.emit(/* ... */);

//   // WARNING: `socket.to(socket.id).emit()` will NOT work, as it will send to everyone in the room
//   // named `socket.id` but the sender. Please use the classic `socket.emit()` instead.

//   // with acknowledgement
//   socket.emit("question", (answer) => {
//     // ...
//   });

//   // without compression
//   socket.compress(false).emit(/* ... */);

//   // a message that might be dropped if the low-level transport is not writable
//   socket.volatile.emit(/* ... */);

});


server.listen(3000, () => {
    console.log('listening on *:3000');
});