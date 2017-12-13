import {Component, OnInit, Output, EventEmitter, Input} from '@angular/core';
import {MaterializeAction} from 'angular2-materialize';
import { HttpClient } from '@angular/common/http';
import { Constants } from '../constants';
import { Router } from '@angular/router';

import { AuthService } from '../services/auth.service';

declare let Materialize: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
    headers = new Headers({
        'Content-Type': 'application/json'
    });
    emailReg: string;
    userReg: string;
    passReg: string;
    url = '';
    registerURL = '/preferences';
    loginURL = '/';

    data: Object;

    user: string;
    pass: string;

  @Output() modalActions = new EventEmitter<string|MaterializeAction>();
  openModal() {
    this.modalActions.emit({action: 'modal', params: ['open']});
  }
  closeModal() {
    this.modalActions.emit({action: 'modal', params: ['close']});
  }

  constructor(private http: HttpClient, private auth: AuthService, private router: Router) {
      this.url = Constants.API_URL;
  }

  ngOnInit() {

  }

  register() {
      this.auth.register(this.emailReg, this.userReg, this.passReg)
          .then((user) => {localStorage.setItem('token', user.json().token); })
          .catch(e => {console.log(e); return; });

      this.router.navigate(['/preferences']);
  }

  onLogin(): void {
      this.auth.login(this.user, this.pass)
          .then((user) => {localStorage.setItem('token', user.json().token); })
          .catch(e => console.log(e));

      this.router.navigate(['/']);
  }
}
