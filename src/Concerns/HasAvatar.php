<?php 

namespace OneBiznet\Admin\Concerns;

trait HasAvatar 
{
    protected function getAvatarUrlAttribute()
    {
        return 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $this->name).'&background=random&color=fff';
    }
}