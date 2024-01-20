<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\LessonResource;
use App\Models\CourseLocation;
use App\Models\Lesson;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Lesson::class;

    public function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    Select::make('location')
                        ->required()
                        ->options(CourseLocation::pluck('name')->mapWithKeys(fn($name) => [$name => $name])->toArray())
                        ->searchable()
                        ->preload(),
                    Select::make('course_id')
                        ->relationship('course', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('teacher_id')
                        ->label('Teacher')
                        ->searchable()
                        ->preload()
                        ->options(User::select(['id', 'name'])->get()->mapWithKeys(fn(User $user) => [$user->id => $user->name])->toArray())
                        ->required(),
                    DateTimePicker::make('starts_at')
                        ->native(false)
                        ->required(),
                    DateTimePicker::make('ends_at')
                        ->native(false)
                        ->required(),
                ]),
        ];
    }

    public function fetchEvents(array $info): array
    {
        return Lesson::with([
            'course',
            'teacher',
        ])
            ->where('starts_at', '>=', $info['start'])
            ->where('ends_at', '<=', $info['end'])
            ->get()
            ->map(
                fn(Lesson $lesson) => [
                    'id' => $lesson->id,
                    'title' => $lesson->course->name,
                    'start' => $lesson->starts_at->toDateTimeString(),
                    'end' => $lesson->ends_at->toDateTimeString(),
                    'url' => LessonResource::getUrl(name: 'edit', parameters: [
                        'record' => $lesson->id,
                    ]),
                    'shouldOpenUrlInNewTab' => false,
                ]
            )
            ->all();
    }
}
