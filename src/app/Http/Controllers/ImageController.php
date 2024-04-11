<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ImageController extends Controller
{
    public function upload()
    {
        foreach ($_FILES as $key => $value) {
            $files[] = $value;
        }

        $extensions = array(
            ".xbm", ".tiff", ".jfif", ".icon", ".tiff", ".gif", ".svg", ".jpeg", ".svgz",
            ".jpg,", ".webp", ".png", ".bmp", ".pjp", ".apng", ".pjpeg", ".avif"
        );

        $div = "";

        foreach ($files as $file) {
            // request()->file("file1")->store("", "images");

            $name = $file["name"];
            $name = preg_replace("/[^a-zA-Z0-9А-Яа-яЁё\.\-\_]{1,}/s", "", $name);

            preg_match("/([a-zA-ZА-Яа-яЁё0-9]{1,})([a-zA-Z0-9.]{1,})/", $name, $matches);
            $name = $matches[1];
            $extension = $matches[2];
            if (!array_search($extension, $extensions)) continue;

            $name = str_slug($name);

            $dir = preg_replace("/app\/Http\/Controllers/", "", __DIR__) . "storage/images/";

            if (!file_exists($dir)) mkdir($dir, 0755);

            if (!file_exists("{$dir}{$name}{$extension}")) {
                move_uploaded_file($file["tmp_name"], "{$dir}{$name}{$extension}");
                $image = Image::create([
                    'name' => "{$name}{$extension}"
                ]);
                $div .= "<tr>
                    <td data-id='{$image->id}'>{$image->name}</td>
                    <td>{$image->created_at}</td>
                    <td><svg height='30px' class='zip-icon' width='30px' version='1.1' id='_x32_'
                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
                            viewBox='0 0 512 512' xml:space='preserve'>
                            <style type='text/css'>
                                .st0 {
                                    fill: #000000;
                                }
                            </style>
                            <g>
                                <path class='st0'
                                    d='M378.409,0H208.294h-13.176l-9.314,9.314L57.016,138.102l-9.314,9.314v13.176v265.514
                        c0,47.36,38.528,85.895,85.895,85.895h244.811c47.36,0,85.889-38.535,85.889-85.895V85.896C464.298,38.528,425.769,0,378.409,0z
                            M432.493,426.105c0,29.877-24.214,54.091-54.084,54.091H133.598c-29.877,0-54.091-24.214-54.091-54.091V160.591h83.717
                        c24.885,0,45.07-20.178,45.07-45.07V31.804h170.115c29.87,0,54.084,24.214,54.084,54.092V426.105z' />
                                <path class='st0' d='M207.466,276.147c4.755-6.926,5.841-9.782,5.841-13.853c0-5.166-3.534-9.509-10.46-9.509h-43.464
                        c-5.977,0-9.506,3.805-9.506,8.965c0,5.159,3.529,8.825,9.506,8.825h29.339v0.272l-33.958,50.119
                        c-4.615,6.661-6.382,9.915-6.382,14.669c0,5.167,3.666,9.51,10.46,9.51h44.959c6.109,0,9.506-3.666,9.506-8.826
                        c0-5.166-3.397-8.965-9.506-8.965h-30.834v-0.272L207.466,276.147z' />
                                <path class='st0'
                                    d='M247.684,251.968c-5.841,0-10.051,4.21-10.051,10.592v72.804c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.915-4.21,9.915-10.599V262.56C257.599,256.178,253.388,251.968,247.684,251.968z' />
                                <path class='st0'
                                    d='M323.344,252.785h-28.523c-5.432,0-8.693,3.533-8.693,8.825v73.754c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.914-4.21,9.914-10.599v-22.406c0-0.545,0.272-0.817,0.817-0.817h16.433c20.102,0,32.192-12.226,32.192-29.612
                        C355.535,264.871,343.582,252.785,323.344,252.785z M322.122,294.888h-15.211c-0.545,0-0.817-0.272-0.817-0.81v-23.23
                        c0-0.545,0.272-0.816,0.817-0.816h15.211c8.42,0,13.448,5.027,13.448,12.498C335.569,290,330.542,294.888,322.122,294.888z' />
                            </g>
                        </svg></td>
                </tr>";
                continue;
            }

            if (file_exists("{$dir}{$name}_1{$extension}")) {
                $files = scandir($dir);

                $found_files = preg_grep("/{$name}_\d{1,}/", $files);

                sort($found_files, SORT_NATURAL);

                preg_replace_callback("/({$name})_(\d{1,})([a-zA-Z.]{1,})/", function ($matches) use ($file, $dir, $extension, &$div) {
                    $matches[2] = ((int)$matches[2]) + 1;
                    move_uploaded_file($file["tmp_name"], "{$dir}{$matches[1]}_{$matches[2]}{$extension}");
                    $image = Image::create([
                        'name' => "{$matches[1]}_{$matches[2]}{$extension}"
                    ]);
                    $div .= "<tr>
                    <td data-id='{$image->id}'>{$image->name}</td>
                    <td>{$image->created_at}</td>
                    <td><svg height='30px' class='zip-icon' width='30px' version='1.1' id='_x32_'
                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
                            viewBox='0 0 512 512' xml:space='preserve'>
                            <style type='text/css'>
                                .st0 {
                                    fill: #000000;
                                }
                            </style>
                            <g>
                                <path class='st0'
                                    d='M378.409,0H208.294h-13.176l-9.314,9.314L57.016,138.102l-9.314,9.314v13.176v265.514
                        c0,47.36,38.528,85.895,85.895,85.895h244.811c47.36,0,85.889-38.535,85.889-85.895V85.896C464.298,38.528,425.769,0,378.409,0z
                            M432.493,426.105c0,29.877-24.214,54.091-54.084,54.091H133.598c-29.877,0-54.091-24.214-54.091-54.091V160.591h83.717
                        c24.885,0,45.07-20.178,45.07-45.07V31.804h170.115c29.87,0,54.084,24.214,54.084,54.092V426.105z' />
                                <path class='st0' d='M207.466,276.147c4.755-6.926,5.841-9.782,5.841-13.853c0-5.166-3.534-9.509-10.46-9.509h-43.464
                        c-5.977,0-9.506,3.805-9.506,8.965c0,5.159,3.529,8.825,9.506,8.825h29.339v0.272l-33.958,50.119
                        c-4.615,6.661-6.382,9.915-6.382,14.669c0,5.167,3.666,9.51,10.46,9.51h44.959c6.109,0,9.506-3.666,9.506-8.826
                        c0-5.166-3.397-8.965-9.506-8.965h-30.834v-0.272L207.466,276.147z' />
                                <path class='st0'
                                    d='M247.684,251.968c-5.841,0-10.051,4.21-10.051,10.592v72.804c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.915-4.21,9.915-10.599V262.56C257.599,256.178,253.388,251.968,247.684,251.968z' />
                                <path class='st0'
                                    d='M323.344,252.785h-28.523c-5.432,0-8.693,3.533-8.693,8.825v73.754c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.914-4.21,9.914-10.599v-22.406c0-0.545,0.272-0.817,0.817-0.817h16.433c20.102,0,32.192-12.226,32.192-29.612
                        C355.535,264.871,343.582,252.785,323.344,252.785z M322.122,294.888h-15.211c-0.545,0-0.817-0.272-0.817-0.81v-23.23
                        c0-0.545,0.272-0.816,0.817-0.816h15.211c8.42,0,13.448,5.027,13.448,12.498C335.569,290,330.542,294.888,322.122,294.888z' />
                            </g>
                        </svg></td>
                </tr>";
                }, $found_files[count($found_files) - 1]);
            } else {
                move_uploaded_file($file["tmp_name"], "{$dir}{$name}_1{$extension}");
                $image = Image::create([
                    'name' =>  "{$name}_1{$extension}"
                ]);
                $div .= "<tr>
                    <td data-id='{$image->id}'>{$image->name}</td>
                    <td>{$image->created_at}</td>
                    <td><svg height='30px' class='zip-icon' width='30px' version='1.1' id='_x32_'
                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
                            viewBox='0 0 512 512' xml:space='preserve'>
                            <style type='text/css'>
                                .st0 {
                                    fill: #000000;
                                }
                            </style>
                            <g>
                                <path class='st0'
                                    d='M378.409,0H208.294h-13.176l-9.314,9.314L57.016,138.102l-9.314,9.314v13.176v265.514
                        c0,47.36,38.528,85.895,85.895,85.895h244.811c47.36,0,85.889-38.535,85.889-85.895V85.896C464.298,38.528,425.769,0,378.409,0z
                            M432.493,426.105c0,29.877-24.214,54.091-54.084,54.091H133.598c-29.877,0-54.091-24.214-54.091-54.091V160.591h83.717
                        c24.885,0,45.07-20.178,45.07-45.07V31.804h170.115c29.87,0,54.084,24.214,54.084,54.092V426.105z' />
                                <path class='st0' d='M207.466,276.147c4.755-6.926,5.841-9.782,5.841-13.853c0-5.166-3.534-9.509-10.46-9.509h-43.464
                        c-5.977,0-9.506,3.805-9.506,8.965c0,5.159,3.529,8.825,9.506,8.825h29.339v0.272l-33.958,50.119
                        c-4.615,6.661-6.382,9.915-6.382,14.669c0,5.167,3.666,9.51,10.46,9.51h44.959c6.109,0,9.506-3.666,9.506-8.826
                        c0-5.166-3.397-8.965-9.506-8.965h-30.834v-0.272L207.466,276.147z' />
                                <path class='st0'
                                    d='M247.684,251.968c-5.841,0-10.051,4.21-10.051,10.592v72.804c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.915-4.21,9.915-10.599V262.56C257.599,256.178,253.388,251.968,247.684,251.968z' />
                                <path class='st0'
                                    d='M323.344,252.785h-28.523c-5.432,0-8.693,3.533-8.693,8.825v73.754c0,6.388,4.21,10.599,10.051,10.599
                        c5.704,0,9.914-4.21,9.914-10.599v-22.406c0-0.545,0.272-0.817,0.817-0.817h16.433c20.102,0,32.192-12.226,32.192-29.612
                        C355.535,264.871,343.582,252.785,323.344,252.785z M322.122,294.888h-15.211c-0.545,0-0.817-0.272-0.817-0.81v-23.23
                        c0-0.545,0.272-0.816,0.817-0.816h15.211c8.42,0,13.448,5.027,13.448,12.498C335.569,290,330.542,294.888,322.122,294.888z' />
                            </g>
                        </svg></td>
                </tr>";
            }
        }

        if (!request()->expectsJson()) return $div;
    }

    public function createZip($id)
    {
        $zip = new ZipArchive;
        $image = Image::find($id);

        preg_match("/([a-zA-ZА-Яа-яЁё0-9_-]{1,})([a-zA-Z0-9.]{1,})/", $image->name, $matches);
        $name = $matches[1];
        $extension = $matches[2];

        $dir = preg_replace("/app\/Http\/Controllers/", "", __DIR__) . "storage/files/";
        if (!file_exists($dir)) mkdir($dir, 0777);

        $zip_file = "{$name}.zip";

        Storage::disk('files')->put($zip_file, "");

        if ($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $zip->addFile(public_path("images/{$name}{$extension}"), "{$name}{$extension}");
            $zip->close();
        }
        return response()->json("asd", 200);
    }

    public function download($id)
    {
        $image = Image::find($id);

        preg_match("/([a-zA-ZА-Яа-яЁё0-9_-]{1,})([a-zA-Z0-9.]{1,})/", $image->name, $matches);
        $name = $matches[1];
        $extension = $matches[2];

        $zip_file = "{$name}.zip";

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zip_file . '"');
        header('Content-Length: ' . filesize($zip_file));

        readfile($zip_file);
    }

    public function show()
    {
        $images = Image::all();
        if (request()->expectsJson()) return response()->json($images, 200);
        else return Storage::disk('images')->get("ikonka1_2.png");
    }

    public function showById($id)
    {
        $image = Image::find($id);
        $image->src = asset("images/{$image->name}");
        if (request()->expectsJson()) return response()->json($image, 200);
    }

    public function sort()
    {
        $images = request()->input('order') == 'asc' ? Image::query()->orderBy(request()->input('field'))->get() : Image::query()->orderByDesc(request()->input('field'))->get();
        if (request()->expectsJson()) return response()->json($images, 200);
        else {
            $div = "";
            foreach ($images as $image) {
                $div .=
                    "<tr>
                        <td data-id='$image->id'>$image->name</td>
                        <td>$image->created_at</td>
                        <td><svg height='30px' class='zip-icon' width='30px' version='1.1' id='_x32_'
                                xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'
                                viewBox='0 0 512 512' xml:space='preserve'>
                                <style type='text/css'>
                                    .st0 {
                                        fill: #000000;
                                    }
                                </style>
                                <g>
                                    <path class='st0'
                                        d='M378.409,0H208.294h-13.176l-9.314,9.314L57.016,138.102l-9.314,9.314v13.176v265.514
                               c0,47.36,38.528,85.895,85.895,85.895h244.811c47.36,0,85.889-38.535,85.889-85.895V85.896C464.298,38.528,425.769,0,378.409,0z
                                M432.493,426.105c0,29.877-24.214,54.091-54.084,54.091H133.598c-29.877,0-54.091-24.214-54.091-54.091V160.591h83.717
                               c24.885,0,45.07-20.178,45.07-45.07V31.804h170.115c29.87,0,54.084,24.214,54.084,54.092V426.105z' />
                                    <path class='st0' d='M207.466,276.147c4.755-6.926,5.841-9.782,5.841-13.853c0-5.166-3.534-9.509-10.46-9.509h-43.464
                               c-5.977,0-9.506,3.805-9.506,8.965c0,5.159,3.529,8.825,9.506,8.825h29.339v0.272l-33.958,50.119
                               c-4.615,6.661-6.382,9.915-6.382,14.669c0,5.167,3.666,9.51,10.46,9.51h44.959c6.109,0,9.506-3.666,9.506-8.826
                               c0-5.166-3.397-8.965-9.506-8.965h-30.834v-0.272L207.466,276.147z' />
                                    <path class='st0'
                                        d='M247.684,251.968c-5.841,0-10.051,4.21-10.051,10.592v72.804c0,6.388,4.21,10.599,10.051,10.599
                               c5.704,0,9.915-4.21,9.915-10.599V262.56C257.599,256.178,253.388,251.968,247.684,251.968z' />
                                    <path class='st0'
                                        d='M323.344,252.785h-28.523c-5.432,0-8.693,3.533-8.693,8.825v73.754c0,6.388,4.21,10.599,10.051,10.599
                               c5.704,0,9.914-4.21,9.914-10.599v-22.406c0-0.545,0.272-0.817,0.817-0.817h16.433c20.102,0,32.192-12.226,32.192-29.612
                               C355.535,264.871,343.582,252.785,323.344,252.785z M322.122,294.888h-15.211c-0.545,0-0.817-0.272-0.817-0.81v-23.23
                               c0-0.545,0.272-0.816,0.817-0.816h15.211c8.42,0,13.448,5.027,13.448,12.498C335.569,290,330.542,294.888,322.122,294.888z' />
                                </g>
                            </svg></td>
                    </tr>";
            }
            return $div;
        }
    }
}
