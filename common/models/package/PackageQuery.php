<?php

namespace common\models\package; // Adjust if your namespace is different

use yii\db\ActiveQuery;

class PackageQuery extends ActiveQuery
{
    public function findBySlug(string $slug)
    {
        return $this->innerJoinWith('livePackage') // Or your actual relation name
            ->andWhere(['package_states.slug' => $slug]); // Or your actual table and column
    }

    // ... (rest of your custom query methods, all() and one() overrides) ...
}
