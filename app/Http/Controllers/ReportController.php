<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        try {
            $reports = auth()->user()->reports()->latest()->get();
            Log::channel('reports')->info('Reports fetched', [
                'user_id' => auth()->id(),
                'count' => $reports->count()
            ]);
            return view('reports.index', compact('reports'));
        } catch (\Exception $e) {
            Log::channel('reports')->error('Failed to fetch reports', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id() ?? 'null'
            ]);
            return back()->with('error', 'Ошибка при загрузке отчётов');
        }
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            Log::channel('reports')->debug('Store method started', [
                'user_id' => auth()->id(),
                'request_data' => $request->except(['_token', 'files'])
            ]);

            // Проверка аутентификации
            if (!auth()->check()) {
                throw new \Exception('Пользователь не аутентифицирован');
            }

            // Проверка наличия данных
            if (!$request->has('data')) {
                throw new \Exception('Отсутствует data в запросе');
            }

            $validator = Validator::make($request->all(), [
                'data.students_count' => 'required|integer|min:1',
                'data.sports' => 'required|array|min:1',
                'data.sports.*.name' => 'required|string',
                'data.sports.*.count' => 'required|integer|min:1',
                'data.events' => 'required|array|min:1',
                'data.events.*.name' => 'required|string',
                'data.events.*.date' => 'required|date',
                'data.events.*.document' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
            ]);

            if ($validator->fails()) {
                Log::channel('reports')->error('Validation failed', [
                    'errors' => $validator->errors()->all(),
                    'user_id' => auth()->id()
                ]);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            $data = $validated['data'];

            // Обработка файлов
            foreach ($data['events'] as $index => &$event) {
                $fileKey = "data.events.{$index}.document";
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $path = $file->store('reports', 'public');
                    $event['document'] = $path;
                    Log::channel('reports')->debug('File stored', [
                        'path' => $path,
                        'size' => $file->getSize()
                    ]);
                }
            }

            // Создание отчета
            $report = auth()->user()->reports()->create([
                'data' => $data,
                'status' => 'draft'
            ]);

            if (!$report->exists) {
                throw new \Exception('Отчёт не был создан в базе данных');
            }

            // Проверка связи с пользователем
            if (!$report->user) {
                throw new \Exception('Связь с пользователем не установлена');
            }

            DB::commit();

            Log::channel('reports')->info('Report created successfully', [
                'report_id' => $report->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('reports.index')
                ->with('success', 'Отчёт успешно создан!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::channel('reports')->error('Report creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id() ?? 'null'
            ]);

            return redirect()->back()
                ->with('error', 'Ошибка при сохранении отчёта: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Report $report)
    {
        $this->authorize('view', $report);
        
        return view('reports.show', compact('report'));
    }

    public function adminShow(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function adminIndex()
    {
        try {
            $reports = Report::with('user')->latest()->paginate(10);
            return view('admin.reports.index', compact('reports'));
        } catch (\Exception $e) {
            Log::channel('reports')->error('Failed to fetch admin reports', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Ошибка при загрузке отчётов');
        }
    }

    public function approve(Report $report)
    {
        DB::beginTransaction();
        
        try {
            $this->authorize('approve', $report);
            
            $report->update(['status' => 'approved']);
            
            Log::channel('reports')->info('Report approved', [
                'report_id' => $report->id,
                'admin_id' => auth()->id()
            ]);
            
            DB::commit();
            
            return back()->with('success', 'Отчёт утверждён');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::channel('reports')->error('Failed to approve report', [
                'error' => $e->getMessage(),
                'report_id' => $report->id ?? 'null'
            ]);
            
            return back()->with('error', 'Ошибка при утверждении отчёта');
        }
    }

    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    
    public function update(Request $request, Report $report)
    {
        if (auth()->id() !== $report->user_id && !auth()->user()->isAdmin) {
            abort(403, 'У вас нет прав на редактирование этого отчёта');
        }
        
        $report->update($request->all());
        return redirect()->back();
    }
}





