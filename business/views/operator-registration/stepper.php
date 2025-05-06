<?php

/** @var int $currentStep */

$steps = [
    1 => 'Legal Entity',
    2 => 'Business Detail',
    3 => 'Bank Detail',
    4 => 'Personal',
];
?>

<div class="stepper">
    <?php foreach ($steps as $step => $label): ?>
        <div class="stepper-block text-center">
            <div class="stepper-item <?= $currentStep === $step ? 'active' : ($currentStep > $step ? 'completed' : '') ?>">
                <?= $step ?>
            </div>
        </div>
        <?php if ($step < count($steps)): ?>
            <div class="stepper-line <?= $currentStep > $step ? 'filled' : '' ?>"></div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
