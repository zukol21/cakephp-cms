<?php

namespace Cms\Controller;

trait UploadTrait
{

    /**
     * Upload handler
     *
     * @param  array  $data   Request data
     * @return void|bool
     */
    protected function _isValidUpload($data = [])
    {
        $fileUpload = [];
        if (isset($data['file']) && is_array($data['file'])) {
            $fileUpload = $data['file'];
        }

        if (empty($fileUpload)) {
            return false;
        }

        if ($fileUpload['error']) {
            $this->Flash->error($this->_codeToMessage($fileUpload['error']));
            return false;
        }

        return true;
    }


    /**
     * Converts code to message.
     *
     * @see http://php.net/manual/en/features.file-upload.errors.php
     * @param  string $code code value
     * @return string Message of the code.
     */
    protected function _codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = __d('cms', 'The uploaded file exceeds the upload_max_filesize directive in php.ini');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = __d('cms', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form');
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = __d('cms', 'The uploaded file was only partially uploaded');
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = __d('cms', 'No file was uploaded');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = __d('cms', 'Missing a temporary folder');
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = __d('cms', 'Failed to write file to disk');
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = __d('cms', 'File upload stopped by extension');
                break;

            default:
                $message = __d('cms', 'Unknown upload error');
                break;
        }
        return $message;
    }
}
