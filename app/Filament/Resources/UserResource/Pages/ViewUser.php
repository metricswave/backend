<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User')
                    ->description('User details.')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('created_at'),
                        TextEntry::make('updated_at'),
                    ])
                    ->collapsible(),
                RepeatableEntry::make('all_teams')
                    ->columns(['sm' => 3])
                    ->schema([
                        TextEntry::make('domain')
                            ->columnSpan(2),
                        TextEntry::make('subscription_status')
                            ->label('Subscribed')
                            ->state(fn ($record): string => $record->subscription_plan_id->name()),
                        TextEntry::make('weekly_visits_count')
                            ->label('Weekly Visits')
                            ->state(fn ($record): string => $record->triggerNotificationVisits()->period('week')->count()),
                        TextEntry::make('monthly_visits_count')
                            ->label('Monthly Visits')
                            ->state(fn ($record): string => $record->triggerNotificationVisits()->period('month')->count()),
                        TextEntry::make('yearly_visits_count')
                            ->label('Yearly Visits')
                            ->state(fn ($record): string => $record->triggerNotificationVisits()->period('year')->count()),
                        TextEntry::make('dashboard_counts')
                            ->label('Dashboards')
                            ->state(fn ($record): string => $record->dashboards->count()),
                        TextEntry::make('triggers_count')
                            ->label('Triggers')
                            ->state(fn ($record): string => $record->triggers->count()),
                        TextEntry::make('users_count')
                            ->label('Users')
                            ->state(fn ($record): string => $record->users->count()),
                    ]),
            ]);
    }
}
