<?php

namespace App\Console\Commands;

use App\Models\Producto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportProductosExcel extends Command
{
    protected $signature = 'productos:import-excel
        {file : Ruta del Excel a importar}
        {--commit : Graba los cambios. Sin esta opcion solo valida}
        {--update : Actualiza productos existentes por isbn+idioma_id si los encuentra}';

    protected $description = 'Importa productos desde un Excel con cabeceras equivalentes a la tabla productos';

    private array $headerMap = [
        'tipo' => 'tipo',
        'isbn' => 'isbn',
        'material cubierta' => 'materialcubierta',
        'gramageinterior' => 'gramajeinterior',
        'gramagecubierta' => 'gramajecubierta',
        'impresion' => 'impresion',
        'impresión' => 'impresion',
        'pallet' => 'pallet',
    ];

    private array $columns = [
        'cliente_id', 'tipo', 'productoestado', 'isbn', 'idioma_id', 'referencia', 'tirada',
        'formato', 'FSC', 'tipoimpresion', 'materialinterior', 'tintainterior',
        'gramajeinterior', 'paginas', 'materialcubierta', 'tintacubierta',
        'gramajecubierta', 'plastificado', 'encuadernado', 'solapa', 'descripsolapa',
        'guardas', 'descripguardas', 'cd', 'descripcd', 'novedad', 'descripnovedad',
        'caja_id', 'etiqueta', 'udxcaja', 'preciocoste', 'precioventa', 'material',
        'medidas', 'troquel', 'impresion', 'desarrollocaja', 'gramajecaja',
        'acabadocaja', 'medidasnido', 'materialnido', 'impresionnido', 'procesospack',
        'manipulacion', 'observaciones',
    ];

    public function handle(): int
    {
        $file = $this->argument('file');

        if (! is_file($file)) {
            $this->error("No existe el archivo: {$file}");
            return self::FAILURE;
        }

        $reader = IOFactory::createReaderForFile($file);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getSheetByName('Hoja1') ?? $spreadsheet->getSheet(0);
        $rows = $sheet->toArray(null, true, true, true);

        if (count($rows) < 2) {
            $this->error('El Excel no tiene filas para importar.');
            return self::FAILURE;
        }

        $headers = $this->headers(array_shift($rows));
        $errors = [];
        $payloads = [];

        foreach ($rows as $excelRow => $row) {
            $data = $this->mapRow($headers, $row);

            if ($this->isEmptyRow($data)) {
                continue;
            }

            $rowNumber = $excelRow + 1;
            $rowErrors = $this->validateRow($data);

            if ($rowErrors) {
                foreach ($rowErrors as $error) {
                    $errors[] = "Fila {$rowNumber}: {$error}";
                }
                continue;
            }

            $payloads[] = $data;
        }

        if ($errors) {
            foreach (array_slice($errors, 0, 30) as $error) {
                $this->error($error);
            }

            if (count($errors) > 30) {
                $this->error('... y '.(count($errors) - 30).' errores mas.');
            }

            return self::FAILURE;
        }

        $this->info('Productos validados: '.count($payloads));

        if (! $this->option('commit')) {
            $this->warn('Dry-run: no se ha grabado nada. Repite con --commit para importar.');
            return self::SUCCESS;
        }

        DB::transaction(function () use ($payloads) {
            foreach ($payloads as $data) {
                if ($this->option('update') && ! empty($data['isbn'])) {
                    Producto::updateOrCreate(
                        ['isbn' => $data['isbn'], 'idioma_id' => $data['idioma_id'] ?? 1],
                        $data
                    );
                    continue;
                }

                Producto::create($data);
            }
        });

        $this->info('Importacion completada: '.count($payloads).' productos.');

        return self::SUCCESS;
    }

    private function headers(array $row): array
    {
        $headers = [];

        foreach ($row as $column => $value) {
            $key = $this->normalizeHeader($value);

            if ($key !== '') {
                $headers[$column] = $key;
            }
        }

        return $headers;
    }

    private function mapRow(array $headers, array $row): array
    {
        $data = [];
        $pallet = null;

        foreach ($headers as $column => $header) {
            $value = $this->cleanValue($row[$column] ?? null);

            if ($header === 'pallet') {
                $pallet = $value;
                continue;
            }

            if (in_array($header, $this->columns, true)) {
                $data[$header] = $this->castValue($header, $value);
            }
        }

        if ($pallet) {
            $data['observaciones'] = trim(($data['observaciones'] ?? '')."\nPallet: ".$pallet);
        }

        return array_intersect_key($data, array_flip($this->columns));
    }

    private function normalizeHeader($header): string
    {
        $header = trim((string) $header);
        $header = mb_strtolower($header);

        return $this->headerMap[$header] ?? $header;
    }

    private function cleanValue($value)
    {
        if ($value === null) {
            return null;
        }

        $value = is_string($value) ? trim($value) : $value;

        if ($value === '' || $value === '#N/A' || mb_strtoupper((string) $value) === 'NULL') {
            return null;
        }

        return $value;
    }

    private function castValue(string $column, $value)
    {
        if ($value === null) {
            return null;
        }

        if (in_array($column, ['FSC', 'solapa', 'guardas', 'cd', 'novedad'], true)) {
            return $this->toBoolean($value);
        }

        if (in_array($column, ['cliente_id', 'tipo', 'idioma_id', 'caja_id', 'udxcaja'], true)) {
            return (int) $value;
        }

        if (in_array($column, ['preciocoste', 'precioventa'], true)) {
            return (float) str_replace(',', '.', (string) $value);
        }

        return (string) $value;
    }

    private function toBoolean($value): ?int
    {
        if ($value === null) {
            return null;
        }

        $value = mb_strtolower(trim((string) $value));

        return in_array($value, ['1', 'yes', 'si', 'sí', 'true', 'x'], true) ? 1 : 0;
    }

    private function isEmptyRow(array $data): bool
    {
        return collect($data)->filter(fn ($value) => $value !== null && $value !== '')->isEmpty();
    }

    private function validateRow(array $data): array
    {
        $errors = [];

        if (empty($data['referencia'])) {
            $errors[] = 'referencia es obligatoria';
        }

        foreach (['cliente_id' => 'entidades', 'caja_id' => 'cajas', 'idioma_id' => 'idiomas'] as $column => $table) {
            if (! empty($data[$column]) && ! DB::table($table)->where('id', $data[$column])->exists()) {
                $errors[] = "{$column}={$data[$column]} no existe en {$table}";
            }
        }

        return $errors;
    }
}
