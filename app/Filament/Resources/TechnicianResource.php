<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechnicianResource\Pages;
use App\Models\Technician;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Exports\TechniciansExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Actions\Action;


class TechnicianResource extends Resource
{
    protected static ?string $model = Technician::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $modelLabel = 'Technician';

    protected static ?string $navigationGroup = 'Personnel';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_path')
                            ->label('Profile Photo')
                            ->disk('public')
                            ->directory('technicians/photos')
                            ->image()
                            // ->imageEditor()
                            ->maxSize(2048)
                            ->imageResizeTargetWidth(800)
                            ->imageResizeTargetHeight(600)
                            ->columnSpanFull()
                            ->alignCenter(),


                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\TextInput::make('mobile')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Professional Details')
                    ->schema([
                        Forms\Components\TextInput::make('specialization')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('certification_number')
                            ->maxLength(50),

                        Forms\Components\DatePicker::make('certification_expiry')
                            ->native(false),

                        Forms\Components\TextInput::make('hourly_rate')
                            ->numeric()
                            ->prefix('$'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Employment Information')
                    ->schema([
                        Forms\Components\DatePicker::make('hire_date')
                            ->native(false),

                        Forms\Components\DatePicker::make('termination_date')
                            ->native(false),

                        Forms\Components\Toggle::make('active')
                            ->required()
                            ->inline(false),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Address Information')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('city')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('state')
                            ->maxLength(2),

                        Forms\Components\TextInput::make('zip_code')
                            ->maxLength(10),

                        Forms\Components\TextInput::make('country')
                            ->maxLength(50),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Emergency Contact')
                    ->schema([
                        Forms\Components\TextInput::make('emergency_contact_name')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('emergency_contact_phone')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-o-envelope'),

                Tables\Columns\TextColumn::make('specialization')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('hourly_rate')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('certification_expiry')
                    ->date()
                    ->sortable()
                    ->color(fn(string $state): string => now()->parse($state)->isPast() ? 'danger' : 'success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('specialization')
                    ->options(fn() => Technician::query()
                        ->pluck('specialization', 'specialization')
                        ->unique()
                        ->filter()),

                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Technicians'),

                Tables\Filters\Filter::make('certified')
                    ->label('Currently Certified')
                    ->query(fn(Builder $query): Builder => $query
                        ->whereNotNull('certification_number')
                        ->where('certification_expiry', '>', now())),
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        return Excel::download(new TechniciansExport, 'technicians-' . now()->format('Ymd_His') . '.xlsx');
                    }),

                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('danger')
                    ->action(function () {
                        $technicians = Technician::all();

                        $pdf = Pdf::loadView('technicians-report', [
                            'technicians' => $technicians,
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'technicians-' . now()->format('Ymd_His') . '.pdf');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechnicians::route('/'),
            'create' => Pages\CreateTechnician::route('/create'),
            'view' => Pages\ViewTechnician::route('/{record}'),
            'edit' => Pages\EditTechnician::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}