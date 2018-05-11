import {Component, Input, OnInit, OnChanges, SimpleChanges} from '@angular/core';
import 'materialize-css';
import 'angular2-materialize';
import {Http} from '@angular/http';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit, OnChanges {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    gameID = localStorage.getItem('game');
    user = localStorage.getItem('user');
    userID = localStorage.getItem('userID');

    @Input() inputUser;

    games;
    prefs;

    constructor(private http: Http) { }

    ngOnInit() {
    }

    ngOnChanges(changes: SimpleChanges) {
        this.getRecentGames();
        this.getPreferences();
    }

    getRecentGames() {
        const url = `${this.BASE_URL}/getRecentGames`;

        let params;

        if (this.inputUser == null) {
            params = {userID: 3, gameID: this.gameID};
        } else {
            params = {userID: 3, gameID: this.gameID};
        }

        this.http.get(url, {params: params}).subscribe( (data) => this.games = data.json());
    }

    getPreferences() {
        const url = `${this.BASE_URL}/getPreferences`;

        let params;

        if (this.inputUser == null) {
            params = {userID: 3, gameID: this.gameID};
        } else {
            params = {userID: 3, gameID: this.gameID};
        }

        this.http.get(url, {params: params}).subscribe( (data) => this.prefs = data.json());
    }
}
