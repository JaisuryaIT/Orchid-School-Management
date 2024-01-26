<?php

namespace App\Orchid\Screens\ExamTypes;

use App\Models\ExamTypes;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ExamTypeEditScreen extends Screen
{
    public $exam_type;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(ExamTypes $exam_type): iterable
    {
        return [
            'exam_type' => $exam_type,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->exam_type->exists ? 'Edit Exam Type' : 'Create Exam Type';
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
                ->canSee(!$this->exam_type->exists),

            Button::make('Update')
                ->icon('bs.pencil')
                ->method('createOrUpdate')
                ->canSee($this->exam_type->exists),

            Button::make('Remove')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->exam_type->exists)
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
                Input::make('exam_type.exam_type_name')
                        ->title('Exam Type Name')
                        ->required()
                        ->placeholder('Enter Name')
                ]),
                Layout::rows([
                    Input::make('exam_type.exam_type_code')
                            ->title('Exam Type Code')
                            ->required()
                            ->placeholder('Enter Code With 5 Letter')
                ]),
                Layout::rows([
                    Input::make('exam_type.total_mark')
                            ->title('Total Marks')
                            ->type('number')
                            ->required()
                    ]),
                Layout::rows([
                    Input::make('exam_type.pass_mark')
                            ->title('Pass Marks')
                            ->type('number')
                            ->required()
                ]),
            ]),
        ];
    }
    public function createOrUpdate(Request $request)
    {
        $exam_typeData = $request->get('exam_type');
        $existingexam_typeName = ExamTypes::where('exam_type_name', $exam_typeData['exam_type_name'])->first();
        $existingexam_typeCode = ExamTypes::where('exam_type_code', $exam_typeData['exam_type_code'])->first();
        if ($existingexam_typeName && $existingexam_typeName->id !== $this->exam_type->id) {
            Toast::warning('Exam Type with Exam Type Name "'.$exam_typeData['exam_type_name'].'" is Already Created, Try With New Exam Type Name');
            return redirect()->back()->withInput();
        }
        if ($existingexam_typeCode && $existingexam_typeCode->id !== $this->exam_type->id) {
            Toast::warning('Exam Type with Exam Type Code "'.$exam_typeData['exam_type_code'].'" is Already Created, Try With New Exam Type Code');
            return redirect()->back()->withInput();
        }
        $this->exam_type->fill($exam_typeData)->save();
        $message = $this->exam_type->exists ? 'Was Updated Successfully' : 'Created Successfully';
        Toast::success($this->exam_type['exam_type_name'] . ' ' . $message);
        return redirect()->route('platform.exam_types');
    }
    public function remove()
    {
        Toast::error($this->exam_type['exam_type_name'].' Was Removed Succesfully');
        $this->exam_type->delete();
        return redirect()->route('platform.exam_types');
    }
}
