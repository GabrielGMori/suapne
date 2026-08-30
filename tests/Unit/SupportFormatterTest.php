<?php

use App\Support\Formatter;

test('Formatter formats CPF properly', function () {
    expect(Formatter::cpf('12345678901'))->toBe('123.456.789-01')
        ->and(Formatter::cpf('123.456.789-01'))->toBe('123.456.789-01')
        ->and(Formatter::cpf(null))->toBeNull();
});

test('Formatter formats phone numbers properly', function () {
    expect(Formatter::telefone('4199998888'))->toBe('+55 (41) 9999-8888')
        ->and(Formatter::telefone('41999998888'))->toBe('+55 (41) 99999-8888')
        ->and(Formatter::telefone('5541999998888'))->toBe('+55 (41) 99999-8888')
        ->and(Formatter::telefone(null))->toBeNull();
});

test('Formatter formats dates and datetimes properly', function () {
    expect(Formatter::date('2026-08-30'))->toBe('30/08/2026')
        ->and(Formatter::datetime('2026-08-30 14:30:00'))->toBe('30/08/2026 às 14:30')
        ->and(Formatter::date(null))->toBeNull()
        ->and(Formatter::datetime(null))->toBeNull();
});

test('Formatter formats json strings properly', function () {
    $raw = '{"key":"value","items":[1,2]}';
    $formatted = Formatter::json($raw);

    expect($formatted)->toContain('"key": "value"')
        ->and(Formatter::json(null))->toBeNull();
});

test('Formatter format dispatcher works for attributes', function () {
    expect(Formatter::format('cpf', '12345678901'))->toBe('123.456.789-01')
        ->and(Formatter::format('telefone', '41999998888'))->toBe('+55 (41) 99999-8888')
        ->and(Formatter::format('data_nascimento', '2000-01-15'))->toBe('15/01/2000')
        ->and(Formatter::format('created_at', '2026-08-30 10:00:00'))->toBe('30/08/2026 às 10:00')
        ->and(Formatter::format('nome', null))->toBe('—')
        ->and(Formatter::format('nome', 'Maria'))->toBe('Maria');
});
