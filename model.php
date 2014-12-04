<?php

require_once 'config' . DIRECTORY_SEPARATOR . 'config.db.local.php';

class MainModel {

    private $db_host = '';
    private $db_name = '';
    private $PDO = null;
    private $db_user = '';
    private $db_pass = '';
    private $db_charset = '';

    public function __construct() {

        // constants
        $this->set('db_host', _DB_HOST);
        $this->set('db_name', _DB_NAME);
        $this->set('db_user', _DB_USER);
        $this->set('db_pass', _DB_PASS);
        $this->set('db_charset', _DB_CHARSET);
    }

    private function set($property, $value) {
        $this->$property = $value;
    }

    public function get($property) {
        return $this->$property;
    }

    public function getContent($content_id = '') {

        if (!$content_id) {
            return '';
        }

        $PDO = $this->connectToDbAndGetConnection();

        $q = 'SELECT content FROM articles WHERE id=:content_id ORDER BY `order` ASC LIMIT 1';
        $PDOStatement = $PDO->prepare($q);
        $PDOStatement->bindValue('content_id', $content_id, PDO::PARAM_STR);
        $PDOStatement->execute();

        return $PDOStatement->fetchColumn();
    }

    private function connectToDbAndGetConnection() {

        if (isset($this->PDO) && ($this->PDO instanceof PDO)) {
            return $this->PDO;
        }

        try {
            $dbh = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_user, $this->db_pass);
            $dbh->exec("set names " . $this->db_charset);
        } catch (PDOException $e) {
            //print "Error!: " . $e->getMessage() . "<br />";
            die();
        }


        // Datetime
        $now = new DateTime();
        $mins = $now->getOffset() / 60;
        $sgn = ($mins < 0 ? -1 : 1);
        $mins = abs($mins);
        $hrs = floor($mins / 60);
        $mins -= $hrs * 60;
        $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);

        $dbh->exec("SET time_zone='$offset'");

        $this->PDO = $dbh;
        return $this->PDO;
    }

    public function uploadFiles($comment_id = null) {

        $input_name_files = 'attachments';

        if (!isset($comment_id)) {
            return;
        }

        // dir (original)
        $path = $this->getUploadedFilesPath($comment_id);

        if (!is_dir($path)) {
            $dir_success = mkdir($path, 0777, true);
        } else {
            $dir_success = true;
        }

        if (!$dir_success) {
            return false;
        }


        // dir (thumbnail)
        $path_thumbnail = $this->getUploadedFilesPath($comment_id, 'filesystem', 'thumbnail');

        if (!is_dir($path_thumbnail)) {
            $dir_success = mkdir($path_thumbnail, 0777, true);
        } else {
            $dir_success = true;
        }

        if (!$dir_success) {
            return false;
        }


        // dir (lightbox)
        $path_lightbox = $this->getUploadedFilesPath($comment_id, 'filesystem', 'lightbox');

        if (!is_dir($path_lightbox)) {
            $dir_success = mkdir($path_lightbox, 0777, true);
        } else {
            $dir_success = true;
        }

        if (!$dir_success) {
            return false;
        }


        // upload
        $count = 0;
        foreach ($_FILES[$input_name_files]['name'] as $f => $name) {

            $new_name = strtolower(preg_replace('/[^a-zA-Z0-9\.]/', '-', $_FILES[$input_name_files]["name"][$f]));
            $new_name = pathinfo($new_name, PATHINFO_FILENAME) . '-' . time() . '.' . pathinfo($new_name, PATHINFO_EXTENSION);

            $new_path_name = ($path . DIRECTORY_SEPARATOR . $new_name);

            if (!move_uploaded_file($_FILES[$input_name_files]["tmp_name"][$f], $new_path_name)) {
                continue;
            }

            // move/create thumbnails
            $resizedFile = ($path_thumbnail . DIRECTORY_SEPARATOR . $new_name);
            $this->smart_resize_image($new_path_name, null, 100, 100, true, $resizedFile, false, false, 100);

            // move/create lightbox images
            $resizedFile = ($path_lightbox . DIRECTORY_SEPARATOR . $new_name);
            $this->smart_resize_image($new_path_name, null, 1920, 1080, true, $resizedFile, false, false, 100);


            $count++; // Number of successfully uploaded file
        }
    }

    /**
     * easy image resize function
     * @param $file - file name to resize
     * @param $string - The image data, as a string
     * @param $width - new image width
     * @param $height - new image height
     * @param $proportional - keep image proportional, default is no
     * @param $output - name of the new file (include path if needed)
     * @param $delete_original - if true the original image will be deleted
     * @param $use_linux_commands - if set to true will use "rm" to delete the image, if false will use PHP unlink
     * @param $quality - enter 1-100 (100 is best quality) default is 100
     * @return boolean|resource
     */
    private function smart_resize_image($file, $string = null, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false, $quality = 100
    ) {
        if ($height <= 0 && $width <= 0)
            return false;
        if ($file === null && $string === null)
            return false;
# Setting defaults and meta
        $info = $file !== null ? getimagesize($file) : getimagesizefromstring($string);
        $image = '';
        $final_width = 0;
        $final_height = 0;
        list($width_old, $height_old) = $info;
        $cropHeight = $cropWidth = 0;
# Calculating proportionality
        if ($proportional) {
            if ($width == 0)
                $factor = $height / $height_old;
            elseif ($height == 0)
                $factor = $width / $width_old;
            else
                $factor = min($width / $width_old, $height / $height_old);
            $final_width = round($width_old * $factor);
            $final_height = round($height_old * $factor);
        }
        else {
            $final_width = ( $width <= 0 ) ? $width_old : $width;
            $final_height = ( $height <= 0 ) ? $height_old : $height;
            $widthX = $width_old / $width;
            $heightX = $height_old / $height;
            $x = min($widthX, $heightX);
            $cropWidth = ($width_old - $width * $x) / 2;
            $cropHeight = ($height_old - $height * $x) / 2;
        }
# Loading image to memory according to type
        switch ($info[2]) {
            case IMAGETYPE_JPEG: $file !== null ? $image = imagecreatefromjpeg($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_GIF: $file !== null ? $image = imagecreatefromgif($file) : $image = imagecreatefromstring($string);
                break;
            case IMAGETYPE_PNG: $file !== null ? $image = imagecreatefrompng($file) : $image = imagecreatefromstring($string);
                break;
            default: return false;
        }
# This is the resizing/resampling/transparency-preserving magic
        $image_resized = imagecreatetruecolor($final_width, $final_height);
        if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
            $transparency = imagecolortransparent($image);
            $palletsize = imagecolorstotal($image);
            if ($transparency >= 0 && $transparency < $palletsize) {
                $transparent_color = imagecolorsforindex($image, $transparency);
                $transparency = imagecolorallocate($image_resized, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
                imagefill($image_resized, 0, 0, $transparency);
                imagecolortransparent($image_resized, $transparency);
            } elseif ($info[2] == IMAGETYPE_PNG) {
                imagealphablending($image_resized, false);
                $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                imagefill($image_resized, 0, 0, $color);
                imagesavealpha($image_resized, true);
            }
        }
        imagecopyresampled($image_resized, $image, 0, 0, $cropWidth, $cropHeight, $final_width, $final_height, $width_old - 2 * $cropWidth, $height_old - 2 * $cropHeight);
# Taking care of original, if needed
        if ($delete_original) {
            if ($use_linux_commands)
                exec('rm ' . $file);
            else
                @unlink($file);
        }
# Preparing a method of providing result
        switch (strtolower($output)) {
            case 'browser':
                $mime = image_type_to_mime_type($info[2]);
                header("Content-type: $mime");
                $output = NULL;
                break;
            case 'file':
                $output = $file;
                break;
            case 'return':
                return $image_resized;
                break;
            default:
                break;
        }
# Writing image according to type to the output destination and image quality
        switch ($info[2]) {
            case IMAGETYPE_GIF: imagegif($image_resized, $output);
                break;
            case IMAGETYPE_JPEG: imagejpeg($image_resized, $output, $quality);
                break;
            case IMAGETYPE_PNG:
                $quality = 9 - (int) ((0.9 * $quality) / 10.0);
                imagepng($image_resized, $output, $quality);
                break;
            default: return false;
        }
        return true;
    }

    private function getUploadedFilesPath($comment_id = null, $type = 'filesystem', $subdir = '') {

        if (!isset($comment_id)) {
            return null;
        }

        switch ($type) {
            case 'filesystem':
                if ($subdir) {
                    $subdir = DIRECTORY_SEPARATOR . $subdir;
                } else {
                    $subdir = '';
                }
                return pathinfo(__FILE__, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $comment_id . $subdir;
                break;
            case 'url':
                if ($subdir) {
                    $subdir = '/' . $subdir;
                } else {
                    $subdir = '';
                }
                return '/uploads/' . $comment_id . $subdir;
                break;
            default:
                return null;
        }
    }

    public function postComment() {

        $PDO = $this->connectToDbAndGetConnection();

        $q = 'INSERT INTO `comments_on_intro` (`nickname`, `message`) VALUES (:nickname, :message)';
        $PDOStatement = $PDO->prepare($q);

        $nickname = trim($_REQUEST['nickname']);
        $PDOStatement->bindValue(':nickname', $nickname, PDO::PARAM_STR);

        $message = trim($_REQUEST['message']);
        $PDOStatement->bindValue(':message', $message, PDO::PARAM_STR);
        if ($PDOStatement->execute()) {

            return $PDO->lastInsertId();
        }

        return null;
    }

    public function getAllMessages() {

        $PDO = $this->connectToDbAndGetConnection();

        $q = 'SELECT * FROM comments_on_intro ORDER BY `updated` ASC';
        $PDOStatement = $PDO->prepare($q);
        $PDOStatement->execute();

        return $PDOStatement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMessageFiles($message_id = null, $subdir = '') {

        if (!isset($message_id)) {
            return array();
        }

        $path = $this->getUploadedFilesPath($message_id, 'filesystem', $subdir);
        if (!$path) {
            return array(); // PATH klaida?
        }

        if (!is_dir($path)) {
            return array();
        }

        $files = scandir($path);
        if (!$files || !is_array($files)) {
            return array();
        }

        $files_urls = array();
        foreach ($files as $key => $filename) {

            if (in_array($filename, array('.', '..')) || is_dir($path . DIRECTORY_SEPARATOR . $filename)) {
                continue;
            }

            $path_url = $this->getUploadedFilesPath($message_id, 'url', $subdir);

            if (!isset($path_url)) {
                continue;
            }

            $files_urls[$filename] = $path_url . '/' . urlencode($filename);
        }

        return $files_urls;
    }

    public function getValidPasswords() {

        $PDO = $this->connectToDbAndGetConnection();

        $q = 'SELECT DISTINCT pp.`password` FROM passwords_public as pp';
        $PDOStatement = $PDO->prepare($q);
        $PDOStatement->execute();

        $passwords_public = array();
        while ($row = $PDOStatement->fetchObject()) {
            $passwords_public[] = $row->password;
        }

        return $passwords_public;
    }

}
