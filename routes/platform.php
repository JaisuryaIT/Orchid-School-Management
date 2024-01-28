<?php

declare(strict_types=1);

use App\Orchid\Layouts\ExamTypes\ExamTypeListLayout;
use App\Orchid\Screens\Classes\ClassEditScreen;
use App\Orchid\Screens\Classes\ClassListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\ExamTypes\ExamTypeEditScreen;
use App\Orchid\Screens\ExamTypes\ExamTypeListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Subjects\SubjectEditScreen;
use App\Orchid\Screens\Subjects\SubjectListScreen;
use App\Orchid\Screens\Teachers\TeacherEditScreen;
use App\Orchid\Screens\Teachers\TeacherListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Year\YearEditScreen;
use App\Orchid\Screens\Year\YearListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main',  SubjectListScreen::class)
    ->name('platform.main')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Subjects'));

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

Route::screen('subjects', SubjectListScreen::class)
    ->name('platform.subjects')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Subjects'));
            
Route::screen('subject/{subject?}', SubjectEditScreen::class)
    ->name('platform.subjects.edit')
    ->breadcrumbs(function (Trail $trail, $subject = null) {
        $trail->parent('platform.index')
            ->push('Subjects', route('platform.subjects'))
            ->push($subject ? 'Edit Subject' : 'Create Subject');
    });

Route::screen('years', YearListScreen::class)
    ->name('platform.years')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Year'));
            
Route::screen('year/{year?}', YearEditScreen::class)
    ->name('platform.years.edit')
    ->breadcrumbs(function (Trail $trail, $year = null) {
        $trail->parent('platform.index')
            ->push('Year', route('platform.years'))
            ->push($year ? 'Edit Academic Year' : 'Create Academic Year');
    });

Route::screen('exam_types', ExamTypeListScreen::class)
    ->name('platform.exam_types')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Exam Types'));
            
Route::screen('exam_type/{exam_type?}', ExamTypeEditScreen::class)
    ->name('platform.exam_types.edit')
    ->breadcrumbs(function (Trail $trail, $exam_type = null) {
        $trail->parent('platform.index')
            ->push('Exam Types', route('platform.exam_types'))
            ->push($exam_type ? 'Edit Exam Type' : 'Create Exam Type');
    });

Route::screen('teachers', TeacherListScreen::class)
    ->name('platform.teachers')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Teachers'));
            
Route::screen('teacher/{teacher?}', TeacherEditScreen::class)
    ->name('platform.teachers.edit')
    ->breadcrumbs(function (Trail $trail, $teacher = null) {
        $trail->parent('platform.index')
            ->push('Teachers', route('platform.teachers'))
            ->push($teacher ? 'Edit Teacher' : 'Create Teacher');
    });

Route::screen('classes', ClassListScreen::class)
    ->name('platform.classes')
    ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Classes'));
            
Route::screen('class/{class?}', ClassEditScreen::class)
    ->name('platform.classes.edit')
    ->breadcrumbs(function (Trail $trail, $class = null) {
        $trail->parent('platform.index')
            ->push('Classes', route('platform.classes'))
            ->push($class ? 'Edit Class' : 'Create Class');
    });