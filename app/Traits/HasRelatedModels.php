<?php

namespace App\Traits;

trait HasRelatedModels
{
    public function countedRelations()
    {
        return [];
    }

    public function relatedModelsCount()
    {
        $count = 0;

        foreach ($this->countedRelations() as $related_entity) {
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
