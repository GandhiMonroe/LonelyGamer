import { Injectable } from '@angular/core';
import { Http } from '@angular/http';

@Injectable()
export class GamesService {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});
    constructor(private http: Http) {}

    getGames() {
        const url = `${this.BASE_URL}/getGames`;
        return this.http.get(url, this.headers).toPromise();
    }

    addPref(user, account, game, myPrim, mySec, matchPrim, matchSec) {
        const url = `${this.BASE_URL}/newPref`;
        return this.http.post(url,
            {userID: user, gameID: game, account: account, myPrim: myPrim, mySec: mySec, matchPrim: matchPrim, matchSec: matchSec},
            this.headers).toPromise();
    }

}
