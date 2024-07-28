<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Teacher::select('teacher_id', 'username', 'fname', 'lname', 'email', 'phone')->get();
  }

  public function headings(): array
  {
    return ['teacher_id', 'username', 'fname', 'lname', 'email', 'phone'];
  }
}
