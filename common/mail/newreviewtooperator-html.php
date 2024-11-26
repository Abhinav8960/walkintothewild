<?php

use yii\helpers\Html;

?>

<html>

<body style="margin: 0; padding: 0; background-color: #ecedf1;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #ecedf1; text-align: center; padding: 20px 0;">
        <tr>
            <td>

                <table cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #ffffff; max-width: 600px; width: 100%; margin: 0 auto; border-radius: 8px; text-align: center; padding: 20px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td>
                            <h1 style="font-size: 24px; font-family: Arial, sans-serif; color: #333333; margin: 0 0 10px;">New Review</h1>
                            <table cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #ecedf1; max-width: 600px; width: 100%; margin: 0 auto; border-radius: 8px; text-align: center; padding: 20px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <tr>
                                    <td>
                                        <p style="font-size: 16px; font-family: Arial, sans-serif; color: #555555; margin: 0 0 20px;">
                                            You have recieved new review.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <a href="<?= $operator_url && isset($operator_url) ? $operator_url : '' ?>" style="display: inline-block; background-color: #09422d; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 20px; font-size: 16px; font-family: Arial, sans-serif; margin-top: 10px;">View Review</a>
                            <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
                                <p>Walk Into the Wild</p>
                            </footer>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>