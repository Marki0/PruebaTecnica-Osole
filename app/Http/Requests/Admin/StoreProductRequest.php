<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string', 'max:10000'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery' => ['nullable', 'array', 'max:12'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Elegí una categoría.',
            'category_id.exists' => 'La categoría no es válida.',
            'name.required' => 'El nombre es obligatorio.',
            'slug.unique' => 'Ese slug ya está en uso.',
            'image.image' => 'La imagen principal debe ser un archivo de imagen válido.',
            'gallery.*.image' => 'Cada archivo de galería debe ser una imagen válida.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug');
        if ($slug === null || trim((string) $slug) === '') {
            $this->merge(['slug' => null]);
        }

        if ($this->missing('sort_order') || $this->input('sort_order') === '' || $this->input('sort_order') === null) {
            $this->merge(['sort_order' => 0]);
        }

        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
