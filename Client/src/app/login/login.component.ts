import {Component, OnInit, Output, EventEmitter} from '@angular/core';
import {MaterializeAction} from 'angular2-materialize';
import { Router } from '@angular/router';

import { AuthService } from '../services/auth.service';

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

    user: string;
    pass: string;
    remember = false;

  @Output() modalActions = new EventEmitter<string|MaterializeAction>();
  openModal() {
    this.modalActions.emit({action: 'modal', params: ['open']});
  }
  closeModal() {
    this.modalActions.emit({action: 'modal', params: ['close']});
  }

  constructor(private auth: AuthService, private router: Router) {}

  ngOnInit() {
      if (localStorage.getItem('remember') === '1' && localStorage.getItem('user') !== null) {
          this.user = localStorage.getItem('remUser');
          this.pass = localStorage.getItem('remPass');

          this.onLogin();
      }
  }

  register() {
      this.auth.register(this.emailReg, this.userReg, this.passReg)
          .then((user) => {localStorage.setItem('token', user.json().token); localStorage.setItem('user', user.json().user); })
          .catch(e => {console.log(e); return; });

      this.router.navigate(['/preferences']);
  }

  onLogin(): void {
      this.auth.login(this.user, this.pass)
          .then((user) => {localStorage.setItem('token', user.json().token); localStorage.setItem('user', user.json().user); })
          .catch(e => {console.log(e); return; });

      if (this.remember) {
          localStorage.setItem('remUser', this.user);
          localStorage.setItem('remPass', this.pass);
          localStorage.setItem('remember', this.remember.toString());
      }

      this.router.navigate(['/']);
  }
}
