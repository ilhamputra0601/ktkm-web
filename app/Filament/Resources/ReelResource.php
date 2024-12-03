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
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $pluralModelLabel = 'Katar Reel';

    protected static ?string $navigationGroup = 'Posting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                TextInput::make('title')->rules('min:3|max:50')
                ->live(onBlur: true)
                ->required()
                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                    if ($operation === 'edit') {
                        return;
                    }

                    // Generate basic slug
                    $slug = Str::slug($state);

                    // Check uniqueness and append a number if necessary
                    $count = Reel::where('slug', 'like', "$slug%")->count();
                    $uniqueSlug = $count > 0 ? "{$slug}-" . ($count + 1) : $slug;

                    $set('slug', $uniqueSlug);
                }),
                Hidden::make('slug')->unique(ignoreRecord: true)
                ->required(),
                FileUpload::make('images')
                    ->label('Gambar')
                    ->image()
                    ->optimize('webp')
                    ->multiple()
                    ->directory('reel-images')
                    ->image()
                    ->imageEditor(),
                RichEditor::make('content')
                    ->label('Deskripsi')
                    ->disableToolbarButtons(['attachFiles'])
                    ->columnSpanFull(),
                Toggle::make('published')
                    ->label('Publikasikan')
                    ->onColor('success')
                    ->offColor('danger')
                ])
            ]);
        }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('title')
                ->label('Judul')
                ->description(fn (Reel $record) => Str::limit($record->content, 50))
                ->searchable(),
                TextColumn::make('user.name')
                ->label('Kreator'),
                ImageColumn::make('images')
                ->label('Gambar')
                ->circular()
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(),
                IconColumn::make('published')
                ->label('Dipublikasikan')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->successNotification(
                Notification::make()
                ->success()
                ->title('Postingan Dihapus')
                ->body(auth()->user()->name . ' Menghapus Reel')
                ->sendToDatabase(auth()->user())),
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

    public static function getEloquentQuery(): Builder
    {
        // Allow superAdmin to see all records
        if (auth()->user()->hasRole(['Developer','Admin'])) {
            return parent::getEloquentQuery();
        }

        // Restrict others to only see their own reels
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
