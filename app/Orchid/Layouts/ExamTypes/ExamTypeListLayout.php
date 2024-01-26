<?php

namespace App\Orchid\Layouts\ExamTypes;

use App\Models\ExamTypes;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ExamTypeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'exam_types';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('exam_type_name','Exam Type Name'),
            TD::make('exam_type_code','Exam Type Code'),
            TD::make('pass_mark','Pass Mark'),
            TD::make('total_mark','Total Mark'),
            TD::make('Actions')
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (ExamTypes $exam_type) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    Link::make('Edit')
                        ->route('platform.exam_types.edit', $exam_type)
                        ->icon('bs.pencil'),
                    Button::make('Remove')
                        ->icon('bs.trash3')
                        ->confirm($exam_type->exam_type_name.' Will be Removed Forever')
                        ->method('remove', ['id' => $exam_type->id,]),
                ])),
        ];
    }
}
