import {Component, EventEmitter, HostListener, OnInit, Output} from '@angular/core';
import {Http} from '@angular/http';
import {SocketService} from '../services/socket.service';
import {MatchService} from '../services/match.service';
import {MaterializeAction} from 'angular2-materialize';
import 'materialize-css';

@Component({
    selector: 'app-search',
    templateUrl: './search.component.html',
    styleUrls: ['./search.component.css']
})
export class SearchComponent {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});

    userID = localStorage.getItem('userID');
    gameID = localStorage.getItem('game');

    inQueue = 0;

    compList;

    selectedUser;

    @Output() newMatch = new EventEmitter();

    @Output() selectedChange = new EventEmitter();

    modalActions = new EventEmitter<string|MaterializeAction>();
    openModal(selected) {
        this.selectedUser = selected;
        this.selectedChange.emit(selected);
        this.modalActions.emit({action: 'modal', params: ['open']});
    }
    closeModal() {
        this.modalActions.emit({action: 'modal', params: ['close']});
    }

    constructor(private http: Http, private socket: SocketService, private matchService: MatchService) {
        this.selectedUser = this.userID;
    }

    enterQueue() {
        const url = `${this.BASE_URL}/enterQueue`;

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 1; this.getList(); });
    }

    exitQueue() {
        const url = `${this.BASE_URL}/exitQueue`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.post(url, { userID: this.userID, gameID: this.gameID }).subscribe((res) => { this.inQueue = 0; this.compList = null; });
    }

    getList() {
        const url = `${this.BASE_URL}/getCompList`;

        const params = {userID: this.userID, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe(
            (res) => { this.compList = res.json(); }
            );
    }

    accept(user) {
        const url = `${this.BASE_URL}/sendRequest`;

        const params = {userID: this.userID, matchID: user, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe(

            (res) => {
                this.newMatch.emit();

                this.socket.joinRoom(this.userID, user);

                this.compList = this.compList.filter(item => item.userID !== user);

                if (this.compList.length === 0) {
                    this.exitQueue();
                }
            }
        );
    }

    // Change this to accept params because we displaying all the users at once now
    decline(user) {
        const url = `${this.BASE_URL}/declineRequest`;

        const params = {userID: this.userID, matchID: user, gameID: this.gameID};

        this.http.get(url, {params: params}).subscribe(
            (res) => {
                this.compList = this.compList.filter(item => item.userID !== user);

                if (this.compList.length === 0) {
                    this.exitQueue();
                }
            }
        );
    }


}
