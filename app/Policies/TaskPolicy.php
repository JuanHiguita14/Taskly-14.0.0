<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        // El estudiante dueño de la tarea siempre puede actualizarla (para subir archivos, etc.)
        if ($user->id === $task->user_id) {
            return true;
        }
        
        // Si la tarea fue asignada por un profesor (tiene teacher_id), el profesor también puede editarla
        if ($task->teacher_id !== null && $user->id === $task->teacher_id) {
            return true;
        }
        
        // Si el usuario es profesor o administrador y el estudiante está asignado a él
        if ($user->hasAnyRole(['teacher', 'admin']) && $task->user && $task->user->role === 'student') {
            // Verificar si el estudiante está asignado a este profesor
            $assignment = \App\Models\TeacherStudentAssignment::where('teacher_id', $user->id)
                ->where('student_id', $task->user_id)
                ->where('status', 'active')
                ->exists();
            
            if ($assignment) {
                return true;
            }
        }
        
        return false;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function restore(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
} 