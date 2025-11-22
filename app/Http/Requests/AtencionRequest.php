<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtencionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_estudiante' => 'required|exists:estudiantes,id_estudiante',
            'id_tema' => 'required|exists:temas,id_tema',
            'semestre' => 'required|string|max:10',
            'fecha_atencion' => 'required|date',
            'hora_atencion' => 'required|date_format:H:i',
            'consulta_estudiante' => 'required|string',
            'descripcion_atencion' => 'required|string',
            'evidencia' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // 10MB
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id_docente.required' => 'Debe seleccionar un docente',
            'id_docente.exists' => 'El docente seleccionado no existe',
            'id_estudiante.required' => 'Debe seleccionar un estudiante',
            'id_estudiante.exists' => 'El estudiante seleccionado no existe',
            'id_tema.required' => 'Debe seleccionar un tema',
            'id_tema.exists' => 'El tema seleccionado no existe',
            'semestre.required' => 'El semestre es obligatorio',
            'semestre.max' => 'El semestre no puede exceder 10 caracteres',
            'fecha_atencion.required' => 'La fecha de atención es obligatoria',
            'fecha_atencion.date' => 'La fecha de atención debe ser una fecha válida',
            'hora_atencion.required' => 'La hora de atención es obligatoria',
            'hora_atencion.date_format' => 'La hora debe tener el formato HH:MM',
            'consulta_estudiante.required' => 'La consulta del estudiante es obligatoria',
            'descripcion_atencion.required' => 'La descripción de la atención es obligatoria',
            'evidencia.file' => 'La evidencia debe ser un archivo',
            'evidencia.mimes' => 'La evidencia debe ser un archivo PDF, imagen o documento Word',
            'evidencia.max' => 'La evidencia no puede superar los 10 MB',
        ];
    }
}
