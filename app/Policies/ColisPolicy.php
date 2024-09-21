<?php

namespace App\Policies;

use App\Models\Colis;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ColisPolicy
{
    use HandlesAuthorization;

    // Vérifie si l'utilisateur peut créer un colis
    public function create(User $user)
    {
        return $user->check();
    }

    // Vérifie si l'utilisateur peut voir un colis
    public function view(User $user, Colis $colis)
    {
        return $user->id === $colis->user_id || $user->hasRole('GP');
    }

    // Vérifie si l'utilisateur peut mettre à jour un colis
    public function update(User $user, Colis $colis)
    {
        return $user->id === $colis->user_id || $user->hasRole('GP');
    }

    // Vérifie si l'utilisateur peut supprimer un colis (soft delete)
    public function delete(User $user, Colis $colis)
    {
        return $user->id === $colis->user_id || $user->hasRole('GP');
    }
}
