import { Component, Inject, forwardRef, OnInit } from '@angular/core';
import { AppComponent } from './app.component';
import { Authentication, AuthGuard, InfoService } from './helper';
import { Router } from '@angular/router';
import { MenuItem, ConfirmationService } from 'primeng/primeng';
@Component({
    selector: 'app-sidebar',
    templateUrl: './app.sidebar.component.html',
    providers: [ConfirmationService]
})
export class AppSideBarComponent implements OnInit {
    profile: any[]
    namaPegawai: any
    initial: any;
    constructor(public app: AppComponent,
        private auth: Authentication,
        private authGuard: AuthGuard,
        private info: InfoService,
        private router: Router,
        private confirm: ConfirmationService) { }

    logout(event: Event) {
        this.confirm.confirm({
            message: 'Apakah anda yakin mau logout ?',
            accept: () => {
                this.app.onMenuButtonClick(event,0)
                this.auth.logout(this.authGuard, this.info, this.router);
                event.preventDefault();
            }
        })

    }
    ngOnInit() {

        let user = this.authGuard.getUserDto()
        if (user.pegawai.namalengkap) {
            this.namaPegawai = user.pegawai.namalengkap
            let forInitial = this.namaPegawai.split(' ')
            // console.log(forInitial)
            if (forInitial.length > 1) {
                let a = forInitial[0].substring(0, 1).toUpperCase()
                let b = forInitial[1].substring(0, 1).toUpperCase()
                this.initial = a + b
            } else if (forInitial.length == 1) {
                let a = forInitial[0].substring(0, 1).toUpperCase()
                this.initial = a
            }
        } else {
            this.namaPegawai = 'Adminitrator'
            this.initial = this.namaPegawai.substring(0, 1).toUpperCase()
        }

        this.profile = [
            { label: 'Profile', icon: 'fa fa-fw fa-user', command: () => this.app.changeToOverlayMenu() },
            { label: 'Privacy', icon: 'fa fa-fw fa-user-secret', command: () => this.app.changeToOverlayMenu() },
            { label: 'Setting', icon: 'fa fa-fw fa-cog', command: () => this.app.changeToOverlayMenu() },
            { label: 'Logout', icon: 'fa fa-fw fa-sign-out', command: () => this.app.changeToOverlayMenu() }
        ]
    }

}
