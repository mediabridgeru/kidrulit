<?php
class ModelToolImage extends Model {
    /**
     * @param $filename
     * @param $width
     * @param $height
     * @return string|void
     */
    public function resize($filename, $width, $height) {
        $ciryllic = $this->isRussian($filename);

        $file_path = DIR_IMAGE . $filename;

        if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0 && $ciryllic) {
            mb_internal_encoding("Windows-1251");
            $filename = mb_convert_encoding($filename, "Windows-1251", "UTF-8");
            $file_path = DIR_IMAGE . $filename;
        }

        if (!is_file($file_path) || substr(str_replace('\\', '/', realpath($file_path)), 0, strlen(DIR_IMAGE)) != str_replace('\\', '/', DIR_IMAGE)) {
            return;
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $image_old = $filename;
        $image_new = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;

        if (!is_file(DIR_IMAGE . $image_new) || (filemtime(DIR_IMAGE . $image_old) > filemtime(DIR_IMAGE . $image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);

            if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
                return DIR_IMAGE . $image_old;
            }

            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir(DIR_IMAGE . $path)) {
                    @mkdir(DIR_IMAGE . $path, 0777);
                }
            }

            if ($width_orig != $width || $height_orig != $height) {
                $image = new Image(DIR_IMAGE . $image_old);
                $image->resize($width, $height);
                $image->save(DIR_IMAGE . $image_new);
            } else {
                copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
            }
        }

        if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0 && $ciryllic) {
            mb_internal_encoding("UTF-8");
            $image_new = mb_convert_encoding($image_new, "UTF-8", "Windows-1251");
        }

        if (isset($this->request->server['HTTPS']) && $this->request->server['HTTPS']) {
            return $this->config->get('config_ssl') . 'image/' . $image_new;
        } else {
            return $this->config->get('config_url') . 'image/' . $image_new;
        }
    }

    /**
     * @param $text
     * @return false|int
     */
    private function isRussian($text) {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }
}