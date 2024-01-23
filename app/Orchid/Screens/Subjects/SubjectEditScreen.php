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
        return $this->subject->exists ? 'Edit subject' : 'Create subject';
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
        $existingSubject = Subjects::where('subject_code', $subjectData['subject_code'])->first();

        if ($existingSubject && $existingSubject->id !== $this->subject->id) {
            Toast::warning('Subject with Subject Code "'.$subjectData['subject_code'].'" is Already Created, Try With New Subject Code');
            return redirect()->back();
        }
        $this->subject->fill($subjectData)->save();
        $this->subject->exists ? Toast::success($this->subject['subject_name'].' Was Updated Successfully') : Toast::info('Subject Created Successfully');
        return redirect()->route('platform.subjects');
    }
    public function remove()
    {
        Toast::error($this->subject['subject_name'].' Was Removed Succesfully');
        $this->subject->delete();
        return redirect()->route('platform.subjects');
    }
}
