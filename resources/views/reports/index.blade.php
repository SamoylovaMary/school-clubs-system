@extends('layouts.app')

@section('content')
<div class="container py-4"> 
    
    <a href="{{ route('reports.create') }}" class="btn btn-primary mb-4"> 
        + Создать новый отчет
    </a>

    <div class="reports-list"> 
        @forelse ($reports as $report)
            <div class="card mb-4"> 
                <div class="card-body">
                    <h5 class="card-title mb-3"> 
                        Отчет №{{ $report->id }}
                        <span class="badge bg-{{ $report->status === 'approved' ? 'success' : 'warning' }} ms-2"> 
                            {{ $report->status === 'approved' ? 'Утверждён' : 'Черновик' }}
                        </span>
                    </h5>
                    
                    <div class="d-flex gap-2"> 
                        @if($report->status === 'draft')
                            <a href="{{ route('reports.edit', $report) }}" class="btn btn-sm btn-warning">
                                Редактировать
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info py-3"> 
                У вас пока нет созданных отчетов.
            </div>
        @endforelse
    </div>
</div>
@endsection




