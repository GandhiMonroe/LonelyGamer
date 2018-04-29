import { Injectable } from '@angular/core';
import * as io from 'socket.io-client';

@Injectable()
export class SocketService {

    socket: SocketIOClient.Socket;

    constructor() {
        this.socket = io.connect('http://localhost:8080');
    }

    joinRoom(userID, matchID) {
        this.socket.emit('subscribe', userID + '-' + matchID);
    }

    sendMessage(room, msg) {

    }
}
