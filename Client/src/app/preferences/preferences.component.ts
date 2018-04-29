import { Component, OnInit } from '@angular/core';
import { GamesService } from '../services/games.service';
import { Http } from '@angular/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-preferences',
  templateUrl: './preferences.component.html',
  styleUrls: ['./preferences.component.css']
})
export class PreferencesComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});
    public games: any;
    public roles: any;
    currentGame;

    summonerID;
    steamID;
    myPrimary;
    mySecondary;
    matchPrimary;
    matchSecondary;

    constructor(private gameService: GamesService, private http: Http, private router: Router) { }

    ngOnInit() {
        const url = `${this.BASE_URL}/getGames`;
        this.http.get(url, this.headers).subscribe(res => this.games = res.json());
        // this.games = this.gameService.getGames();
    }

    getRolesForGame(gameID) {
        const url = `${this.BASE_URL}/getRolesByGame`;

        const params = {gameID: gameID};

        this.http.get(url, {params: params}).subscribe(res => this.roles = res.json());

        this.currentGame = gameID;
    }

    insertPref() {
        let account;
        if (this.currentGame === 1) {
            account = this.summonerID;
        } else {
            account = this.steamID;
        }
        this.gameService.addPref(
            localStorage.getItem('user'), this.summonerID, this.currentGame, this.myPrimary, this.mySecondary,
            this.matchPrimary, this.matchSecondary)
            .then();
        this.router.navigate(['/']);
    }
}
