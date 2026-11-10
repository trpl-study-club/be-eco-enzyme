<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_application_default_locale_is_indonesian(): void
    {
        $this->assertSame('id', app()->getLocale());
    }

    public function test_validation_errors_use_polite_indonesian(): void
    {
        $validator = Validator::make(
            ['title' => '', 'email' => 'bukan-email'],
            [
                'title' => 'required',
                'email' => 'email',
            ]
        );

        $this->assertTrue($validator->fails());

        $errors = $validator->errors();
        $this->assertSame('Judul wajib diisi.', $errors->first('title'));
        $this->assertSame('Alamat email harus berupa alamat email yang valid dan aktif (contoh: nama@domain.com).', $errors->first('email'));
    }

    public function test_login_failure_returns_friendly_indonesian_message(): void
    {
        $response = $this->post('/login', [
            'email' => 'tidakada@desa.id',
            'password' => 'kata-sandi-salah',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Alamat email atau kata sandi yang Anda masukkan salah. Silakan periksa kembali isian Anda.',
        ]);
    }
}
