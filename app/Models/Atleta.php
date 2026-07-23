<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atleta extends Model
{
    protected $fillable = [
        'nome',
        'conhecido_como',
        'data_nascimento',
        'modalidade',
        'pagamento',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
            'modalidade' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    private static function decodeModalidade($value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return [];
    }

    protected static function booted(): void
    {
        static::created(function (Atleta $atleta) {
            $modalidades = implode(', ', $atleta->modalidade ?? []);
            $conhecido = $atleta->conhecido_como ? ' (apelido: ' . $atleta->conhecido_como . ')' : '';
            ActivityLog::log(
                'atleta_criado',
                'Atleta "' . $atleta->nome . '"' . $conhecido . ' foi criado (Modalidades: ' . $modalidades . ')',
                Atleta::class,
                $atleta->id,
                ['nome' => $atleta->nome, 'conhecido_como' => $atleta->conhecido_como, 'modalidade' => $atleta->modalidade]
            );
        });

        static::updated(function (Atleta $atleta) {
            $changes = $atleta->getChanges();
            $logs = [];

            if (isset($changes['nome'])) {
                $logs[] = 'Nome alterado de "' . $changes['nome'] . '" para "' . $atleta->nome . '"';
            }

            if (isset($changes['conhecido_como'])) {
                $old = $changes['conhecido_como'] ?? '(vazio)';
                $new = $atleta->conhecido_como ?? '(vazio)';
                $logs[] = 'Apelido alterado de "' . $old . '" para "' . $new . '"';
            }

            if (isset($changes['modalidade'])) {
                $oldMods = self::decodeModalidade($changes['modalidade']);
                $newMods = self::decodeModalidade($atleta->modalidade);

                $adicionadas = array_values(array_diff($newMods, $oldMods));
                $removidas = array_values(array_diff($oldMods, $newMods));

                if (!empty($adicionadas)) {
                    $logs[] = 'Modalidade(s) adicionada(s): ' . implode(', ', $adicionadas);
                }
                if (!empty($removidas)) {
                    $logs[] = 'Modalidade(s) removida(s): ' . implode(', ', $removidas);
                }
                if (!empty($adicionadas) && !empty($removidas)) {
                    $logs[] = 'Modalidades ficou: ' . implode(', ', $newMods);
                } elseif (empty($adicionadas) && empty($removidas)) {
                    $logs[] = 'Modalidades: ' . implode(', ', $newMods);
                }
            }

            if (isset($changes['pagamento'])) {
                $status = $atleta->pagamento ? 'Pago' : 'Pendente';
                $logs[] = 'Pagamento marcado como ' . $status;
            }

            if (isset($changes['data_nascimento'])) {
                $logs[] = 'Data de nascimento alterada';
            }

            if (!empty($logs)) {
                $description = 'Atleta "' . $atleta->nome . '": ' . implode(' | ', $logs);
                ActivityLog::log(
                    'atleta_atualizado',
                    $description,
                    Atleta::class,
                    $atleta->id,
                    $changes
                );
            }
        });

        static::deleted(function (Atleta $atleta) {
            ActivityLog::log(
                'atleta_removido',
                'Atleta "' . $atleta->nome . '" foi removido (Modalidades: ' . implode(', ', $atleta->modalidade ?? []) . ')',
                Atleta::class,
                $atleta->id,
                ['nome' => $atleta->nome]
            );
        });
    }
}
