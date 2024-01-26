<?php

namespace App\Orchid\Screens\ExamTypes;

use App\Models\ExamTypes;
use App\Orchid\Layouts\ExamTypes\ExamTypeListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ExamTypeListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'exam_types' => ExamTypes::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Exam Types';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Add Exam Type')
                ->route('platform.exam_types.edit')
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
            ExamTypeListLayout::class
        ];
    }
    public function remove(Request $request): void
    {
        $exam_type=ExamTypes::findOrFail($request->get('id'));
        $exam_type->delete();
        Toast::error($exam_type['exam_type_name'].' Was Removed Succesfully');
    }
}
