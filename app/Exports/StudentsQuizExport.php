<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsQuizExport implements FromCollection, WithHeadings, WithMapping
{
  protected $quizId;

  public function __construct($quizId)
  {
    $this->quizId = $quizId;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Student::with(['studentQuizzes' => function ($query) {
      $query->where('quiz_id', $this->quizId);
    }])->get();
  }

  /**
   * @var Student $student
   */
  public function map($student): array
  {
    $score = $student->studentQuizzes->isNotEmpty() ? $student->studentQuizzes->first()->score : '0';

    return [
      $student->id,
      $student->student_id,
      $student->fname . ' ' . $student->lname,
      $score,
    ];
  }

  public function headings(): array
  {
    return [
      'ID',
      'Student ID',
      'Student Name',
      'Score',
    ];
  }
}
