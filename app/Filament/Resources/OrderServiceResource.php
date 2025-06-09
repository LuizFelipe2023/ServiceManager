<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderServiceResource\Pages;
use App\Models\Client;
use App\Models\OrderService;
use App\Models\Technician;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderServicesExport;


class OrderServiceResource extends Resource
{
    protected static ?string $model = OrderService::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationLabel = 'Order Services';
    protected static ?string $pluralModelLabel = 'Order Services';
    protected static ?string $modelLabel = 'Order Service';

    protected static ?string $navigationGroup = 'Management'; 

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Basic Information')
                            ->schema([
                                Select::make('client_id')
                                    ->relationship('client', 'name')
                                    ->label('Client')
                                    ->preload()
                                    ->searchable()
                                    ->required(),

                                Select::make('service_type')
                                    ->label('Service Type')
                                    ->options([
                                        'installation' => 'Installation',
                                        'maintenance' => 'Maintenance',
                                        'repair' => 'Repair',
                                        'inspection' => 'Inspection',
                                        'calibration' => 'Calibration',
                                        'emergency' => 'Emergency Service',
                                        'consultation' => 'Consultation',
                                        'preventive' => 'Preventive Maintenance',
                                        'diagnostic' => 'Diagnostic',
                                        'other' => 'Other',
                                    ])
                                    ->required()
                                    ->searchable(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),

                        Section::make('Status & Priority')
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),

                                Select::make('priority')
                                    ->options([
                                        'low' => 'Low',
                                        'medium' => 'Medium',
                                        'high' => 'High',
                                        'emergency' => 'Emergency',
                                    ])
                                    ->required(),

                                Select::make('approval_status')
                                    ->label('Approval Status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required(),

                                Select::make('payment_status')
                                    ->options([
                                        'unpaid' => 'Unpaid',
                                        'partial' => 'Partial',
                                        'paid' => 'Paid',
                                    ])
                                    ->label('Payment Status')
                                    ->required(),
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Scheduling')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('start_date')
                                    ->label('Start Date')
                                    ->displayFormat('M j, Y g:i A'),

                                DateTimePicker::make('end_date')
                                    ->label('End Date')
                                    ->displayFormat('M j, Y g:i A'),
                            ]),
                    ]),

                Section::make('Financial Information')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('estimated_hours')
                                    ->label('Estimated Hours')
                                    ->numeric()
                                    ->suffix('hours'),

                                TextInput::make('actual_hours')
                                    ->label('Actual Hours')
                                    ->numeric()
                                    ->suffix('hours'),

                                TextInput::make('cost_estimate')
                                    ->label('Cost Estimate')
                                    ->numeric()
                                    ->prefix('$'),

                                TextInput::make('final_cost')
                                    ->label('Final Cost')
                                    ->numeric()
                                    ->prefix('$'),
                            ]),
                    ]),

                Section::make('Additional Information')
                    ->schema([
                        TextInput::make('location')
                            ->label('Location')
                            ->columnSpanFull(),

                        Textarea::make('equipment_needed')
                            ->label('Equipment Needed')
                            ->columnSpanFull(),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ]),

                Section::make('Assigned Technicians')
                    ->schema([
                        MultiSelect::make('technicians')
                            ->label('Technicians')
                            ->relationship('technicians', 'first_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('service_type')
                    ->label('Service Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'warning',
                        'emergency' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->dateTime('M j, Y g:i A'),

                TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        'paid' => 'success',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'emergency' => 'Emergency',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),

                Action::make('generate_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->action(function (OrderService $order) {
                        $pdf = Pdf::loadView('PdfOrder', [
                            'order' => $order
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'service-request-' . now()->format('Ymd_His') . '.pdf');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->headerActions([
                Action::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        return Excel::download(new OrderServicesExport, 'order-services-' . now()->format('Ymd_His') . '.xlsx');
                    }),
                Action::make('export_all_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->action(function () {
                        $orders = OrderService::with('client')->get();

                        $pdf = Pdf::loadView('all-orders-table', [
                            'orders' => $orders,
                        ]);

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'all-service-orders-' . now()->format('Ymd_His') . '.pdf');
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderServices::route('/'),
            'create' => Pages\CreateOrderService::route('/create'),
            'edit' => Pages\EditOrderService::route('/{record}/edit'),
        ];
    }
}