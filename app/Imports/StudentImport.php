<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class StudentImport implements ToModel, WithHeadingRow
{
    protected $school_id;

    public function __construct(int $id)
    {
        $this->school_id = $id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $date = Date::excelToDateTimeObject($row['birthday']);
        return new Student([
            'matricule' => $row['matricule'],
            'first_name' => $row['firstname'],
            'last_name' => $row['lastname'],
            'class' => $row['class'],
            'birthday' => $date->format('Y-m-d'),
            'birthplace' => $row['birthplace'],
            'sex' => $row['sex'],
            'school_id' => $this->school_id,
        ]);
    }
}
