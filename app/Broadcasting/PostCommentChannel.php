<?php

namespace App\Broadcasting;

use App\Post;
use App\User;

class PostCommentChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user,$id)
    {
        return true;
    }
}
