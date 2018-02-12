import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { MaterializeModule } from 'angular2-materialize';
import { HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

import { AuthService } from './services/auth.service';

import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { LoginGuard } from './login.guard';
import { PreferencesComponent } from './preferences/preferences.component';
import { HomeComponent } from './home/home.component';
import {GamesService} from './services/games.service';
import { SearchComponent } from './search/search.component';

@NgModule({
  declarations: [
      AppComponent,
      LoginComponent,
      PreferencesComponent,
      HomeComponent,
      SearchComponent
  ],
  imports: [
      BrowserModule,
      MaterializeModule,
      HttpClientModule,
      FormsModule,
      HttpModule,
      RouterModule.forRoot([
          { path: 'login', component: LoginComponent },
          { path: '', canActivate: [LoginGuard], children: [ // Put all other routes in here so that route guard is applied
              { path: 'preferences', component: PreferencesComponent },
              { path: '', component: HomeComponent}
          ]}
      ])
  ],
  providers: [AuthService, GamesService, LoginGuard],
  bootstrap: [AppComponent]
})
export class AppModule { }
