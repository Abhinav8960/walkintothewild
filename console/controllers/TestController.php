<?php

namespace console\controllers;


use Yii;
use yii\console\Controller;

/**
 * TestController implements the CRUD actions for FrontendRequestLog model.
 */
class TestController extends Controller
{
    public function actionUploadfiletoS3()
    {
        $models = \common\models\CallLog::find()
            ->where(['file_path' => NULL])
            ->all();
            foreach($models as $model){
                if (empty($model->file_path) && !empty($model->recording_url)) {
                    try {
                        $content = file_get_contents($model->recording_url);
                        if ($content === false) {
                            throw new \Exception('Failed to fetch recording content from URL: ' . $model->recording_url);
                        }
        
                        // Determine the MIME type of the content
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $content);
                        finfo_close($finfo);
        
                        // Map MIME type to file extension
                        $extension = $this->getFileExtensionFromMimeType($mimeType);
                        if (!$extension) {
                            throw new \Exception('Unsupported MIME type: ' . $mimeType);
                        }
        
                        // Create a temporary file to store the recording content
                        $tempFilePath = tempnam(sys_get_temp_dir(), 'recording_');
                        file_put_contents($tempFilePath, $content);
        
                        // Prepare the UploadedFile instance
                        $uploadedFile = new \yii\web\UploadedFile([
                            'name' => $model->reference_id . '.' . $extension,
                            'tempName' => $tempFilePath,
                            'type' => $mimeType,
                            'size' => filesize($tempFilePath),
                            'error' => UPLOAD_ERR_OK,
                        ]);
        
                        $fileName = $model->reference_id . '.' . $extension;
                        $filePath = 'call_log/' . date('ym') . '/' . $fileName;
        
                        // Save the file using the existing helper method
                        $checksum = \common\Helper\FsHelper::saveUploadedFile($uploadedFile, $filePath, $fileName);
        
                        // Clean up the temporary file
                        unlink($tempFilePath);
        
                        if (!$checksum) {
                            throw new \Exception('Failed to upload file to S3.');
                        }
        
                        // Update the file path in the database
                        $model->file_path = $filePath;
                        $model->save(false);
                    } catch (\Exception $e) {
                        \Yii::error('Error in uploadfiletoS3: ' . $e->getMessage(), __METHOD__);
                        throw $e; // Re-throw the exception for further handling
                    }
                }
            }
    }

    private function getFileExtensionFromMimeType($mimeType)
    {
        $mimeMap = [
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/x-wav' => 'wav',
            'audio/ogg' => 'ogg',
            // Add more MIME types and extensions as needed
        ];

        return $mimeMap[$mimeType] ?? null;
    }
}
