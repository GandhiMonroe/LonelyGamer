import {Component, HostListener, OnInit} from '@angular/core';
import {Http} from '@angular/http';
import {SocketService} from '../services/socket.service';
import {MatchService} from '../services/match.service';

@Component({
    selector: 'app-search',
    templateUrl: './search.component.html',
    styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    userID = localStorage.getItem('userID');
    gameID = localStorage.getItem('game');

    inQueue = 0;

    compList;

    currentComp;
    index = 0;

    constructor(private http: Http, private socket: SocketService, private matchService: MatchService) {
    }

    ngOnInit() {
    }

    enterQueue() {
        const url = `${this.BASE_URL}/enterQueue`;

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 1; this.getList(); });
    }

    exitQueue() {
        const url = `${this.BASE_URL}/exitQueue`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 0; });
    }

    getList() {
        const url = `${this.BASE_URL}/getCompList`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe(
            (res) => { this.compList = res.json(); this.currentComp = this.compList[this.index]; }
            );
    }

    accept() {
        const url = `${this.BASE_URL}/sendRequest`;

        const params = {userID: this.userID, matchID: this.currentComp.userID, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe(

            (res) => {
                this.matchService.getMatches(this.userID);

                this.socket.joinRoom(this.userID, this.currentComp.userID);

                this.index += 1;
                if (this.index !== this.compList.length) {
                    this.currentComp = this.compList[this.index];
                } else {
                    this.currentComp = null;
                    this.index = 0;
                    this.exitQueue();
                    this.inQueue = 0;
                }
            }
        );
    }

    // Change this to accept params because we displaying all the users at once now
    decline() {
        const url = `${this.BASE_URL}/declineRequest`;

        const params = {userID: this.userID, matchID: this.currentComp.userID, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe();
    }


}
