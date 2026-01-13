<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            AuditLog::log('create', $model, null, $model->toArray());
        });

        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getChanges();
            
            // Remove timestamps from changes
            unset($newValues['updated_at']);
            
            if (!empty($newValues)) {
                AuditLog::log('update', $model, 
                    array_intersect_key($oldValues, $newValues), 
                    $newValues
                );
            }
        });

        static::deleted(function ($model) {
            AuditLog::log('delete', $model, $model->toArray(), null);
        });
    }
}
