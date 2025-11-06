<?php
// app/Policies/CoursePolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function update(User $user, Course $course)
    {
        return $user->id === $course->user_id;
    }

    public function delete(User $user, Course $course)
    {
        return $user->id === $course->user_id;
    }
}
