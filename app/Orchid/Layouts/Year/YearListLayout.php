<?php

namespace App\Orchid\Layouts\Year;

use App\Models\AcademicYear;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class YearListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'years';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name','Name'),
            TD::make('start_date', 'Start Date')
                ->render(function (AcademicYear $year) {
                    return \Carbon\Carbon::parse($year->start_date)->format('d-m-Y');
            }),
            TD::make('start_date', 'End Date')
                ->render(function (AcademicYear $year) {
                    return \Carbon\Carbon::parse($year->end_date)->format('d-m-Y');
            }),
            TD::make('Actions')
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (AcademicYear $year) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    Link::make('Edit')
                        ->route('platform.years.edit', $year)
                        ->icon('bs.pencil'),

                    Button::make('Remove')
                        ->icon('bs.trash3')
                        ->confirm($year->name.' Will be Removed Forever')
                        ->method('remove', ['id' => $year->id,]),
                ])),
        ];
    }
}
