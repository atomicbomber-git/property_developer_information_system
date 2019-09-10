<?php

namespace App\Traits;

trait CanCountRelatedModels
{
    public static function countedRelations()
    {
        return [];
    }

    public function relatedModelsCount()
    {
        $count = 0;

        foreach (self::countedRelations() as $related_entity) {
            if ($this->{"{$related_entity}_count"} === null) {
                $this->loadCount($related_entity);
            }

            $count += $this->{"{$related_entity}_count"};
        }

        return $count;
    }

    public function hasRelatedModels(): bool
    {
        return $this->relatedModelsCount() > 0;
    }
}
