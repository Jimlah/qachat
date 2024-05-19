<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{channelId}', function (User $user, int $channelId) {
    return ['id' => $user->id, 'name' => $user->name];
    if ($user->canJoinRoom($channelId)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
});
