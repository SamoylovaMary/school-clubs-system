<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Добавьте этот импорт

class ReportController extends Controller
{
    public function index()
    {
        Log::channel('reports')->info('Просмотр списка отчетов пользователем ID: '.auth()->id());
        
        $reports = Report::where('user_id', auth()->id())->latest()->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        Log::channel('reports')->debug('Открыта форма создания отчета');
        return view('reports.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'data.students_count' => 'required|integer|min:1',
            'data.sports' => 'required|array',
            'data.sports.*.name' => 'required|string',
            'data.sports.*.count' => 'required|integer|min:1',
            'data.events' => 'required|array',
            'data.events.*.name' => 'required|string',
            'data.events.*.date' => 'required|date',
            'data.events.*.document' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        try {
            // Обработка файлов
            $data = $validated['data'];
            foreach ($data['events'] as $index => &$event) {
                $fileKey = "data.events.{$index}.document";
                
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $path = $file->store('reports');
                    $event['document'] = $path;
                    \Log::debug("Файл сохранен: {$path}");
                }
            }

            $report = auth()->user()->reports()->create([
                'data' => $data,
                'status' => 'draft'
            ]);

            \Log::info('Отчет успешно создан', [
                'id' => $report->id,
                'data' => $report->data
            ]);

            return redirect()->route('reports.index')
                ->with('success', 'Отчёт успешно создан!');

        } catch (\Exception $e) {
            \Log::error('Ошибка создания отчета', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Ошибка сохранения: '.$e->getMessage());
        }
    }

    public function show(Report $report)
    {
        Log::channel('reports')->debug('Просмотр отчета', [
            'report_id' => $report->id,
            'user_id' => auth()->id()
        ]);

        abort_if($report->user_id !== auth()->id(), 403);
        return view('reports.show', compact('report'));
    }

    public function adminIndex()
    {
        Log::channel('reports')->info('Админ просматривает отчеты');
        $reports = Report::with('user')->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function approve(Report $report)
    {
        abort_unless(auth()->user()->role === 'admin', 403);
        
        Log::channel('reports')->info('Попытка одобрения отчета', [
            'report_id' => $report->id,
            'admin_id' => auth()->id()
        ]);

        $report->update(['status' => 'approved']);
        
        Log::channel('reports')->info('Отчет одобрен', ['report_id' => $report->id]);
        
        return back()->with('success', 'Отчет успешно одобрен');
    }
}
