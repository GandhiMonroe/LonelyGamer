import {Component, Input, OnInit} from '@angular/core';
import 'materialize-css';
import 'angular2-materialize';
import {Http} from '@angular/http';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    gameID = localStorage.getItem('game');
    user = localStorage.getItem('user');

    @Input() inputUser;

    games;

    constructor(private http: Http) { }

    ngOnInit() {
        this.getRecentGames();
    }

    getRecentGames() {
        const url = `${this.BASE_URL}/getRecentGames`;

        const params = {userID: this.inputUser, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe( (data) => this.games = data.json());
    }
}
