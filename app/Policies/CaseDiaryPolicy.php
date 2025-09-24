<?php
namespace App\Policies;

use App\Models\User;
use App\Models\CaseDiary;
use Illuminate\Auth\Access\Response;

class CaseDiaryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isLawyer() || $user->isStaff();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CaseDiary $caseDiary): bool
    {
        // Admin can view any case.
        if ($user->isAdmin()) {
            return true;
        }

        // Lawyer or Staff can view cases of their own chamber.
        return $user->chamber_id === $caseDiary->chamber_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin, Lawyer, or Staff can create cases.
        return $user->isAdmin() || $user->isLawyer() || $user->isStaff();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CaseDiary $caseDiary): bool
    {
        // Admin can update any case.
        if ($user->isAdmin()) {
            return true;
        }
        
        // Lawyer/Staff can update cases in their chamber.
        return ($user->isLawyer() || $user->isStaff()) && $user->chamber_id === $caseDiary->chamber_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CaseDiary $caseDiary): bool
    {
        // Admin can delete any case.
        if ($user->isAdmin()) {
            return true;
        }

        // Only Lawyer can delete cases in their chamber.
        return $user->isLawyer() && $user->chamber_id === $caseDiary->chamber_id;
    }
}