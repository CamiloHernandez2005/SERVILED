<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function downloadFile()
    {
        $filePath = storage_path('app/public/template/Plantilla_importar_personas.xlsx');
        return response()->download($filePath);
    }

    public function downloadFileCategory()
    {
        $filePath = storage_path('app/public/template/planilla_importar_categorías.xlsx');
        return response()->download($filePath);
    }

    public function downloadFileBrands()
    {
        $filePath = storage_path('app/public/template/planilla_importar_marcas.xlsx');
        return response()->download($filePath);
    }

    public function downloadFileUnits()
    {
        $filePath = storage_path('app/public/template/planilla_importar_unidades.xlsx');
        return response()->download($filePath);
    }

    public function downloadFileSubcategory()
    {
        $filePath = storage_path('app/public/template/planilla_importar_subcategorias.xlsx');
        return response()->download($filePath);
    }

    public function downloadFileProduct()
    {
        $filePath = storage_path('app/public/template/planilla_importar_productos.xlsx');
        return response()->download($filePath);
    }

    public function downloadManualUser()
    {
        $filePath = storage_path('app/public/template/Manual_de_usuario_final.pdf');
        return response()->download($filePath);
    }

    public function downloadManualAdmin()
    {
        $filePath = storage_path('app/public/template/Manual_de_administrador_final.pdf');
        return response()->download($filePath);
    }

    public function downloadMapaSitio()
    {
        $filename = 'Mapa_sitios.drawio.png';
        $filePath = public_path('img/mapa/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->download($filePath, $filename, [
            'Content-Type' => mime_content_type($filePath)
        ]);
    }
}
