<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.MembersModel.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

 Broadcast::channel('maintenance.status', function ($user) {
     return true;
 });

 Broadcast::channel('all.auth.users', function ($user) {
     return true;
 });

 Broadcast::channel('test', function ($user) {
     return true;
 });
