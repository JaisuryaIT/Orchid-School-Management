<?php

namespace App\Orchid\Screens\Classes;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClassEditScreen extends Screen
{
    public $class;
    public $teachers;
    public $year;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function __construct(Classes $class)
    {
        $this->class = $class;
        $this->teachers = Teachers::orderBy('first_name')->get();
        $this->year = AcademicYear::orderBy('start_date')->get();
    }
    public function query(Classes $class): iterable
    {
        return [
            'class' => $class,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->class->exists ? 'Edit Class' : 'Create Class';
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
                ->canSee(!$this->class->exists),

            Button::make('Update')
                ->icon('bs.pencil')
                ->method('createOrUpdate')
                ->canSee($this->class->exists),

            Button::make('Remove')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->class->exists)
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
                Input::make('class.class_name')
                        ->title('Class Name')
                        ->required()
                        ->placeholder('Enter Class Name')
                ]),
                Layout::rows([
                    Input::make('class.grade_level')
                            ->title('Grade')
                            ->required()
                            ->placeholder('Enter Grade')
                ]),
                Layout::rows([
                    Input::make('class.section')
                            ->title('Section')
                            ->required()
                            ->placeholder('Enter Section')
                ]),
                Layout::rows([
                    Select::make('class.teacher_id')
                            ->title('Teacher')
                            ->options($this->teachers->pluck('full_name', 'id')->toArray())
                            ->empty('Select Teacher'),
                ]), 
                Layout::rows([
                    Select::make('class.academic_year_id')
                            ->title('Academic Year')
                            ->options($this->year->pluck('name', 'id')->toArray())
                            ->empty('Select Academic Year')
                ]),               
            ]),
        ];
    }
    public function createOrUpdate(Request $request)
    {
        $classData = $request->get('class');
        $existingclassName = Classes::where('class_name', $classData['class_name'])->first();
        $existingclassTeacher = Classes::where('teacher_id', $classData['teacher_id'])->first();
        if ($existingclassName && $existingclassName->id !== $this->class->id) {
            Toast::warning('Class with Class Name "'.$classData['class_name'].'" is Already Created, Try With New Class Name');
            return redirect()->back()->withInput();
        }
        if ($existingclassTeacher && $existingclassTeacher->id !== $this->class->id) {
            $duplicateTeacher = Teachers::find($classData['teacher_id']);
            Toast::warning('Teacher "'.$duplicateTeacher->full_name.'" is Already Assigned To Class "'.$existingclassTeacher['class_name'].'", Try With a New Teacher');
            return redirect()->back()->withInput();
        }
        $message = $this->class->exists ? ' Was Updated Successfully' : 'Class Created Successfully';
        Toast::success($this->class['class_name'] . ' ' . $message);
        $this->class->fill($classData)->save();
        return redirect()->route('platform.classes');
    }
    public function remove()
    {
        Toast::error($this->class['class_name'].' Was Removed Succesfully');
        $this->class->delete();
        return redirect()->route('platform.classes');
    }
}
