<?php

namespace App\Helpers;

use Illuminate\Filesystem\Filesystem;
use Storage;
use Str;

class StorageHelper
{
    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    protected function getName($file, $showExtension = true)
    {
        if ($showExtension) {
            return $this->fileSystem->basename($file);
        } else {
            return $this->fileSystem->name($file);
        }
    }

    protected function getExtension($file, $isUploadedFile = true, $isExternal)
    {
        if ($isUploadedFile) {
            return $file->extension();
        } else {
            if ($isExternal) {
                return $this->fileSystem->extension($file);
            } else {
                preg_match("/^data:image\/(.*);base64/i", $file, $match);

                return $match[1];
            }
        }
    }

    protected function getURL($file)
    {
        // $visibility = Storage::getVisibility($file);

        // if ($visibility == 'public') {
        return Storage::url($file);
        // } else {
        //     return Storage::temporaryUrl($file, now()->addMinutes(15));
        // }
    }

    protected function getBlob($file)
    {
        $content = Storage::get($file);
        $blob = base64_encode($content);
        $extension = $this->getExtension($file, false, true);

        return "data:image/$extension;base64,". $blob;
    }

    protected function generateUniqueName()
    {
        return (string) Str::uuid();
    }

    public function get($path, $filter = [], $loopSubFolder = false, $outputURL = true)
    {
        // loop all images
        if ($loopSubFolder) {
            $files = Storage::allFiles($path);
        } else {
            $files = Storage::files($path);
        }

        // get meta from image
        $images = [];
        foreach ($files as $file) {
            // prepare variables
            $name = $this->getName($file);
            $extension = $this->getExtension($file, false, true);

            // skip mac system files & do filter
            if ($extension == 'DS_Store' || ($filter && ! in_array($name, $filter))) {
                continue;
            }

            // output
            $images[] = [
                'name' => $name,
                'data' => $outputURL ? $this->getURL($file) : $this->getBlob($file),
            ];
        }

        return $images;
    }

    public function add($path, $files, $wipeExisting = false, $isExternal = false)
    {
        if ($wipeExisting) {
            Storage::deleteDirectory($path);
        }

        $paths = [];
        foreach ($files as $file) {
            $isUploadedFile = $this->fileSystem->isFile($file);

            if ($isUploadedFile) {
                $paths[] = Storage::putFile($path, $file);
            } else {
                $name = $this->generateUniqueName();
                $extension = $this->getExtension($file, $isUploadedFile, $isExternal);
                $path = $path .'/'. $name .'.'. $extension;

                if ($isExternal) {
                    $file = file_get_contents($file);
                } else {
                    $file = base64_decode(explode(',', $file)[1]);
                }

                Storage::put($path, $file);
                $paths[] = $path;
            }
        }

        return $paths;
    }

    public function copyDirectory($oldPath, $newPath)
    {
        // get source files
        $files = Storage::files($oldPath);

        // add to new directory
        foreach ($files as $file) {
            $fileContent = Storage::get($file);
            $name = $this->generateUniqueName();
            $extension = $this->getExtension($file, false, true);
            $newPath = $newPath .'/'. $name .'.'. $extension;

            Storage::put($newPath, $fileContent);
        }
    }

    public function delete($path, $names = [])
    {
        if ($names) {
            $files = Storage::files($path);

            foreach ($files as $file) {
                $name = $this->getName($file);

                if (in_array($name, $names)) {
                    Storage::delete($file);
                }
            }
        } else {
            Storage::deleteDirectory($path);
        }
    }
}
