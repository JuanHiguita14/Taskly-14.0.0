<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Course $course): bool
    {
        // El usuario puede ver el curso si es el propietario
        if ($user->id === $course->user_id) {
            return true;
        }
        
        // O si el curso está asignado a través de TeacherStudentAssignment
        if ($user->isStudent() || $user->isTeacher()) {
            $assignment = \App\Models\TeacherStudentAssignment::where(function($query) use ($user, $course) {
                if ($user->isStudent()) {
                    $query->where('student_id', $user->id);
                } else {
                    $query->where('teacher_id', $user->id);
                }
            })
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();
            
            return $assignment !== null;
        }
        
        return false;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function restore(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    public function forceDelete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }
} 