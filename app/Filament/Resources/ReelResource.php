<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Reel;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReelResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReelResource\RelationManagers;

class ReelResource extends Resource
{
    protected static ?string $model = Reel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->rules('min:3|max:50')
                ->live(onBlur: true)
                ->required()
                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                    if ($operation === 'edit') {
                        return;
                    }

                    $set('slug', Str::slug($state));
                }),
                TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                FileUpload::make('image')
                ->image()
                ->imageEditor(),
                RichEditor::make('content')->disableToolbarButtons(['attachFiles'])->columnSpanFull(),
            ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            // ->query(fn (Builder $query) => $query->where('user_id', auth()->id()))
            ->columns([
                TextColumn::make('title')
                ->description(fn (Reel $record) => Str::limit($record->content, 50))
                ->searchable(),
                TextColumn::make('user.name')->label('created by'),
                ImageColumn::make('image')
                ->size(40)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
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
            'index' => Pages\ListReels::route('/'),
            'create' => Pages\CreateReel::route('/create'),
            'edit' => Pages\EditReel::route('/{record}/edit'),
        ];
    }
}
