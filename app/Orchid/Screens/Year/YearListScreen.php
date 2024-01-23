<?php

namespace App\Orchid\Screens\Year;

use App\Models\AcademicYear;
use App\Orchid\Layouts\Year\YearListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class YearListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'years' => AcademicYear::orderBy('start_date', 'asc')->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Academic Years';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add Academic Year')
                ->route('platform.years.edit')
                ->icon('bs.plus-circle'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            YearListLayout::class
        ];
    }
    public function remove(Request $request): void
    {
        $year=AcademicYear::findOrFail($request->get('id'));
        $year->delete();
        Toast::error($year['name'].' Was Removed Succesfully');
    }
}
