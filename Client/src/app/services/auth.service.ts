import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';
import 'rxjs/add/operator/toPromise';


@Injectable()
export class AuthService {
    private BASE_URL = 'http://localhost:8000/api';
    private headers: Headers = new Headers({'Content-Type': 'application/json'});
    constructor(private http: Http) {}

    login(user, pass): Promise<any> {
        const url = `${this.BASE_URL}/login`;
        return this.http.post(url, {user: user, pass: pass}, {headers: this.headers}).toPromise();
    }

    register(email, user, pass): Promise<any> {
        const url = `${this.BASE_URL}/signup`;
        return this.http.post(url, {emailReg: email, userReg: user, passReg: pass}, {headers: this.headers}).toPromise();
    }

    isAuthenticated(): boolean {
        return localStorage.getItem('token') != null;
    }
}
