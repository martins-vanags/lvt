<?php

namespace App\Filament\Admin\Resources\CourseLocationResource\Pages;

use App\Filament\Admin\Resources\CourseLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseLocations extends ListRecords
{
    protected static string $resource = CourseLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
