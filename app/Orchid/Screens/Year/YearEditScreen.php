<?php

namespace App\Orchid\Screens\Year;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class YearEditScreen extends Screen
{
    public $year;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(AcademicYear $year): iterable
    {
        return [
            'year' => $year,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->year->exists ? 'Edit Academic Year' : 'Create Academic year';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create')
                ->icon('bs.check-circle')
                ->method('createOrUpdate')
                ->canSee(!$this->year->exists),

            Button::make('Update')
                ->icon('bs.pencil')
                ->method('createOrUpdate')
                ->canSee($this->year->exists),

            Button::make('Remove')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->year->exists)
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
            Layout::columns([
                Layout::rows([
                Input::make('year.name')
                        ->title('Name')
                        ->required()
                        ->placeholder('Enter Name')
                ]),
                Layout::rows([
                    Input::make('year.start_date')
                            ->title('Start Date')
                            ->type('date')
                            ->required()
                ]),
                Layout::rows([
                    Input::make('year.end_date')
                            ->title('End Date')
                            ->type('date')
                            ->required()
                ]),
            ]),
        ];
    }
    public function createOrUpdate(Request $request)
    {
        $yearData = $request->get('year');
        $this->year->fill($yearData)->save();
        $this->year->exists ? Toast::success($this->year['name'].' Was Updated Successfully') : Toast::info('Academic Year Created Successfully');
        return redirect()->route('platform.years');
    }
    public function remove()
    {
        Toast::error($this->year['name'].' Was Removed Succesfully');
        $this->year->delete();
        return redirect()->route('platform.years');
    }
}
