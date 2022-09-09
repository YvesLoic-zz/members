<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{

    private $school_id;

    public function __construct(int $id)
    {
        $this->school_id = $id;
    }

    public function headings(): array
    {
        return [
            'Firstname',
            'Lastname',
            'Matricule',
            'Class',
            'Birthday',
            'Birthplace',
            'Sex',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $students = Student::select('first_name', 'last_name', 'matricule', 'class', 'birthday', 'birthplace', 'sex')
            ->where('school_id', $this->school_id)->get();
        return collect($students);
    }
}
