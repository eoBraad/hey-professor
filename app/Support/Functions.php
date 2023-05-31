<?php

use App\Models\User;

function user(): ?User
{
    if(auth()->user()) {
        return auth()->user();
    }

    return null;
}
