<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Supports\CreateSupportDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Support;
use App\Services\SupportService;
use App\DTO\Supports\UpdateSupportDTO;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function __construct(protected SupportService $service)
    {
    }

    public function index(Request $request)
    {
        $supports = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter
        );

        $filters = ['filter' => $request->get('filter', '')];

        return view('admin/supports/index', compact('supports', 'filters'));
    }

    public function create()
    {
        return view('admin/supports/create');
    }

    public function store(StoreUpdateRequest $request)
    {
        $this->service->new(CreateSupportDTO::makeFromRequest($request));

        return redirect()->route('supports.index')
                        ->with('message', 'Cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        // Support::find($id);
        // Support::where('id', $id)->first();
        // support::where('id', '!=', $id)->first();
        if (!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports/show', compact('support'));
    }

    public function edit(string $id)
    {
        if (!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports/edit', compact('support'));
    }

    public function update(string|int $id, Support $support, StoreUpdateRequest $request)
    {

        $support = $this->service->update(UpdateSupportDTO::makeFromRequest($request));

        if (!$support) {
            return back();
        }

        return redirect()->route('supports.index')
                        ->with('message', 'Atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);

        return redirect()->route('supports.index');
    }
}
