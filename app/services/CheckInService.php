<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Validation\ValidationException;

class CheckInService
{
    public function create(int $studentId)
    {
        $student = Student::findOrFail($studentId);

        $this->ensureNotAlreadyCheckedInToday($student);

        return CheckIn::create([
            'student_id'     => $student->id,
            'check_in_date'  => now()->toDateString(),
            'check_in_time'  => now()->toTimeString(),
        ]);
    }

    protected function ensureNotAlreadyCheckedInToday(Student $student): void
    {
        $exists = $student->checkIns()
            ->whereDate('check_in_date', now()->toDateString())
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'student_id' => 'Este aluno já tem check-in registado hoje.',
            ]);
        }
    }
}
