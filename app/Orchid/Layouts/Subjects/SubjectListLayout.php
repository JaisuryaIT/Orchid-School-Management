<?php

namespace App\Orchid\Layouts\Subjects;

use App\Models\Subjects;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SubjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subjects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('subject_name','Subject Name'),
            TD::make('subject_code','Subject Code'),
            TD::make('Actions')
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (Subjects $subject) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    Link::make('Edit')
                        ->route('platform.subjects.edit', $subject)
                        ->icon('bs.pencil'),

                    Button::make('Remove')
                        ->icon('bs.trash3')
                        ->confirm($subject->subject_name.' Will be Removed Forever')
                        ->method('remove', ['id' => $subject->id,]),
                ])),
        ];
    }
}
