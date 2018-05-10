import { Component, OnInit, EventEmitter } from '@angular/core';
import 'materialize-css';
import 'angular2-materialize';
import { MaterializeAction } from 'angular2-materialize';
import { Http } from '@angular/http';
import { ActivatedRoute, Router } from '@angular/router';
import { MatchService } from '../services/match.service';
declare var $: any;

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    userID = localStorage.getItem('userID');
    configuredGames;

    matches;

    compNumber = 1;

    selectedUser;

    sideNavActions = new EventEmitter<any | MaterializeAction>();
    profileView = new EventEmitter<string|MaterializeAction>();

    openSideNav() {
        this.sideNavActions.emit({ action: 'sideNav', params: ['show'] });
    }

    openModal(selected) {
        this.selectedUser = selected;
        this.profileView.emit({action: 'modal', params: ['open']});
    }
    closeModal() {
        this.profileView.emit({action: 'modal', params: ['close']});
    }

    constructor(private http: Http, private router: Router, private route: ActivatedRoute, private matchService: MatchService) {
        this.route.params.subscribe( params => this.compNumber = +params['id']);
        if (isNaN(this.compNumber)) {
            this.compNumber = 1;
        }
    }


    closeSideNav() {
        this.sideNavActions.emit({ action: 'sideNav', params: ['hide'] });
    }

    ngOnInit() {
        localStorage.setItem('game', '1'); // Change this pls

        this.matchService.getMatches(this.userID).subscribe((data) => { this.matches = data.json(); });
    }

    newMatches() {
        this.matchService.getMatches(this.userID).subscribe((data) => { this.matches = data.json(); });
    }

    selectChange(event) {
        this.selectedUser = event;
    }

    logOff() {
        localStorage.clear();

        this.router.navigate(['/login']);
    }
}
