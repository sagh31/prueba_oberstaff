<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Company $company)
    {
        abort_if(Auth::user()->company_id !== $company->id, 403);

        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return redirect()
            ->route('home')
            ->with('status', 'Datos de la empresa actualizados correctamente.');
    }

    public function downloadPdf(Request $request): Response
    {
        $user = $request->user();
        $company = $user->company;

        abort_if(!$company, 404, 'El usuario no pertenece a ninguna empresa.');

        $pdf = Pdf::loadView('companies.pdf', [
            'user' => $user,
            'company' => $company,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('datos_usuario_empresa.pdf');
    }

    public function downloadPdfFromImages(Request $request): Response
    {
        $validated = $request->validate([
            'image_user' => ['required', 'string', 'starts_with:data:image/png;base64,'],
            'image_company' => ['required', 'string', 'starts_with:data:image/png;base64,'],
        ]);

        $pdf = Pdf::loadView('companies.pdf_images', [
            'imageUser' => $validated['image_user'],
            'imageCompany' => $validated['image_company'],
        ])->setPaper('a4', 'portrait');

        return $pdf->download('datos_usuario_empresa.pdf');
    }
}
