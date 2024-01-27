<?php

namespace App\Orchid\Screens\Teachers;

use App\Models\Teachers;
use App\Orchid\Layouts\Teachers\TeacherListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TeacherListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'teachers' => Teachers::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Teachers';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add Teacher')
                ->route('platform.teachers.edit')
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
            TeacherListLayout::class
        ];
    }
    public function remove(Request $request): void
    {
        $teacher=Teachers::findOrFail($request->get('id'));
        $teacher->delete();
        Toast::error($teacher['first_name'].' '.$teacher['last_name'].' Was Removed Succesfully');
    }
}
