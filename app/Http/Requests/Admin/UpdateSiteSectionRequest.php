<?php

namespace App\Http\Requests\Admin;

use App\Models\SiteSection;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSectionRequest extends FormRequest
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
        $rules = [
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:50000'],
        ];

        $section = $this->route('site_section');
        if ($section instanceof SiteSection && $this->isNosotrosPageBlock($section->key)) {
            $rules['nikitos_image'] = ['nullable', 'string', 'max:255'];
            $rules['image_alt'] = ['nullable', 'string', 'max:500'];
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
            $rules['remove_block_image'] = ['sometimes', 'boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La imagen no puede superar 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $section = $this->route('site_section');
        if (! $section instanceof SiteSection || ! $this->isNosotrosPageBlock($section->key)) {
            return;
        }

        $this->merge([
            'remove_block_image' => $this->boolean('remove_block_image'),
        ]);
    }

    private function isNosotrosPageBlock(string $key): bool
    {
        return in_array($key, SiteSection::NOSOTROS_PAGE_BLOCK_KEYS, true);
    }
}
