<?php

namespace App\Orchid\Layouts\Teachers;

use App\Models\Teachers;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TeacherListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'teachers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('first_name','First Name'),
            TD::make('last_name','Last Name'),
            TD::make('subject_id','Subject')
            ->render(function (Teachers $teacher) {
                return $teacher->subject_id ? $teacher->subject->subject_name : 'NA';
            }),
            TD::make('email','Email'),
            TD::make('phone','Phone'),
            TD::make('joining_date', 'Joining Date')
                ->render(function (Teachers $teacher) {
                    return \Carbon\Carbon::parse($teacher->joining_date)->format('d-m-Y');
            }),
            TD::make('address', 'Address')
                ->render(function (Teachers $teacher) {
                    return $teacher->address.', '.$teacher->city.', '.$teacher->state.' - '.$teacher->zip;
            }),
            TD::make('qualifications','Qualifications'),
            TD::make('experience','Experience'),
            TD::make('salary','Salary'),
            TD::make('qualification_degree','Qualification Degree')
            ->render(function (Teachers $teacher) {
                return $teacher->qualification_degree ? $teacher->qualification_degree : 'NA';
            }),
            TD::make('employment_status','Employment Status'),
            TD::make('responsibilities','Responsibilities')
            ->render(function (Teachers $teacher) {
                return $teacher->responsibilities ? $teacher->responsibilities : 'NA';
            }),
            TD::make('emergency_contact_name','Emergency Contact Name')
            ->render(function (Teachers $teacher) {
                return $teacher->emergency_contact_name ? $teacher->emergency_contact_name : 'NA';
            }),
            TD::make('emergency_contact_phone','Emergency Contact Phone')
            ->render(function (Teachers $teacher) {
                return $teacher->emergency_contact_phone ? $teacher->emergency_contact_phone : 'NA';
            }),
            TD::make('date_of_birth', 'Date Of Birth')
            ->render(function (Teachers $teacher) {
                return \Carbon\Carbon::parse($teacher->date_of_birth)->format('d-m-Y');
            }),
            TD::make('gender','Gender')
            ->render(function (Teachers $teacher) {
                return $teacher->gender ? $teacher->gender : 'NA';
            }),
            TD::make('is_active','Active Status')
            ->render(function (Teachers $teacher) {
                return $teacher->is_active ? 'Active' : 'Inactive';
            }),
            TD::make('Actions')
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(fn (Teachers $teacher) => DropDown::make()
                ->icon('bs.three-dots-vertical')
                ->list([
                    Link::make('Edit')
                        ->route('platform.teachers.edit', $teacher)
                        ->icon('bs.pencil'),
                    Button::make('Remove')
                        ->icon('bs.trash3')
                        ->confirm($teacher['first_name'].' '.$teacher['last_name'].' Will be Removed Forever')
                        ->method('remove', ['id' => $teacher->id,]),
                ])),
        ];
    }
}
