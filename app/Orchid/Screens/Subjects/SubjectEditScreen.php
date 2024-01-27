<?php

namespace App\Orchid\Screens\Subjects;

use App\Models\Subjects;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SubjectEditScreen extends Screen
{
    public $subject;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Subjects $subject): iterable
    {
        return [
            'subject' => $subject,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->subject->exists ? 'Edit Subject' : 'Create Subject';
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
                ->canSee(!$this->subject->exists),

            Button::make('Update')
                ->icon('bs.pencil')
                ->method('createOrUpdate')
                ->canSee($this->subject->exists),

            Button::make('Remove')
                ->icon('bs.trash3')
                ->method('remove')
                ->canSee($this->subject->exists)
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
                Input::make('subject.subject_name')
                        ->title('Subject Name')
                        ->required()
                        ->placeholder('Enter Subject Name')
                ]),
                Layout::rows([
                    Input::make('subject.subject_code')
                            ->title('Subject Code')
                            ->required()
                            ->placeholder('Enter Subject Code')
                ]),
            ]),
        ];
    }
    public function createOrUpdate(Request $request)
    {
        $subjectData = $request->get('subject');
        $existingSubjectName = Subjects::where('subject_name', $subjectData['subject_name'])->first();
        $existingSubjectCode = Subjects::where('subject_code', $subjectData['subject_code'])->first();
        if ($existingSubjectName && $existingSubjectName->id !== $this->subject->id) {
            Toast::warning('Subject with Subject Name "'.$subjectData['subject_name'].'" is Already Created, Try With New Subject Name');
            return redirect()->back()->withInput();
        }
        if ($existingSubjectCode && $existingSubjectCode->id !== $this->subject->id) {
            Toast::warning('Subject with Subject Code "'.$subjectData['subject_code'].'" is Already Created, Try With New Subject Code');
            return redirect()->back()->withInput();
        }
        $message = $this->subject->exists ? 'Was Updated Successfully' : 'Subject Created Successfully';
        Toast::success($this->subject['subject_name'] . ' ' . $message);
        $this->subject->fill($subjectData)->save();
        return redirect()->route('platform.subjects');
    }
    public function remove()
    {
        Toast::error($this->subject['subject_name'].' Was Removed Succesfully');
        $this->subject->delete();
        return redirect()->route('platform.subjects');
    }
}
