<?php

/** @var int $currentStep */

$steps = [
    1 => 'Register',
    2 => 'Security Code',
    3 => 'User Profile',
    4 => 'Thank You',
];
?>

<div class="stepper">
    <?php foreach ($steps as $step => $label): ?>
        <div class="stepper-block text-center">
            <div class="stepper-item <?= $currentStep === $step ? 'active' : ($currentStep > $step ? 'completed' : '') ?>">
                <?= $step ?>
            </div>
            <div class="stepper-label">
                <?= $label ?>
            </div>
        </div>
        <?php if ($step < count($steps)): ?>
            <div class="stepper-line <?= $currentStep > $step ? 'filled' : '' ?>"></div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
