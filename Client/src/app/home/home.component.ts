import { Component, OnInit, EventEmitter } from '@angular/core';
import 'materialize-css';
import 'angular2-materialize';
import { MaterializeAction } from 'angular2-materialize';
import { Http } from '@angular/http';
declare var $: any;

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    userID = localStorage.getItem('user');
    configuredGames;
    matches;

    constructor(private http: Http) {
    }

    sideNavActions = new EventEmitter<any | MaterializeAction>();
    openSideNav() {
        this.sideNavActions.emit({ action: 'sideNav', params: ['show'] });
    }
    closeSideNav() {
        this.sideNavActions.emit({ action: 'sideNav', params: ['hide'] });
    }

    ngOnInit() {
        localStorage.setItem('game', '1'); // Change this pls

        const url = `${this.BASE_URL}/getMatches`;

        const params = {userID: this.userID};

        this.http.get(url, {params: params}).subscribe(res => this.matches = res.json());
    }
}
