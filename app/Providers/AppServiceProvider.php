<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Models
use  App\Models\Division;
use  App\Models\Follow;
use  App\Models\Position;
use  App\Models\PositionDivision;
use  App\Models\Report;
use  App\Models\User;
use App\Models\UserNetwork;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use  App\Models\UserDivision;
use App\Models\ModelHasRoles;
use App\Models\Notification;
use App\Models\ManagerDivision;
use App\Models\FeedBack;

//Contract
use App\Repositories\Contracts\NotificationRepository as CNotificaton;
use App\Repositories\Contracts\DivisionRepository as CDivision;
use App\Repositories\Contracts\FollowRepository as CFollow;
use App\Repositories\Contracts\ReportRepository as CReport;
use App\Repositories\Contracts\UserRepository as CUser;
use App\Repositories\Contracts\PositionRepository as CPosition;
use App\Repositories\Contracts\UserNetworkRepository as CUserNetwork;
use App\Repositories\Contracts\RoleRepository as CRole;
use App\Repositories\Contracts\PermissionRepository as CPermission;
use App\Repositories\Contracts\UserDivisionRepository as CUserDivision;
use App\Repositories\Contracts\PositionDivisionRepository as CPositionDivision;
use App\Repositories\Contracts\ModelHasRolesRepository as CModelHasRoles;
use App\Repositories\Contracts\ManagerDivisionRepository as CManagerDivision;
use App\Repositories\Contracts\FeedBackRepository as CFeedBack;

//Eloquent
use App\Repositories\Eloquent\EloquentNotificationRepository as ENotification;
use App\Repositories\Eloquent\EloquentReportRepository as EReport;
use App\Repositories\Eloquent\EloquentPositionRepository as EPosition;
use App\Repositories\Eloquent\EloquentDivisionRepository as EDivision;
use App\Repositories\Eloquent\EloquentUserRepository as EUser;
use App\Repositories\Eloquent\EloquentFollowRepository as EFollow;
use App\Repositories\Eloquent\EloquentUserNetworkRepository as EUserNetwork;
use App\Repositories\Eloquent\EloquentPermissionRepository as EPermission;
use App\Repositories\Eloquent\EloquentRoleRepository as ERole;
use App\Repositories\Eloquent\EloquentUserDivisionRepository as EUserDivision;
use App\Repositories\Eloquent\EloquentPositionDivisionRepository as EPositionDivision;
use App\Repositories\Eloquent\EloquentModelHasRolesRepository as EModelHasRoles;
use App\Repositories\Eloquent\EloquentManagerDivisionRepository as EManagerDivision;
use App\Repositories\Eloquent\EloquentFeedBackRepository as EFeedBack;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRepository();
    }

    /**
     * Declare Repository
     *
     */
    private function loadRepository()
    {
        $this->app->bind(CNotificaton::class, function () {
            return new ENotification(new Notification());
        });
        $this->app->bind(CUserDivision::class, function () {
            return new EUserDivision(new UserDivision());
        });
        $this->app->bind(CUser::class, function () {
            return new EUser(new User());
        });
        $this->app->bind(CFollow::class, function () {
            return new EFollow(new Follow());
        });
        $this->app->bind(CReport::class, function () {
            return new EReport(new Report());
        });
        $this->app->bind(CDivision::class, function () {
            return new EDivision(new Division());
        });
        $this->app->bind(CPosition::class, function () {
            return new EPosition(new Position());
        });
        $this->app->bind(CUserNetwork::class, function () {
            return new EUserNetwork(new UserNetwork());
        });
        $this->app->bind(CPermission::class, function () {
            return new EPermission(new Permission());
        });
        $this->app->bind(CRole::class, function () {
            return new ERole(new Role());
        });
        $this->app->bind(CPositionDivision::class, function () {
            return new EPositionDivision(new PositionDivision());
        });
        $this->app->bind(CModelHasRoles::class, function () {
            return new EModelHasRoles(new ModelHasRoles());
        });
        $this->app->bind(CManagerDivision::class, function() {
            return new EManagerDivision(new ManagerDivision());
        });
        $this->app->bind(CFeedBack::class, function() {
            return new EFeedBack(new FeedBack());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
