import {EventEmitter, Injectable, Output} from '@angular/core';
import { Http } from '@angular/http';
import {Observable} from "rxjs/Observable";

@Injectable()
export class MatchService {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    matches;

    constructor(private http: Http) { }

    @Output() matchChange: EventEmitter<boolean> = new EventEmitter();

    getMatches(userID) {
        const url = `${this.BASE_URL}/getMatches`;

        const params = {userID: userID};

        const result = this.http.get(url, {params: params});

        // this.matchChange.emit(true);

        return result;
    }
}
