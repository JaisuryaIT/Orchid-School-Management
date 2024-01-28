<?php

namespace App\Orchid\Screens\Classes;

use App\Models\Classes;
use App\Orchid\Layouts\Classes\ClassListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ClassListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'classes' => Classes::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Classes';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add Class')
                ->route('platform.classes.edit')
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
            ClassListLayout::class
        ];
    }
    public function remove(Request $request): void
    {
        $class=Classes::findOrFail($request->get('id'));
        $class->delete();
        Toast::error($class['class_name'].' Was Removed Succesfully');
    }
}
