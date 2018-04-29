import { Component, OnInit } from '@angular/core';
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
    userID = localStorage.getItem('userID');

    constructor(private http: Http) { }

    ngOnInit() {
        this.getRecentGames();
    }

    getRecentGames() {
        const url = `${this.BASE_URL}/getRecentGames`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe( (data) => console.log(data.json()));
    }
}
