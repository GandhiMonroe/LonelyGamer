import {Component, OnInit, Output, EventEmitter, Input} from '@angular/core';
import {MaterializeAction} from 'angular2-materialize';
import { HttpClient } from '@angular/common/http';
import { Constants } from '../constants';
import { Router } from '@angular/router';

declare let Materialize: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    private router: Router;
    emailReg: string;
    userReg: string;
    passReg: string;
    url = '';
    registerURL = '/preferences';

  @Output() modalActions = new EventEmitter<string|MaterializeAction>();
  openModal() {
    this.modalActions.emit({action: 'modal', params: ['open']});
  }
  closeModal() {
    this.modalActions.emit({action: 'modal', params: ['close']});
  }

  constructor(private http: HttpClient) {
      this.url = Constants.API_URL;
  }

  ngOnInit() {
  }

  register() {
      this.http.post(this.url + '/api/signup', {
          emailReg: this.emailReg,
          userReg: this.userReg,
          passReg: this.passReg
      }).subscribe(res => window.location.href = this.registerURL);
  }
}
