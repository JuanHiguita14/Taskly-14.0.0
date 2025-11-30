<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Project $project): bool
    {
        // El estudiante dueño del proyecto siempre puede actualizarlo (para subir archivos, etc.)
        if ($user->id === $project->user_id) {
            return true;
        }
        
        // Si el proyecto fue asignado por un profesor (tiene teacher_id), el profesor también puede editarlo
        if ($project->teacher_id !== null && $user->id === $project->teacher_id) {
            return true;
        }
        
        return false;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
} 