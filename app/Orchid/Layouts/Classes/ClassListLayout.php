<?php

namespace App\Orchid\Layouts\Classes;

use App\Models\Classes;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClassListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'classes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('class_name','Class Name'),
            TD::make('grade_level','Grade'),
            TD::make('section','Section'),
            TD::make('teacher_id','Class Teacher')
            ->render(function (Classes $class) {
                return $class->teacher ? $class->teacher->first_name.' '.$class->teacher->last_name : 'NA';
            }),
            TD::make('academic_year_id','Academic Year')
            ->render(function (Classes $class) {
                return $class->academicYear->name;
            }),
            TD::make('total_students','Total Students')
            ->render(function (Classes $class) {
                return $class->total_students ? $class->total_students : '0';
            }),
            TD::make('Actions')
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (Classes $class) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    Link::make('Edit')
                        ->route('platform.classes.edit', $class)
                        ->icon('bs.pencil'),
                    Button::make('Remove')
                        ->icon('bs.trash3')
                        ->confirm($class->class_name.' Will be Removed Forever')
                        ->method('remove', ['id' => $class->id,]),
                ])),
        ];
    }
}
