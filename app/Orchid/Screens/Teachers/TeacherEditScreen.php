<?php

namespace App\Orchid\Screens\Teachers;

use App\Models\Subjects;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TeacherEditScreen extends Screen
{
    public $teacher;
    public $allSubjects;

    /**
     * Initialize the screen.
     *
     * @param Teachers $teacher
     */
    public function __construct(Teachers $teacher)
    {
        $this->teacher = $teacher;
        $this->allSubjects = Subjects::all();
    }
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Teachers $teacher): iterable
    {
        return [
            'teacher' => $teacher,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->teacher->exists ? 'Edit Teacher' : 'Create Teacher';
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
                ->canSee(!$this->teacher->exists),

            Button::make('Update')
                ->icon('bs.pencil')
                ->method('createOrUpdate')
                ->canSee($this->teacher->exists),

            Button::make('Remove')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->teacher->exists)
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
            Layout::tabs([
            'Bio'=>[Layout::accordion([
                'Personal'=>[Layout::columns([
                        Layout::rows([
                        Input::make('teacher.first_name')
                                ->title('First Name')
                                ->required()
                                ->placeholder('First Name'),
                        Input::make('teacher.phone')
                                ->title('Phone')
                                ->type('number')
                                ->required(),
                        Input::make('teacher.emergency_contact_name')
                                ->title('Emergency Contact Name')
                                ->placeholder('Enter Emergency Contact Name'),
                        Input::make('teacher.emergency_contact_phone')
                                ->title('Emergency Contact Phone')
                                ->type('number')
                        ]),
                        Layout::rows([
                        Input::make('teacher.last_name')
                                ->title('Last Name')
                                ->required()
                                ->placeholder('Last Name'),
                        Input::make('teacher.email')
                                ->title('Email')
                                ->type('email')
                                ->required()
                                ->placeholder('Enter Email'),
                        DateTimer::make('teacher.date_of_birth')
                                ->title('Date of Birth')
                                ->format('d-m-Y')
                                ->disableTime()
                                ->required(),
                        Select::make('teacher.gender')
                            ->title('Gender')
                            ->options(['Male' => 'Male', 'Female' => 'Female'])
                            ->empty('Select Gender'),
                        ]),
                    ]),
                ],
                'Address'=>[Layout::columns([
                        Layout::rows([
                        TextArea::make('teacher.address')
                                ->title('Address')
                                ->required()
                                ->rows(5)
                                ->placeholder('Address')
                        ]),
                        Layout::rows([
                        Input::make('teacher.city')
                                ->title('City')
                                ->required()
                                ->placeholder('Enter City'),
                        Input::make('teacher.state')
                                ->title('State')
                                ->required()
                                ->placeholder('Enter State'),
                        Input::make('teacher.zip')
                                ->title('ZIP Code')
                                ->type('number')
                                ->required()
                        ]),
                    ]),
                ],
            ]),
            ],
            'Academic'=>[
                Layout::columns([
                        Layout::rows([
                        Select::make('teacher.subject_id')
                            ->title('Subject')
                            ->options($this->allSubjects->pluck('subject_name', 'id')->toArray())
                            ->empty('Select Subject')
                            ->required(),
                        DateTimer::make('teacher.joining_date')
                                ->title('Joining Date')
                                ->format('d-m-Y')
                                ->disableTime()
                                ->required(),
                        TextArea::make('teacher.responsibilities')
                                ->title('Responsibilities')
                                ->required()
                                ->rows(2)
                                ->placeholder('Enter Responsibilities'),
                        TextArea::make('teacher.qualifications')
                                ->title('Qualifications')
                                ->required()
                                ->rows(2)
                                ->placeholder('Enter Qualifications')
                        ]),
                        Layout::rows([    
                        Input::make('teacher.experience')
                                ->title('Experience')
                                ->type('number')
                                ->required(),
                        Input::make('teacher.salary')
                                ->title('Salary')
                                ->required()
                                ->type('number')
                                ->step('0.01')
                                ->pattern('\d+(\.\d{1,2})?'),
                        Input::make('teacher.qualification_degree')
                                ->title('Qualification Degree'),
                        Select::make('teacher.employment_status')
                                ->title('Employment Status')
                                ->options(['Full-time' => 'Full-time', 'Part-time' => 'Part-time'])
                                ->empty('Select Employment Status')
                                ->required(),
                        CheckBox::make('teacher.is_active')
                                ->placeholder('Active Status')
                                ->sendTrueOrFalse()
                        ]),
                    ]),
            ]
        ])
        ];
    }
    public function createOrUpdate(Request $request)
    {
        $teacherData = $request->get('teacher');
        $existingteacherEmail = Teachers::where('email', $teacherData['email'])->first();
        if ($existingteacherEmail && $existingteacherEmail->id !== $this->teacher->id) {
            Toast::warning('Teacher with Email "'.$teacherData['email'].'" is Already Created, Try With New Teacher Email');
            return redirect()->back()->withInput();
        }
        $message = $this->teacher->exists ? ' Was Updated Successfully' : 'Teacher Created Successfully';
        Toast::success($this->teacher['first_name'].' '.$this->teacher['last_name'].$message);
        $this->teacher->fill($teacherData)->save();
        return redirect()->route('platform.teachers');
    }
    public function remove()
    {
        Toast::error($this->teacher['first_name'].' '.$this->teacher['last_name'].' Was Removed Succesfully');
        $this->teacher->delete();
        return redirect()->route('platform.teachers');
    }
}
