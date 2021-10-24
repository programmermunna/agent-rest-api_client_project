<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BetsTogelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules() : array
    {
		return [
			"type"                                => ["required", 'string'],
			"provider"                            => ["required", "string"],
			"data"                                => ['required', 'array'],
			"data.*.number_1"                     => ['nullable', 'numeric'],
			"data.*.number_2"                     => ['nullable', 'numeric'],
			"data.*.number_3"                     => ['nullable', 'numeric'],
			"data.*.number_4"                     => ['nullable', 'numeric'],
			"data.*.number_5"                     => ['nullable', 'numeric'],
			"data.*.number_6"                     => ['nullable', 'numeric'],
			"data.*.tebak_as_kop_kepala_ekor"     => ['nullable', 'string'],
			"data.*.tebak_besar_kecil"            => ['nullable', 'string'],
			"data.*.tebak_genap_ganjil"           => ['nullable', 'string'],
			"data.*.tebak_tengah_tepi"            => ['nullable', 'string'],
			"data.*.tebak_depan_tengah_belakang"  => ['nullable', 'string'],
			"data.*.tebak_mono_stereo"            => ['nullable', 'string'],
			"data.*.tebak_kembang_kempis_kembar"  => ['nullable', 'string'],
			"data.*.tebak_shio"                   => ['nullable', 'string'],
			"data.*.bet_amount"                   => ['nullable', 'string'],
			"data.*.tax_amount"                   => ['nullable', 'string'],
			"data.*.pay_amout"                    => ['nullable', 'string'],
		];
    }
}
