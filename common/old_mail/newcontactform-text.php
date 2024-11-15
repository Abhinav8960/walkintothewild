<?php

use yii\helpers\Html;

?>


Hi Admin,
You have received a new contact form.

Name
<?= $contact && isset($contact['name']) ? $contact['name'] : '' ?>


Phone Number
<?= $contact && isset($contact['phone']) ? $contact['phone'] : '' ?>


Email
<?= $contact && isset($contact['email']) ? $contact['email'] : '' ?>


Message
<?= $contact && isset($contact['message']) ? $contact['message'] : '' ?>


User Device
<?= $contact && isset($contact['user_device']) ? $contact['user_device'] : '' ?>


User OS
<?= $contact && isset($contact['user_platform']) ? $contact['user_platform'] : '' ?>


User Browser
<?= $contact && isset($contact['user_browser']) ? $contact['user_browser'] : '' ?>


Thank you!
Best regards,
eam Walk into the Wild
</div>