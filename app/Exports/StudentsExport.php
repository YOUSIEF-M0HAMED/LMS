<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Student::select('student_id', 'username', 'fname', 'lname', 'email', 'phone')->get();
  }

  public function headings(): array
  {
    return ['student_id', 'username', 'fname', 'lname', 'email', 'phone'];
  }
}
