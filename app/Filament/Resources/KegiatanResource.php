<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarKegiatanResource\Pages;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = "Daftar Kegiatan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required()
                    ->maxLength(255)
                    ->rows(4),
                Forms\Components\TextInput::make('kuota')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuota')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'submitted' => 'info',
                        'under_review' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        default => ucfirst($state),
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('pembuat.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('set-under-review')
                    ->label('Mark as Under Review')
                    ->visible(
                        fn($record) =>
                        $record->status === 'submitted'
                    )
                    ->action(fn($record) => $record->update(['status' => 'under_review']))
                    ->color('warning'),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->visible(
                        fn($record) =>
                        $record->status === 'submitted'
                    )
                    ->action(fn($record) => $record->update(['status' => 'approved']))
                    ->color('success'),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->visible(
                        fn($record) =>
                        $record->status === 'submitted'
                    )
                    ->action(fn($record) => $record->update(['status' => 'rejected']))
                    ->color('danger'),

                Tables\Actions\EditAction::make()
                    ->visible(
                        fn($record) =>
                        $record->status !== 'approved'
                    ),
            ])
            ->recordUrl(function ($record) {
                return $record->pembuat->role === 'admin' ? url()->current() : null;
            })


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarKegiatans::route('/'),
            'create' => Pages\CreateDaftarKegiatan::route('/create'),
            'edit' => Pages\EditDaftarKegiatan::route('/{record}/edit'),
        ];
    }
}
