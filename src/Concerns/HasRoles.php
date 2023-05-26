<?php 

namespace OneBiznet\Admin\Concerns;

use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

trait HasRoles
{
    use SpatieHasRoles;

    public function isAdmin(): bool 
    {
        return $this->hasRole('Administrator') || $this->id == 1;
    }
}