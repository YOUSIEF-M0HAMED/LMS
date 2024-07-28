<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CoursesExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Course::select('course_code', 'name', 'specification')->get();
  }

  public function headings(): array
  {
    return ['course_code', 'name', 'specification'];
  }
}
