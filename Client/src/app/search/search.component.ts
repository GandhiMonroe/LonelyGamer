import {Component, OnInit} from '@angular/core';
import {Http} from '@angular/http';

@Component({
    selector: 'app-search',
    templateUrl: './search.component.html',
    styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    userID = localStorage.getItem('user');
    gameID = localStorage.getItem('game');

    inQueue = 0;

    constructor(private http: Http) {
    }

    ngOnInit() {
    }

    enterQueue() {
        const url = `${this.BASE_URL}/enterQueue`;

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 1; });
    }

    exitQueue() {
        const url = `${this.BASE_URL}/exitQueue`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 0; });
    }
}
