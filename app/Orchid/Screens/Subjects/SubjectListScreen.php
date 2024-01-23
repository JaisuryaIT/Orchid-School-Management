<?php

namespace App\Orchid\Screens\Subjects;

use App\Models\Subjects;
use App\Orchid\Layouts\Subjects\SubjectDetailsModalLayout;
use App\Orchid\Layouts\Subjects\SubjectListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SubjectListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'subjects' => Subjects::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Subjects';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add Subject')
                ->route('platform.subjects.edit')
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
                SubjectListLayout::class,
        ];
    }
    public function remove(Request $request): void
    {
        $subject=Subjects::findOrFail($request->get('id'));
        $subject->delete();
        Toast::error($subject['subject_name'].' Was Removed Succesfully');
    }
}
